<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignLog;
use App\Models\Contact;
use App\Models\EmailTemplate;
use App\Services\CampaignDispatcher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CampaignController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $query = Campaign::query()->with('template')->latest();

        if ($search !== '') {
            $query->where(function ($q) use ($search): void {
                $q->where('campaigns.name', 'like', '%'.$search.'%')
                    ->orWhere('campaigns.status', 'like', '%'.$search.'%')
                    ->orWhereHas('template', function ($tq) use ($search): void {
                        $tq->where('name', 'like', '%'.$search.'%');
                    });
            });
        }

        return view('campaigns.index', [
            'campaigns' => $query->paginate(10)->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('campaigns.create', [
            'templates' => EmailTemplate::orderBy('name')->get(),
            'contacts' => Contact::orderBy('name')->get(['id', 'name', 'email']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email_template_id' => ['required', 'exists:email_templates,id'],
            'contact_ids' => ['required', 'array', 'min:1'],
            'contact_ids.*' => ['integer', 'exists:contacts,id'],
            'scheduled_at' => ['nullable', 'date', 'after_or_equal:now'],
        ]);

        $contactIds = array_values(array_unique($validated['contact_ids']));
        $totalContacts = count($contactIds);
        if ($totalContacts === 0) {
            return back()->withErrors(['contact_ids' => 'Please select at least one contact.']);
        }

        $campaign = Campaign::create([
            'name' => $validated['name'],
            'email_template_id' => $validated['email_template_id'],
            'scheduled_at' => $validated['scheduled_at'] ?? null,
            'status' => empty($validated['scheduled_at']) ? 'draft' : 'scheduled',
            'total_contacts' => $totalContacts,
        ]);

        $campaign->contacts()->syncWithPivotValues($contactIds, ['status' => 'pending']);

        return redirect()
            ->route('campaigns.index')
            ->with('status', 'Campaign created successfully. Click Send to deliver emails to selected contacts.');
    }

    public function sendNow(Campaign $campaign, CampaignDispatcher $dispatcher): RedirectResponse
    {
        $pendingCount = DB::table('campaign_contact')
            ->where('campaign_id', $campaign->id)
            ->where('status', 'pending')
            ->count();

        if ($pendingCount === 0) {
            DB::table('campaign_contact')
                ->where('campaign_id', $campaign->id)
                ->update([
                    'status' => 'pending',
                    'error_message' => null,
                    'processed_at' => null,
                    'updated_at' => now(),
                ]);

            $campaign->update([
                'success_count' => 0,
                'failed_count' => 0,
                'sent_at' => null,
                'status' => 'draft',
            ]);
        }

        $dispatcher->dispatch($campaign);

        return back()->with('status', 'Campaign queued for sending.');
    }

    public function show(Request $request, Campaign $campaign): View
    {
        $campaign->load('template');

        $logSearch = trim((string) $request->query('search', ''));

        $logsQuery = CampaignLog::query()
            ->where('campaign_id', $campaign->id)
            ->latest();

        if ($logSearch !== '') {
            $logsQuery->where(function ($q) use ($logSearch): void {
                $q->where('message', 'like', '%'.$logSearch.'%')
                    ->orWhere('level', 'like', '%'.$logSearch.'%');
            });
        }

        return view('campaigns.show', [
            'campaign' => $campaign,
            'logs' => $logsQuery->paginate(20)->withQueryString(),
        ]);
    }

    protected function dispatchCampaign(Campaign $campaign): void
    {
        app(CampaignDispatcher::class)->dispatch($campaign);
    }
}

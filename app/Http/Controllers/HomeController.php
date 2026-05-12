<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Contact;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $recentQuery = Campaign::query()->with('template')->latest();

        if ($search !== '') {
            $recentQuery->where(function ($q) use ($search): void {
                $q->where('name', 'like', '%'.$search.'%')
                    ->orWhere('status', 'like', '%'.$search.'%')
                    ->orWhereHas('template', function ($tq) use ($search): void {
                        $tq->where('name', 'like', '%'.$search.'%');
                    });
            });
        }

        return view('home', [
            'stats' => [
                'contacts' => Contact::count(),
                'templates' => EmailTemplate::count(),
                'campaigns' => Campaign::count(),
                'sent' => Campaign::sum('success_count'),
                'failed' => Campaign::sum('failed_count'),
            ],
            'recentCampaigns' => $recentQuery->paginate(5)->withQueryString(),
        ]);
    }
}

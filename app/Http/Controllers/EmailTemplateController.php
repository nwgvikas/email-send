<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailTemplateController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $query = EmailTemplate::query()->latest();

        if ($search !== '') {
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', '%'.$search.'%')
                    ->orWhere('subject', 'like', '%'.$search.'%');
            });
        }

        return view('templates.index', [
            'templates' => $query->paginate(10)->withQueryString(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        EmailTemplate::create($validated);

        return back()->with('status', 'Template created successfully.');
    }

    public function show(EmailTemplate $template): View
    {
        return view('templates.show', [
            'template' => $template,
        ]);
    }

    public function edit(EmailTemplate $template): View
    {
        return view('templates.edit', [
            'template' => $template,
        ]);
    }

    public function update(Request $request, EmailTemplate $template): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        $template->update($validated);

        return redirect()
            ->route('templates.index')
            ->with('status', 'Template updated successfully.');
    }
}

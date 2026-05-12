<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $query = Contact::query()->latest();

        if ($search !== '') {
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
            });
        }

        return view('contacts.index', [
            'contacts' => $query->paginate(15)->withQueryString(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:contacts,email'],
        ]);

        Contact::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        return back()->with('status', 'Contact added successfully.');
    }

    public function edit(Contact $contact): View
    {
        return view('contacts.edit', [
            'contact' => $contact,
        ]);
    }

    public function update(Request $request, Contact $contact): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('contacts', 'email')->ignore($contact->id)],
        ]);

        $contact->update($validated);

        return redirect()
            ->route('contacts.index')
            ->with('status', 'Contact updated successfully.');
    }

    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'contacts_file' => ['required', 'file', 'mimes:csv,txt'],
        ]);

        $rows = array_map('str_getcsv', file($request->file('contacts_file')->getRealPath()));
        if (count($rows) < 2) {
            return back()->withErrors(['contacts_file' => 'CSV should have header and rows.']);
        }

        $headers = array_map(fn ($item) => strtolower(trim((string) $item)), $rows[0]);
        $imported = 0;

        foreach (array_slice($rows, 1) as $row) {
            if (count(array_filter($row, fn ($value) => trim((string) $value) !== '')) === 0) {
                continue;
            }

            $payload = [];
            foreach ($headers as $index => $header) {
                $payload[$header] = $row[$index] ?? null;
            }

            if (empty($payload['email'])) {
                continue;
            }

            $extra = $payload;
            unset($extra['name'], $extra['email']);

            Contact::updateOrCreate(
                ['email' => trim((string) $payload['email'])],
                [
                    'name' => trim((string) ($payload['name'] ?? 'Unknown')),
                    'extra_fields' => $extra ?: null,
                ]
            );

            $imported++;
        }

        return back()->with('status', "CSV import completed. Imported: {$imported} contacts.");
    }
}

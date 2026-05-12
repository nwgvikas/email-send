@extends('layouts.app')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="bo-page-header d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="mb-1">Contacts</h3>
            <p class="text-muted small mb-0">Import and manage your mailing list</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addContactModal">
                Add Contact
            </button>
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#importCsvModal">
                Import CSV
            </button>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success bo-alert shadow-sm mb-4">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger bo-alert shadow-sm mb-4">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="bo-section-head">
            <h5 class="mb-0">Contact List</h5>
            <p class="small mb-0 mt-1">All contacts in your workspace</p>
        </div>
        @include('partials.list-search', [
            'action' => route('contacts.index'),
            'placeholder' => 'Search by name or email…',
        ])
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Added</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($contacts as $contact)
                        <tr>
                            <td class="ps-4 text-muted small">{{ $contacts->firstItem() + $loop->index }}</td>
                            <td class="fw-medium">{{ $contact->name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td class="text-muted small">{{ $contact->created_at->format('d M Y') }}</td>
                            <td class="text-end pe-4">
                                <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                No contacts yet. Use <strong>Add Contact</strong> or <strong>Import CSV</strong> above.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($contacts->hasPages())
            <div class="px-4 py-3 border-top bg-light bg-opacity-50">
                {{ $contacts->links() }}
            </div>
        @endif
    </div>
</div>

<div class="modal fade" id="addContactModal" tabindex="-1" aria-labelledby="addContactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bo-modal-content">
            <div class="modal-header bo-modal-header">
                <h5 class="modal-title" id="addContactModalLabel">Add Contact</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <form method="POST" action="{{ route('contacts.store') }}" id="form-add-contact">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex gap-2 justify-content-end pt-2">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Contact</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="importCsvModal" tabindex="-1" aria-labelledby="importCsvModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bo-modal-content">
            <div class="modal-header bo-modal-header">
                <h5 class="modal-title" id="importCsvModalLabel">Import CSV</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <p class="text-muted small mb-3">CSV header example: <code class="px-2 py-1 rounded bg-light">name,email,company,city</code></p>
                <form method="POST" action="{{ route('contacts.import') }}" enctype="multipart/form-data" id="form-import-csv">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">CSV file</label>
                        <input type="file" class="form-control @error('contacts_file') is-invalid @enderror" name="contacts_file" accept=".csv,.txt" required>
                        @error('contacts_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex gap-2 justify-content-end pt-2">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Import Contacts</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if ($errors->has('contacts_file'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var el = document.getElementById('importCsvModal');
            if (el && window.bootstrap) new bootstrap.Modal(el).show();
        });
    </script>
@elseif ($errors->has('name') || $errors->has('email'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var el = document.getElementById('addContactModal');
            if (el && window.bootstrap) new bootstrap.Modal(el).show();
        });
    </script>
@endif
@endsection

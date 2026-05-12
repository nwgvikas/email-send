@extends('layouts.app')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="bo-page-header mb-4">
        <a href="{{ route('campaigns.index') }}" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-1 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/></svg>
            Back to Campaign List
        </a>
        <h3 class="mb-1">Create Campaign</h3>
        <p class="text-muted small mb-0">Choose template, recipients, and optional schedule</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger bo-alert shadow-sm mb-4">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <div class="card">
                <div class="bo-section-head">
                    <h5 class="mb-0">Campaign details</h5>
                    <p class="small mb-0 mt-1">Fields marked logically required for sending</p>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('campaigns.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Campaign Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Template</label>
                            <select name="email_template_id" class="form-select @error('email_template_id') is-invalid @enderror" required>
                                <option value="">Select template</option>
                                @foreach ($templates as $template)
                                    <option value="{{ $template->id }}" @selected(old('email_template_id') == $template->id)>{{ $template->name }}</option>
                                @endforeach
                            </select>
                            @error('email_template_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Schedule At (optional)</label>
                            <input type="datetime-local" class="form-control @error('scheduled_at') is-invalid @enderror" name="scheduled_at" value="{{ old('scheduled_at') }}">
                            @error('scheduled_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0">Select Contacts</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="select-all-contacts">
                                    <label class="form-check-label small" for="select-all-contacts">Select All</label>
                                </div>
                            </div>
                            <div class="rounded-3 p-3 bg-white" style="max-height: 280px; overflow-y: auto; border: 1px solid rgba(148, 163, 184, 0.28);">
                                @forelse ($contacts as $contact)
                                    <div class="form-check py-1">
                                        <input
                                            class="form-check-input campaign-contact"
                                            type="checkbox"
                                            name="contact_ids[]"
                                            value="{{ $contact->id }}"
                                            id="contact-{{ $contact->id }}"
                                            @checked(in_array($contact->id, old('contact_ids', []), true))
                                        >
                                        <label class="form-check-label small" for="contact-{{ $contact->id }}">
                                            <span class="fw-medium">{{ $contact->name }}</span>
                                            <span class="text-muted">({{ $contact->email }})</span>
                                        </label>
                                    </div>
                                @empty
                                    <p class="small text-muted mb-0">No contacts found. <a href="{{ route('contacts.index') }}" class="fw-semibold">Add contacts</a> first.</p>
                                @endforelse
                            </div>
                            @error('contact_ids')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex flex-wrap gap-2 justify-content-end pt-2">
                            <a href="{{ route('campaigns.index') }}" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">Save Campaign</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    (function () {
        const selectAll = document.getElementById('select-all-contacts');
        const checkboxes = document.querySelectorAll('.campaign-contact');
        if (!selectAll || !checkboxes.length) return;

        selectAll.addEventListener('change', function () {
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = selectAll.checked;
            });
        });

        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                selectAll.checked = Array.prototype.every.call(checkboxes, function (item) {
                    return item.checked;
                });
            });
        });

        selectAll.checked = Array.prototype.every.call(checkboxes, function (item) {
            return item.checked;
        }) && checkboxes.length > 0;
    })();
</script>
@endsection

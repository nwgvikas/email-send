@extends('layouts.app')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="bo-page-header d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="mb-1">Email Templates</h3>
            <p class="text-muted small mb-0">Design reusable messages with placeholders</p>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTemplateModal">
            Create Template
        </button>
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
            <h5 class="mb-0">Template Library</h5>
            <p class="small mb-0 mt-1">All saved email templates</p>
        </div>
        @include('partials.list-search', [
            'action' => route('templates.index'),
            'placeholder' => 'Search by template name or subject…',
        ])
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Created</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($templates as $template)
                        <tr>
                            <td class="ps-4 text-muted small">{{ $templates->firstItem() + $loop->index }}</td>
                            <td class="fw-medium">{{ $template->name }}</td>
                            <td>{{ $template->subject }}</td>
                            <td class="text-muted small">{{ $template->created_at->format('d M Y') }}</td>
                            <td class="text-end pe-4">
                                <div class="d-inline-flex flex-wrap gap-1 justify-content-end">
                                    <a href="{{ route('templates.show', $template) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                    <a href="{{ route('templates.edit', $template) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                No templates yet. Click <strong>Create Template</strong> to add one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($templates->hasPages())
            <div class="px-4 py-3 border-top bg-light bg-opacity-50">
                {{ $templates->links() }}
            </div>
        @endif
    </div>
</div>

<div class="modal fade" id="createTemplateModal" tabindex="-1" aria-labelledby="createTemplateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content bo-modal-content">
            <div class="modal-header bo-modal-header">
                <h5 class="modal-title" id="createTemplateModalLabel">Create Template</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <form method="POST" action="{{ route('templates.store') }}" id="form-create-template">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Template Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" value="{{ old('subject') }}" placeholder="Welcome @{{ $name }}" required>
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Body (HTML/Text)</label>
                        <textarea id="template-body-editor" class="form-control @error('body') is-invalid @enderror" rows="10" name="body" required>@if(filled(old('body'))){!! old('body') !!}@else@verbatim
Hello {{ name }}, 

Welcome to our platform. Your account has been created successfully. 

Here are your account details: Email: {{ email }} 

Thank you for joining us. 

Regards, Your Company Name
@endverbatim
@endif</textarea>
                        @error('body')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex gap-2 justify-content-end pt-3 border-top">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Template</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
(function () {
    const modalEl = document.getElementById('createTemplateModal');
    const textarea = document.querySelector('#template-body-editor');
    const form = document.getElementById('form-create-template');
    if (!modalEl || !textarea || !form) return;

    let editorInstance = null;

    function destroyEditor() {
        if (editorInstance) {
            editorInstance.destroy().catch(function () {});
            editorInstance = null;
        }
    }

    modalEl.addEventListener('shown.bs.modal', function () {
        if (editorInstance) return;
        ClassicEditor.create(textarea)
            .then(function (editor) {
                editorInstance = editor;
            })
            .catch(function (err) {
                console.error(err);
            });
    });

    modalEl.addEventListener('hidden.bs.modal', function () {
        destroyEditor();
    });

    form.addEventListener('submit', function () {
        if (editorInstance) {
            textarea.value = editorInstance.getData();
        }
    });
})();
</script>

@if ($errors->has('name') || $errors->has('subject') || $errors->has('body'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var el = document.getElementById('createTemplateModal');
            if (el && window.bootstrap) new bootstrap.Modal(el).show();
        });
    </script>
@endif
@endsection

@extends('layouts.app')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="bo-page-header mb-4">
        <a href="{{ route('templates.index') }}" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-1 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/></svg>
            Back to Templates
        </a>
        <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
            <div>
                <h3 class="mb-1">Edit Template</h3>
                <p class="text-muted small mb-0">{{ $template->name }}</p>
            </div>
            <a href="{{ route('templates.show', $template) }}" class="btn btn-outline-secondary btn-sm">View preview</a>
        </div>
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
        <div class="col-lg-9 col-xl-8">
            <div class="card">
                <div class="bo-section-head">
                    <h5 class="mb-0">Template fields</h5>
                    <p class="small mb-0 mt-1">Use placeholders such as @{{ $name }} and @{{ $email }} in subject and body</p>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('templates.update', $template) }}" id="form-edit-template">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Template Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $template->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" value="{{ old('subject', $template->subject) }}" required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Body (HTML/Text)</label>
                            <textarea id="template-body-editor-edit" class="form-control @error('body') is-invalid @enderror" rows="12" name="body" required>{!! old('body', $template->body) !!}</textarea>
                            @error('body')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex flex-wrap gap-2 justify-content-end">
                            <a href="{{ route('templates.index') }}" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">Update template</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var el = document.querySelector('#template-body-editor-edit');
    var form = document.getElementById('form-edit-template');
    if (!el || !form) return;

    ClassicEditor.create(el)
        .then(function (editor) {
            form.addEventListener('submit', function () {
                el.value = editor.getData();
            });
        })
        .catch(function (err) {
            console.error(err);
        });
});
</script>
@endsection

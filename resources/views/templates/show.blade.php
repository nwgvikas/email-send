@extends('layouts.app')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="bo-page-header d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <a href="{{ route('templates.index') }}" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-1 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/></svg>
                Back to Templates
            </a>
            <h3 class="mb-1">{{ $template->name }}</h3>
            <p class="text-muted small mb-0">Read-only preview</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('templates.edit', $template) }}" class="btn btn-primary">Edit</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="bo-section-head">
            <h5 class="mb-0">Subject line</h5>
        </div>
        <div class="card-body p-4">
            <p class="mb-0 fw-medium" style="font-size: 1.05rem;">{{ $template->subject }}</p>
        </div>
    </div>

    <div class="card">
        <div class="bo-section-head">
            <h5 class="mb-0">Body preview</h5>
            <p class="small mb-0 mt-1">HTML as stored; merge tags show as written in the editor.</p>
        </div>
        <div class="card-body p-4">
            <div class="border rounded-3 p-4 bg-white" style="min-height: 200px; max-height: 70vh; overflow: auto; border-color: rgba(148, 163, 184, 0.35) !important;">
                {!! $template->body !!}
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="bo-page-header d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="mb-1">Campaigns</h3>
            <p class="text-muted small mb-0">Create sends and track delivery</p>
        </div>
        <a href="{{ route('campaigns.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg>
            Create Campaign
        </a>
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
            <h5 class="mb-0">Campaign List</h5>
            <p class="small mb-0 mt-1">All campaigns and delivery status</p>
        </div>
        @include('partials.list-search', [
            'action' => route('campaigns.index'),
            'placeholder' => 'Search by campaign, status, or template…',
        ])
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Name</th>
                        <th>Template</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Success</th>
                        <th>Failed</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($campaigns as $campaign)
                        <tr>
                            <td class="ps-4 text-muted small">{{ $campaigns->firstItem() + $loop->index }}</td>
                            <td class="fw-medium">{{ $campaign->name }}</td>
                            <td>{{ $campaign->template->name }}</td>
                            <td>
                                <span class="badge rounded-pill bg-light text-dark border px-3 py-2 fw-semibold" style="font-size: 0.7rem;">{{ $campaign->status }}</span>
                            </td>
                            <td>{{ $campaign->total_contacts }}</td>
                            <td class="text-success fw-semibold">{{ $campaign->success_count }}</td>
                            <td class="text-danger fw-semibold">{{ $campaign->failed_count }}</td>
                            <td class="text-end pe-4">
                                <div class="d-inline-flex flex-wrap gap-1 justify-content-end">
                                    <a href="{{ route('campaigns.show', $campaign) }}" class="btn btn-sm btn-outline-secondary">Logs</a>
                                    <form method="POST" action="{{ route('campaigns.send', $campaign) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary">Send</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                No campaigns yet. Use <strong>Create Campaign</strong> to add one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($campaigns->hasPages())
            <div class="px-4 py-3 border-top bg-light bg-opacity-50">
                {{ $campaigns->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    @if (session('status'))
        <div class="alert alert-success bo-alert shadow-sm mb-4">{{ session('status') }}</div>
    @endif

    <div class="bo-page-header mb-4">
        <div class="bo-hero">
            <h2 class="mb-2">{{ __('Bulk Email Dashboard') }}</h2>
            <p class="mb-0">Manage contacts, templates, campaigns, and queued email delivery from one place.</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-6 col-xl-3">
            <div class="bo-stat-card">
                <div class="bo-stat-label">Total Contacts</div>
                <div class="bo-stat-value text-primary">{{ $stats['contacts'] }}</div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="bo-stat-card">
                <div class="bo-stat-label">Templates</div>
                <div class="bo-stat-value" style="color: #5b21b6;">{{ $stats['templates'] }}</div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="bo-stat-card">
                <div class="bo-stat-label">Sent Emails</div>
                <div class="bo-stat-value text-success">{{ $stats['sent'] }}</div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="bo-stat-card">
                <div class="bo-stat-label">Failed Emails</div>
                <div class="bo-stat-value text-danger">{{ $stats['failed'] }}</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="bo-section-head d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h5 class="mb-0">Recent Campaigns</h5>
                <p class="small mb-0 mt-1">Latest activity across your campaigns</p>
            </div>
            <a href="{{ route('campaigns.index') }}" class="btn btn-sm btn-outline-primary">View all</a>
        </div>
        @include('partials.list-search', [
            'action' => route('home'),
            'placeholder' => 'Search recent campaigns…',
        ])
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Name</th>
                        <th>Template</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Success</th>
                        <th class="pe-4">Failed</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentCampaigns as $campaign)
                        <tr>
                            <td class="ps-4 fw-medium">{{ $campaign->name }}</td>
                            <td>{{ $campaign->template->name }}</td>
                            <td><span class="badge rounded-pill bg-secondary-subtle text-secondary-emphasis border">{{ $campaign->status }}</span></td>
                            <td>{{ $campaign->total_contacts }}</td>
                            <td class="text-success fw-semibold">{{ $campaign->success_count }}</td>
                            <td class="text-danger fw-semibold pe-4">{{ $campaign->failed_count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">No campaigns created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($recentCampaigns->hasPages())
            <div class="px-4 py-3 border-top bg-light bg-opacity-50">
                {{ $recentCampaigns->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

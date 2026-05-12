@extends('layouts.app')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="bo-page-header d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="mb-1">Campaign Logs</h3>
            <p class="text-muted small mb-0">{{ $campaign->name }}</p>
        </div>
        <a href="{{ route('campaigns.index') }}" class="btn btn-outline-secondary">Back to list</a>
    </div>

    <div class="card mb-4">
        <div class="bo-section-head">
            <h5 class="mb-0">Summary</h5>
            <p class="small mb-0 mt-1">Overview for this campaign</p>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.06em;">Template</div>
                    <div class="fw-medium mt-1">{{ $campaign->template->name }}</div>
                </div>
                <div class="col-md-4">
                    <div class="text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.06em;">Status</div>
                    <div class="mt-1"><span class="badge rounded-pill bg-light text-dark border px-3 py-2">{{ $campaign->status }}</span></div>
                </div>
                <div class="col-md-4">
                    <div class="text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.06em;">Recipients</div>
                    <div class="fw-medium mt-1">{{ $campaign->total_contacts }} total</div>
                </div>
                <div class="col-md-4">
                    <div class="text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.06em;">Success</div>
                    <div class="fs-5 fw-bold text-success mt-1">{{ $campaign->success_count }}</div>
                </div>
                <div class="col-md-4">
                    <div class="text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.06em;">Failed</div>
                    <div class="fs-5 fw-bold text-danger mt-1">{{ $campaign->failed_count }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="bo-section-head">
            <h5 class="mb-0">Delivery logs</h5>
            <p class="small mb-0 mt-1">Paginated send attempts and errors (queue worker output)</p>
        </div>
        @include('partials.list-search', [
            'action' => route('campaigns.show', $campaign),
            'placeholder' => 'Search by message or level…',
        ])
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Time</th>
                        <th>Level</th>
                        <th>Message</th>
                        <th class="pe-4">Context</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <td class="ps-4 text-muted small">{{ $logs->firstItem() + $loop->index }}</td>
                            <td class="text-muted small">{{ $log->created_at->format('d M Y h:i A') }}</td>
                            <td>
                                <span class="badge rounded-pill {{ $log->level === 'error' ? 'text-bg-danger' : 'text-bg-success' }} px-3">{{ $log->level }}</span>
                            </td>
                            <td>{{ $log->message }}</td>
                            <td class="pe-4"><code class="small bg-light px-2 py-1 rounded">{{ json_encode($log->context ?? []) }}</code></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">No logs match your search.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($logs->hasPages())
            <div class="px-4 py-3 border-top bg-light bg-opacity-50">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

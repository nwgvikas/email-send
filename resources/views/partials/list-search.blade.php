@php
    $placeholder = $placeholder ?? 'Search…';
@endphp
<form method="GET" action="{{ $action }}" class="d-flex flex-wrap align-items-center gap-2 py-3 px-4 border-bottom bo-table-toolbar">
    <div class="flex-grow-1" style="min-width: 200px; max-width: 400px;">
        <div class="input-group">
            <span class="input-group-text bg-white border-end-0 text-muted">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>
            </span>
            <input
                type="search"
                name="search"
                value="{{ request('search') }}"
                class="form-control border-start-0"
                placeholder="{{ $placeholder }}"
                autocomplete="off"
            >
        </div>
    </div>
    <button type="submit" class="btn btn-primary btn-sm px-3">Search</button>
    @if (request()->filled('search'))
        <a href="{{ $action }}" class="btn btn-link btn-sm text-decoration-none text-muted">Clear</a>
    @endif
</form>

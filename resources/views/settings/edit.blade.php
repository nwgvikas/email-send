@extends('layouts.app')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="bo-page-header mb-4">
        <h3 class="mb-1">General settings</h3>
        <p class="text-muted small mb-0">Website name, logo, and favicon used on the landing page, login, admin panel, and outgoing emails.</p>
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

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="bo-section-head">
                    <h5 class="mb-0">Branding</h5>
                    <p class="small mb-0 mt-1">Recommended logo: square PNG/SVG, max ~2&nbsp;MB. Favicon: ICO or PNG, max ~512&nbsp;KB.</p>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label">Website name</label>
                            <input type="text" name="site_name" class="form-control @error('site_name') is-invalid @enderror" value="{{ old('site_name', $setting?->site_name ?? config('app.name')) }}" required maxlength="120">
                            @error('site_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Website logo</label>
                            <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($setting?->logo_path)
                                <div class="mt-3 d-flex align-items-center gap-3">
                                    <span class="text-muted small">Current:</span>
                                    <img src="{{ asset('storage/'.$setting->logo_path) }}" alt="Logo" class="rounded border" style="max-height: 56px; max-width: 200px; object-fit: contain;">
                                </div>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Favicon</label>
                            <input type="file" name="favicon" class="form-control @error('favicon') is-invalid @enderror" accept=".ico,.png,.gif,.jpg,.jpeg,.webp,.svg,image/*">
                            @error('favicon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($setting?->favicon_path)
                                <div class="mt-3 d-flex align-items-center gap-3">
                                    <span class="text-muted small">Current:</span>
                                    <img src="{{ asset('storage/'.$setting->favicon_path) }}" alt="Favicon" width="32" height="32" class="rounded border">
                                </div>
                            @endif
                        </div>

                        <p class="text-muted small mb-4">Ensure <code>php artisan storage:link</code> has been run so uploaded files are publicly reachable.</p>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('home') }}" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">Save settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

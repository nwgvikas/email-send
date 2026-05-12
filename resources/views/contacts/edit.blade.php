@extends('layouts.app')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="bo-page-header mb-4">
        <a href="{{ route('contacts.index') }}" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-1 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/></svg>
            Back to Contacts
        </a>
        <h3 class="mb-1">Edit Contact</h3>
        <p class="text-muted small mb-0">{{ $contact->email }}</p>
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
        <div class="col-lg-6">
            <div class="card">
                <div class="bo-section-head">
                    <h5 class="mb-0">Contact details</h5>
                    <p class="small mb-0 mt-1">Update name and email</p>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('contacts.update', $contact) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $contact->name) }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $contact->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex flex-wrap gap-2 justify-content-end">
                            <a href="{{ route('contacts.index') }}" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

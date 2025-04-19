@extends('layouts/contentNavbarLayout')

@section('title', 'Site Settings')

@section('content')
<div class="card">
    <h5 class="card-header">Update Site Settings</h5>
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('site-settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Site Name</label>
                <input type="text" name="site_name" class="form-control" value="{{ $setting->site_name }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Contact Number</label>
                <input type="text" name="contact_number" class="form-control" value="{{ $setting->contact_number }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $setting->email }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control">{{ $setting->address }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Logo</label>
                @if($setting->logo)
                <img src="{{ asset('storage/' . $setting->logo) }}" width="100" class="d-block mb-2">
                @endif
                <input type="file" name="logo" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Update Settings</button>
        </form>
    </div>
</div>
@endsection
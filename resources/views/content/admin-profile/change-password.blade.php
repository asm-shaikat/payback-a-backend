@extends('layouts/contentNavbarLayout')

@section('title', 'Account settings - Change Password')

@section('page-script')
@vite(['resources/assets/js/pages-account-settings-account.js'])
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
        @endif
        <div class="card mb-6">
            <div class="card-body pt-4">
                <form id="formChangePassword" method="POST" action="{{ route('send.admin-password-change') }}">
                    @csrf
                    <div class="row g-6">
                        <div class="col-md-6">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input class="form-control" type="password" id="current_password" name="current_password" required />
                            @error('current_password')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="new_password" class="form-label">New Password</label>
                            <input class="form-control" type="password" id="new_password" name="new_password" required />
                            @error('new_password')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input class="form-control" type="password" id="new_password_confirmation" name="new_password_confirmation" required />
                            @error('new_password_confirmation')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="btn btn-primary me-3">Change Password</button>
                        <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
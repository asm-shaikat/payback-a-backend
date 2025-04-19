@extends('layouts/contentNavbarLayout')

@section('title', 'Add Settings')

@section('page-script')
@vite(['resources/assets/js/pages-account-settings-account.js'])
@endsection

@section('content')
<div class="card">
    <h5 class="card-header">Add Setting Dropdown Values</h5>
    @if (session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
    @endif

    <div class="card-body">
        <form action="{{ route('settings.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="module" class="form-label">Module</label>
                    <input type="text" class="form-control" id="module" name="module" placeholder="Enter Module (e.g., services)" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="key" class="form-label">Key</label>
                    <select class="form-select" id="key" name="key" required>
                        <option value="scam_type">Scam Type</option>
                        <option value="transaction_type">Transaction Type</option>
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="value" class="form-label">Value</label>
                    <input type="text" class="form-control" id="value" name="value" placeholder="Enter Value (e.g., Investment Scam)" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save Setting</button>
        </form>
    </div>
</div>
@endsection
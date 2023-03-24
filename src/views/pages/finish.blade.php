@extends('laravel-installer::layouts.installer')

@section('content')
    <div id="finish" x-data="finish">
        <h4 class="text-success text-center mb-5">Installation complete successfully</h4>

        <div class="mb-5">
            <h5 class="text-danger mb-2">Remember</h5>
            <p class="mb-0">Administrators/Staff members must log in at
                <a :href="loginUrl" x-text="loginUrl"></a>
            </p>
        </div>

        <h5 class="mb-4">Getting Started Guide -
            <small><a href="{{ config('laravel-installer.guideline_url') }}" target="_blank">Read More</a></small>
        </h5>

        <h5 class="mb-4">Looking for Help? -
            <small><a href="{{ config('laravel-installer.support_url') }}" target="_blank">Open Support Ticket</a></small>
        </h5>

        <div class="text-center mt-5">
            <a :href="window.origin" class="btn btn-outline-primary">Go to Site</a>
        </div>
    </div>
@endsection

@push('custom-js')
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("finish", () => ({
                loginUrl: window.origin + '/login'
            }))
        })
    </script>
@endpush

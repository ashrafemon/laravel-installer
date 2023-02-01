@extends('laravel-installer::layouts.installer')

@section('content')
    <div id="finish">
        <h4 class="text-success text-center mb-5">Installation complete successfully</h4>

        <div class="mb-5">
            <h5 class="text-danger mb-2">Remember</h5>
            <p class="mb-0">Administrators/Staff members must log in at
                <a href="{{ env('APP_URL') }}/login">{{ env('APP_URL') }}/login</a>
            </p>
        </div>

        <h5 class="mb-4">Getting Started Guide -
            <small><a href="{{ env('APP_URL') }}/login">Read More</a></small>
        </h5>

        <h5 class="mb-4">Looking for Help? -
            <small><a href="{{ env('APP_URL') }}/login">Open Support Ticket</a></small>
        </h5>

        <div class="text-center mt-5">
            <a href="{{ env('APP_URL') }}" class="btn btn-outline-primary">Go to Site</a>
        </div>
    </div>
@endsection

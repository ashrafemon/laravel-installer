@extends('laravel-installer::layouts.installer')

@section('content')
    <div id="licence">
        <form action="{{ route('license.store') }}" method="POST">
            @csrf
            <div class="my-3">
                <label class="form-label">Select Product</label>
                <select class="form-select" aria-label="Default select example">
                    <option selected>Select Product</option>
                    <option value="1">One</option>
                </select>
            </div>
            <div>
                <label class="form-label">Licence Code</label>
                <input type="text" class="form-control">
            </div>

            <div class="text-center mt-5">
                <button class="btn btn-outline-primary">Check License</button>
            </div>
        </form>
    </div>
@endsection

@extends('laravel-installer::layouts.installer')

@section('content')
    <div id="licence">
        <form action="{{ route('license.store') }}" method="POST">
            @csrf
            <div class="my-3">
                <label class="form-label">Select Product</label>
                <select class="form-select" name="product_id" value={{ old('product_id') }}>
                    <option selected>Select Product</option>
                    @foreach ($products as $product)
                        <option {{ $product['value'] === config('laravel-installer.product_id') ? 'selected' : '' }}
                            value="{{ $product['value'] }}">{{ $product['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Licence Code</label>
                <input type="text" class="form-control" name="license" value="{{ old('license') }}">
            </div>

            <div class="text-center mt-5">
                <button class="btn btn-outline-primary">Check License</button>
            </div>
        </form>
    </div>
@endsection

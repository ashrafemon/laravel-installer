@extends('laravel-installer::layouts.installer')

@section('content')
    <div id="database">
        <form action="{{ route('database.store') }}" method="POST">
            @csrf
            <div class="row row-cols-2 gx-3 gy-4">
                <div class="col">
                    <label class="form-label">DB Host</label>
                    <input type="text" class="form-control" name="DB_HOST"
                        value="{{ $database['DB_HOST'] ?? old('DB_HOST') }}">
                </div>

                <div class="col">
                    <label class="form-label">DB Port</label>
                    <input type="text" class="form-control" name="DB_PORT"
                        value="{{ $database['DB_PORT'] ?? old('DB_PORT') }}">
                </div>

                <div class="col">
                    <label class="form-label">DB Name</label>
                    <input type="text" class="form-control" name="DB_DATABASE"
                        value="{{ $database['DB_DATABASE'] ?? old('DB_DATABASE') }}">
                </div>

                <div class="col">
                    <label class="form-label">DB Username</label>
                    <input type="text" class="form-control" name="DB_USERNAME"
                        value="{{ $database['DB_USERNAME'] ?? old('DB_USERNAME') }}">
                </div>

                <div class="col">
                    <label class="form-label">DB Password</label>
                    <input type="text" class="form-control" name="DB_PASSWORD"
                        value="{{ $database['DB_PASSWORD'] ?? old('DB_PASSWORD') }}">
                </div>
            </div>

            <div class="text-center mt-5">
                <button class="btn btn-outline-primary">Check Database</button>
            </div>
        </form>
    </div>
@endsection

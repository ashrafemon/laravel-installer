@extends('laravel-installer::layouts.installer')

@section('content')
    <div id="install">
        <form action="{{ route('install.store') }}" method="POST">
            @csrf
            <div class="row gy-3 justify-content-center">
                <div class="col-lg-6 col-sm-12">
                    <h6 class="fs-5 fw-bold py-2">Admin Login</h6>
                    <div class="row row-cols-1 gx-3 gy-4">
                        <div class="col">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
                        </div>
                        <div class="col">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">
                        </div>
                        <div class="col">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" value="{{ old('email') }}">
                        </div>
                        <div class="col">
                            <label class="form-label">Password</label>
                            <input type="text" class="form-control" name="password" value="{{ old('password') }}">
                        </div>
                        <div class="col">
                            <label class="form-label">Confirm Password</label>
                            <input type="text" class="form-control" name="password_confirmation"
                                value="{{ old('password_confirmation') }}">
                        </div>
                    </div>
                </div>

                {{-- <div class="col-lg-6 col-sm-12">
                    <h6 class="fs-5 fw-bold py-2">Demo Login</h6>
                    <div class="row row-cols-1 gx-3 gy-4">
                        <div class="col">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col">
                            <label class="form-label">Password</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col">
                            <label class="form-label">Confirm Password</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </div> --}}

                {{-- <div class="col-lg-6 col-sm-12">
                    <h6 class="fs-5 fw-bold py-2">Default Timezone</h6>
                    <div>
                        <label class="form-label">Timezone</label>
                        <select class="form-select">
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                </div> --}}
            </div>

            <div class="text-center mt-5">
                <button type="submit" class="btn btn-outline-primary">Finish</button>
            </div>
        </form>
    </div>
@endsection

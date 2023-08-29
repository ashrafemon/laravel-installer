@extends('laravel-installer::layouts.installer')

@section('content')
    <div id="install" x-data="installs">
        <form @submit.prevent="submitHandler" method="POST">
            <div class="row gy-3 justify-content-center">
                <div class="col-lg-6 col-sm-12">
                    <h6 class="fs-5 fw-bold py-2">Admin Login</h6>
                    <div class="row row-cols-1 gx-3 gy-4">
                        <div class="col">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control"
                                x-model="form.{{ config('laravel-installer.name_property') }} }}"
                                @keyup="errors.{{ config('laravel-installer.name_property') }}.show = false">

                            <template x-if="errors.{{ config('laravel-installer.name_property') }}.show">
                                <p x-text="errors.{{ config('laravel-installer.name_property') }}.text" class="text-danger">
                                </p>
                            </template>
                        </div>
                        {{-- <div class="col">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" x-model="form.last_name"
                                @keyup="errors.last_name.show = false">

                            <template x-if="errors.last_name.show">
                                <p x-text="errors.last_name.text" class="text-danger"></p>
                            </template>
                        </div> --}}
                        <div class="col">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" x-model="form.email"
                                @keyup="errors.email.show = false">

                            <template x-if="errors.email.show">
                                <p x-text="errors.email.text" class="text-danger"></p>
                            </template>
                        </div>
                        <div class="col">
                            <label class="form-label">Password</label>
                            <input type="text" class="form-control" x-model="form.password"
                                @keyup="errors.password.show = false">

                            <template x-if="errors.password.show">
                                <p x-text="errors.password.text" class="text-danger"></p>
                            </template>
                        </div>
                        <div class="col">
                            <label class="form-label">Confirm Password</label>
                            <input type="text" class="form-control" x-model="form.password_confirmation"
                                @keyup="errors.password_confirmation.show = false">

                            <template x-if="errors.password_confirmation.show">
                                <p x-text="errors.password_confirmation.text" class="text-danger"></p>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <button type="submit" class="btn btn-outline-primary" :disabled="loading"
                    x-text="loading ? 'Loading...': 'Finish'">Finish</button>
            </div>
        </form>
    </div>
@endsection

@push('custom-js')
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("installs", () => ({
                form: {
                    {{ config('laravel-installer.name_property') }}: '',
                    email: '',
                    password: '',
                },
                errors: {
                    {{ config('laravel-installer.name_property') }}: {
                        text: '',
                        show: false
                    },
                    email: {
                        text: '',
                        show: false
                    },
                    password: {
                        text: '',
                        show: false
                    },
                    password_confirmation: {
                        text: '',
                        show: false
                    },
                },
                loading: false,
                async submitHandler() {
                    this.loading = true;
                    await fetch('/api/v1/install/validate', {
                            method: "POST",
                            headers: {
                                Accept: 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(this.form)
                        })
                        .then(res => res.json())
                        .then(res => {
                            if (res.status === 'validate_error') {
                                Object.keys(res.data).forEach((key) => {
                                    if (res.data[key]) {
                                        this.errors[key] = {
                                            text: res.data[key],
                                            show: true
                                        }
                                    }
                                })
                            } else {
                                Swal.fire({
                                    title: res.message,
                                    icon: res.status === 'success' ? 'success' :
                                        'error',
                                    timer: 2500
                                })

                                if (res.status === 'success') {
                                    setTimeout(() => {
                                        window.location.href = res?.data?.url
                                    }, 1000);
                                }
                            }
                        })
                        .catch(err => console.log(err))
                    this.loading = false;
                }
            }))
        })
    </script>
@endpush

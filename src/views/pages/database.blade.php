@extends('laravel-installer::layouts.installer')

@section('content')
    <div id="database" x-data="databases">
        <form @submit.prevent="submitHandler">
            <div class="row row-cols-2 gx-3 gy-4">
                <div class="col">
                    <label class="form-label">DB Host</label>
                    <input type="text" class="form-control" x-model="form.DB_HOST" @keyup="errors.DB_HOST.show = false">

                    <template x-if="errors.DB_HOST.show">
                        <p x-text="errors.DB_HOST.text" class="text-danger"></p>
                    </template>
                </div>

                <div class="col">
                    <label class="form-label">DB Port</label>
                    <input type="text" class="form-control" x-model="form.DB_PORT" @keyup="errors.DB_PORT.show = false">

                    <template x-if="errors.DB_PORT.show">
                        <p x-text="errors.DB_PORT.text" class="text-danger"></p>
                    </template>
                </div>

                <div class="col">
                    <label class="form-label">DB Name</label>
                    <input type="text" class="form-control" x-model="form.DB_DATABASE"
                        @keyup="errors.DB_DATABASE.show = false">

                    <template x-if="errors.DB_DATABASE.show">
                        <p x-text="errors.DB_DATABASE.text" class="text-danger"></p>
                    </template>
                </div>

                <div class="col">
                    <label class="form-label">DB Username</label>
                    <input type="text" class="form-control" x-model="form.DB_USERNAME"
                        @keyup="errors.DB_USERNAME.show = false">

                    <template x-if="errors.DB_USERNAME.show">
                        <p x-text="errors.DB_USERNAME.text" class="text-danger"></p>
                    </template>
                </div>

                <div class="col">
                    <label class="form-label">DB Password</label>
                    <input type="text" class="form-control" x-model="form.DB_PASSWORD"
                        @keyup="errors.DB_PASSWORD.show = false">

                    <template x-if="errors.DB_PASSWORD.show">
                        <p x-text="errors.DB_PASSWORD.text" class="text-danger"></p>
                    </template>
                </div>
            </div>

            <div class="text-center mt-5">
                <button type="submit" class="btn btn-outline-primary" :disabled="loading"
                    x-text="loading ? 'Loading...': 'Check Database'">Check Database</button>
            </div>
        </form>
    </div>
@endsection

@push('custom-js')
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("databases", () => ({
                form: {
                    DB_HOST: '',
                    DB_PORT: '',
                    DB_DATABASE: '',
                    DB_USERNAME: '',
                    DB_PASSWORD: '',
                },
                errors: {
                    DB_HOST: {
                        text: '',
                        show: false
                    },
                    DB_PORT: {
                        text: '',
                        show: false
                    },
                    DB_DATABASE: {
                        text: '',
                        show: false
                    },
                    DB_USERNAME: {
                        text: '',
                        show: false
                    },
                    DB_PASSWORD: {
                        text: '',
                        show: false
                    },
                },
                loading: false,
                async init() {
                    this.loading = true;
                    await fetch('/api/v1/databases', {
                            method: "GET",
                            headers: {
                                Accept: 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(res => {
                            if (res.status === 'success') {
                                Object.keys(res.data).forEach((key) => {
                                    if (res.data[key]) {
                                        this.form[key] = res.data[key]
                                    }
                                })
                            }
                        })
                        .catch(err => console.log(err))
                    this.loading = false;
                },
                async saveDatabase() {
                    this.loading = true;
                    await fetch('/api/v1/databases/validate', {
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
                        .catch(err => {
                            console.log(err)
                            this.saveDatabase()
                        })
                    this.loading = false;
                },
                async submitHandler() {
                    this.saveDatabase()
                }
            }))
        })
    </script>
@endpush

@extends('laravel-installer::layouts.installer')

@section('content')
    <div id="permissions" x-data="permissions">
        <form @submit.prevent="submitHandler">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">File/Folder</th>
                        <th scope="col" class="text-center">Result</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>uploads/images</td>
                        <td class="text-center">
                            <span class="badge rounded-pill p-2"
                                :class="permissions.images ? 'text-bg-primary' : 'text-bg-danger'"
                                x-text="permissions.images ? 'Enabled': 'Disabled'">
                                N/A
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td>uploads/videos</td>
                        <td class="text-center">
                            <span class="badge rounded-pill p-2"
                                :class="permissions.videos ? 'text-bg-primary' : 'text-bg-danger'"
                                x-text="permissions.videos ? 'Enabled': 'Disabled'">
                                N/A
                            </span>

                        </td>
                    </tr>

                    <tr>
                        <td>uploads/files</td>
                        <td class="text-center">
                            <span class="badge rounded-pill p-2"
                                :class="permissions.files ? 'text-bg-primary' : 'text-bg-danger'"
                                x-text="permissions.files ? 'Enabled': 'Disabled'">
                                N/A
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="text-center mt-5">
                <button type="submit" class="btn btn-outline-primary">Check License</button>
            </div>
        </form>
    </div>
@endsection

@push('custom-js')
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("permissions", () => ({
                permissions: {},
                async init() {
                    await fetch('/api/v1/permissions', {
                            method: "GET",
                            headers: {
                                Accept: 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(res => {
                            if (res.status === 'success') {
                                this.permissions = res.data;
                            }
                        })
                        .catch(err => console.log(err))
                },
                async submitHandler() {
                    await fetch('/api/v1/permissions/validate', {
                            method: "POST",
                            headers: {
                                Accept: 'application/json',
                            }
                        })
                        .then(res => res.json())
                        .then(res => {
                            Swal.fire({
                                title: res.message,
                                icon: res.status === 'success' ? 'success' : 'error',
                                timer: 1500
                            })
                            if (res.status === 'success') {
                                setTimeout(() => {
                                    window.location.href = '/installer/license'
                                }, 1000);
                            }
                        })
                        .catch(err => console.log(err))
                }
            }))
        })
    </script>
@endpush

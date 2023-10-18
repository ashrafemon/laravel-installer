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
                    <template x-for="(item,i) in permissions">
                        <tr :key="i">
                            <td x-text="item.title"></td>
                            <td class="text-center">
                                <span class="badge rounded-pill p-2"
                                    :class="item.value ? 'text-bg-primary' : 'text-bg-danger'"
                                    x-text="item.value ? 'Enabled': 'Disabled'">
                                    N/A
                                </span>
                            </td>
                        </tr>
                    </template>
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
                permissions: [],
                async init() {
                    await fetch('/api/v1/dir-permissions', {
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
                    await fetch('/api/v1/dir-permissions/validate', {
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
                                    window.location.href = res?.data?.url
                                }, 1000);
                            }
                        })
                        .catch(err => console.log(err))
                }
            }))
        })
    </script>
@endpush

@extends('laravel-installer::layouts.installer')

@section('content')
    <div id="requirement" x-data="requirements">
        <form @submit.prevent="submitHandler">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Extensions</th>
                        <th scope="col" class="text-center">Result</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>PHP >= 8.0</td>
                        <td class="text-center">
                            <span class="badge rounded-pill p-2"
                                :class="extensions.phpVersion ? 'text-bg-primary' : 'text-bg-danger'"
                                x-text="extensions.php">
                                N/A
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>MySqli PHP Extension</td>
                        <td class="text-center">
                            <span class="badge rounded-pill p-2"
                                :class="extensions.mysqli ? 'text-bg-primary' : 'text-bg-danger'"
                                x-text="extensions.mysqli ? 'Enabled': 'Disabled'">
                                N/A
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>PDO PHP Extension</td>
                        <td class="text-center">
                            <span class="badge rounded-pill p-2"
                                :class="extensions.pdo ? 'text-bg-primary' : 'text-bg-danger'"
                                x-text="extensions.pdo ? 'Enabled': 'Disabled'">
                                N/A
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>BCMath PHP Extension</td>
                        <td class="text-center">
                            <span class="badge rounded-pill p-2"
                                :class="extensions.bcMath ? 'text-bg-primary' : 'text-bg-danger'"
                                x-text="extensions.bcMath ? 'Enabled': 'Disabled'">
                                N/A
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Ctype PHP Extension</td>
                        <td class="text-center">
                            <span class="badge rounded-pill p-2"
                                :class="extensions.cType ? 'text-bg-primary' : 'text-bg-danger'"
                                x-text="extensions.cType ? 'Enabled': 'Disabled'">
                                N/A
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>FileInfo PHP Extension</td>
                        <td class="text-center">
                            <span class="badge rounded-pill p-2"
                                :class="extensions.fileInfo ? 'text-bg-primary' : 'text-bg-danger'"
                                x-text="extensions.fileInfo ? 'Enabled': 'Disabled'">
                                N/A
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>JSON PHP Extension</td>
                        <td class="text-center">
                            <span class="badge rounded-pill p-2"
                                :class="extensions.json ? 'text-bg-primary' : 'text-bg-danger'"
                                x-text="extensions.json ? 'Enabled': 'Disabled'">
                                N/A
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Mbstring PHP Extension</td>
                        <td class="text-center">
                            <span class="badge rounded-pill p-2"
                                :class="extensions.mbString ? 'text-bg-primary' : 'text-bg-danger'"
                                x-text="extensions.mbString ? 'Enabled': 'Disabled'">
                                N/A
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>OpenSSL PHP Extension</td>
                        <td class="text-center">
                            <span class="badge rounded-pill p-2"
                                :class="extensions.openSSL ? 'text-bg-primary' : 'text-bg-danger'"
                                x-text="extensions.openSSL ? 'Enabled': 'Disabled'">
                                N/A
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Tokenizer PHP Extension</td>
                        <td class="text-center">
                            <span class="badge rounded-pill p-2"
                                :class="extensions.tokenizer ? 'text-bg-primary' : 'text-bg-danger'"
                                x-text="extensions.tokenizer ? 'Enabled': 'Disabled'">
                                N/A
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>XML PHP Extension</td>
                        <td class="text-center">
                            <span class="badge rounded-pill p-2"
                                :class="extensions.xml ? 'text-bg-primary' : 'text-bg-danger'"
                                x-text="extensions.xml ? 'Enabled': 'Disabled'">
                                N/A
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>cURL PHP Extension</td>
                        <td class="text-center">
                            <span class="badge rounded-pill p-2"
                                :class="extensions.curl ? 'text-bg-primary' : 'text-bg-danger'"
                                x-text="extensions.curl ? 'Enabled': 'Disabled'">
                                N/A
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>GD PHP Extension</td>
                        <td class="text-center">
                            <span class="badge rounded-pill p-2"
                                :class="extensions.gd ? 'text-bg-primary' : 'text-bg-danger'"
                                x-text="extensions.gd ? 'Enabled': 'Disabled'">
                                N/A
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Zip PHP Extension</td>
                        <td class="text-center">
                            <span class="badge rounded-pill p-2"
                                :class="extensions.zip ? 'text-bg-primary' : 'text-bg-danger'"
                                x-text="extensions.zip ? 'Enabled': 'Disabled'">
                                N/A
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>allow_url_fopen</td>
                        <td class="text-center">
                            <span class="badge rounded-pill p-2"
                                :class="extensions.allowUrlFOpen ? 'text-bg-primary' : 'text-bg-danger'"
                                x-text="extensions.allowUrlFOpen ? 'Enabled': 'Disabled'">
                                N/A
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="text-center mt-5">
                <button type="submit" class="btn btn-outline-primary">Go to files/folders permissions</button>
            </div>
        </form>
    </div>
@endsection

@push('custom-js')
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("requirements", () => ({
                extensions: {},
                async init() {
                    await fetch('/api/v1/extensions', {
                            method: "GET",
                            headers: {
                                Accept: 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(res => {
                            if (res.status === 'success') {
                                this.extensions = res.data;
                            }
                        })
                        .catch(err => console.log(err))
                },
                async submitHandler() {
                    await fetch('/api/v1/extensions/validate', {
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
                            setTimeout(() => {
                                window.location.href = '/installer/permissions'
                            }, 1000);
                        })
                        .catch(err => console.log(err))
                }
            }))
        })
    </script>
@endpush

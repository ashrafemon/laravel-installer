@extends('laravel-installer::layouts.installer')

@section('content')
    <div id="requirement">
        <form action="{{ route('requirements.store') }}" method="POST">
            @csrf
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
                            <span
                                class="badge rounded-pill {{ $extensions['phpVersion'] ? 'text-bg-primary' : 'text-bg-danger' }} p-2">
                                {{ phpversion() }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>MySqli PHP Extension</td>
                        <td class="text-center">
                            <span
                                class="badge rounded-pill {{ $extensions['mysqli'] ? 'text-bg-primary' : 'text-bg-danger' }} p-2">
                                {{ $extensions['mysqli'] ? 'Enabled' : 'Disabled' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>PDO PHP Extension</td>
                        <td class="text-center">
                            <span
                                class="badge rounded-pill {{ $extensions['pdo'] ? 'text-bg-primary' : 'text-bg-danger' }} p-2">
                                {{ $extensions['pdo'] ? 'Enabled' : 'Disabled' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>BCMath PHP Extension</td>
                        <td class="text-center">
                            <span
                                class="badge rounded-pill {{ $extensions['bcMath'] ? 'text-bg-primary' : 'text-bg-danger' }} p-2">
                                {{ $extensions['bcMath'] ? 'Enabled' : 'Disabled' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Ctype PHP Extension</td>
                        <td class="text-center">
                            <span
                                class="badge rounded-pill {{ $extensions['cType'] ? 'text-bg-primary' : 'text-bg-danger' }} p-2">
                                {{ $extensions['cType'] ? 'Enabled' : 'Disabled' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>FileInfo PHP Extension</td>
                        <td class="text-center">
                            <span
                                class="badge rounded-pill {{ $extensions['fileInfo'] ? 'text-bg-primary' : 'text-bg-danger' }} p-2">
                                {{ $extensions['fileInfo'] ? 'Enabled' : 'Disabled' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>JSON PHP Extension</td>
                        <td class="text-center">
                            <span
                                class="badge rounded-pill {{ $extensions['json'] ? 'text-bg-primary' : 'text-bg-danger' }} p-2">
                                {{ $extensions['json'] ? 'Enabled' : 'Disabled' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Mbstring PHP Extension</td>
                        <td class="text-center">
                            <span
                                class="badge rounded-pill {{ $extensions['mbString'] ? 'text-bg-primary' : 'text-bg-danger' }} p-2">
                                {{ $extensions['mbString'] ? 'Enabled' : 'Disabled' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>OpenSSL PHP Extension</td>
                        <td class="text-center">
                            <span
                                class="badge rounded-pill {{ $extensions['openSSL'] ? 'text-bg-primary' : 'text-bg-danger' }} p-2">
                                {{ $extensions['openSSL'] ? 'Enabled' : 'Disabled' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Tokenizer PHP Extension</td>
                        <td class="text-center">
                            <span
                                class="badge rounded-pill {{ $extensions['tokenizer'] ? 'text-bg-primary' : 'text-bg-danger' }} p-2">
                                {{ $extensions['tokenizer'] ? 'Enabled' : 'Disabled' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>XML PHP Extension</td>
                        <td class="text-center">
                            <span
                                class="badge rounded-pill {{ $extensions['xml'] ? 'text-bg-primary' : 'text-bg-danger' }} p-2">
                                {{ $extensions['xml'] ? 'Enabled' : 'Disabled' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>cURL PHP Extension</td>
                        <td class="text-center">
                            <span class="badge rounded-pill text-bg-primary p-2">
                                Enabled
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>GD PHP Extension</td>
                        <td class="text-center">
                            <span
                                class="badge rounded-pill {{ $extensions['gd'] ? 'text-bg-primary' : 'text-bg-danger' }} p-2">
                                {{ $extensions['gd'] ? 'Enabled' : 'Disabled' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Zip PHP Extension</td>
                        <td class="text-center">
                            <span
                                class="badge rounded-pill {{ $extensions['zip'] ? 'text-bg-primary' : 'text-bg-danger' }} p-2">
                                {{ $extensions['zip'] ? 'Enabled' : 'Disabled' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>allow_url_fopen</td>
                        <td class="text-center">
                            <span
                                class="badge rounded-pill {{ $extensions['allowUrlFOpen'] ? 'text-bg-primary' : 'text-bg-danger' }} p-2">
                                {{ $extensions['allowUrlFOpen'] ? 'Enabled' : 'Disabled' }}
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

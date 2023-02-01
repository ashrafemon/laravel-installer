@extends('laravel-installer::layouts.installer')

@section('content')
    <div id="permissions">
        <form action="{{ route('permissions.store') }}" method="POST">
            @csrf
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
                            <span
                                class="badge rounded-pill {{ $permissions['images'] ? 'text-bg-primary' : 'text-bg-danger' }} p-2">
                                {{ $permissions['images'] ? 'Enabled' : 'Disabled' }}
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td>uploads/videos</td>
                        <td class="text-center">
                            <span
                                class="badge rounded-pill {{ $permissions['videos'] ? 'text-bg-primary' : 'text-bg-danger' }} p-2">
                                {{ $permissions['videos'] ? 'Enabled' : 'Disabled' }}
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td>uploads/files</td>
                        <td class="text-center">
                            <span
                                class="badge rounded-pill {{ $permissions['files'] ? 'text-bg-primary' : 'text-bg-danger' }} p-2">
                                {{ $permissions['files'] ? 'Enabled' : 'Disabled' }}
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

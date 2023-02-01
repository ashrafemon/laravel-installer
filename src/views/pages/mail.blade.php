@extends('laravel-installer::layouts.installer')

@section('content')
    <div id="mail">
        <form action="{{ route('mail.store') }}" method="POST">
            @csrf

            <div class="row row-cols-2 gx-3 gy-4">
                <div class="col">
                    <label class="form-label">Mail Mailer</label>
                    <select class="form-select" name="MAIL_MAILER"
                        value="{{ $mailInfo['MAIL_MAILER'] ?? old('MAIL_MAILER') }}">
                        <option disabled>Select Mailer</option>
                        @foreach ($mailers as $mailer)
                            <option value="{{ $mailer }}">{{ $mailer }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label class="form-label">Mail Encryption</label>
                    <select class="form-select" name="MAIL_ENCRYPTION"
                        value="{{ $mailInfo['MAIL_ENCRYPTION'] ?? old('MAIL_ENCRYPTION') }}">
                        <option disabled>Select Encryption</option>
                        @foreach ($encryptions as $encryption)
                            <option value="{{ $encryption }}"
                                {{ $mailInfo['MAIL_ENCRYPTION'] === $encryption ? 'selected' : '' }}>{{ $encryption }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label class="form-label">Mail Host</label>
                    <input type="text" class="form-control" name="MAIL_HOST"
                        value="{{ $mailInfo['MAIL_HOST'] ?? old('MAIL_HOST') }}">
                </div>
                <div class="col">
                    <label class="form-label">Mail Port</label>
                    <input type="text" class="form-control" name="MAIL_PORT"
                        value="{{ $mailInfo['MAIL_PORT'] ?? old('MAIL_PORT') }}">
                </div>
                <div class="col">
                    <label class="form-label">Mail Username</label>
                    <input type="text" class="form-control" name="MAIL_USERNAME"
                        value="{{ $mailInfo['MAIL_USERNAME'] ?? old('MAIL_USERNAME') }}">
                </div>
                <div class="col">
                    <label class="form-label">Mail Password</label>
                    <input type="text" class="form-control" name="MAIL_PASSWORD"
                        value="{{ $mailInfo['MAIL_PASSWORD'] ?? old('MAIL_PASSWORD') }}">
                </div>
            </div>

            <div class="text-center mt-5">
                <button type="submit" class="btn btn-outline-primary">Install</button>
            </div>
        </form>
    </div>
@endsection

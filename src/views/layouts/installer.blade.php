<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        a,
        ul,
        li {
            text-decoration: none;
            list-style-type: none;
        }

        .logo {
            width: 130px;
            height: auto;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F8F9FA;
        }

        * {
            box-sizing: border-box;
        }

        #progress {
            width: 100%;
            padding: 0;
            list-style-type: none;
            font-size: 14px;
            clear: both;
            line-height: 1em;
            margin: 0 auto;
            text-align: center;
            display: flex;
            justify-content: center;
        }

        #progress li {
            padding: 10px;
            background: #1560bd;
            color: #fff;
            position: relative;
            border-top: 1px solid #1560bd;
            border-bottom: 1px solid #1560bd;
            width: calc(100%/7.5);
            margin: 0 1px;
        }

        #progress li:before {
            content: '';
            border-left: 16px solid #fff;
            border-top: 16px solid transparent;
            border-bottom: 16px solid transparent;
            position: absolute;
            top: 0;
            left: 0;
        }

        #progress li:after {
            content: '';
            border-left: 16px solid #1560bd;
            border-top: 16px solid transparent;
            border-bottom: 16px solid transparent;
            position: absolute;
            top: 0;
            left: 100%;
            z-index: 20;
        }

        #progress li.active {
            background: #002366;
        }

        #progress li.active:after {
            border-left-color: #002366;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="text-center mt-5 mb-3">
            <img src="{{ config('laravel-installer.company_logo') }}" class="logo" alt="Logo">
        </div>

        <div class="card shadow border-0 mb-5">
            <div class="card-body">

                <ul id="progress" class="mb-5">
                    <li class="{{ Route::current()->getName() === 'requirements.index' ? 'active' : '' }}">
                        Requirements
                    </li>
                    <li class="{{ Route::current()->getName() === 'permissions.index' ? 'active' : '' }}">
                        Permissions
                    </li>
                    <li class="{{ Route::current()->getName() === 'license.index' ? 'active' : '' }}">License</li>
                    <li class="{{ Route::current()->getName() === 'database.index' ? 'active' : '' }}">Database</li>
                    {{-- <li class="{{ Route::current()->getName() === 'requirements.index' ? 'active' : '' }}">Mail</li> --}}
                    <li class="{{ Route::current()->getName() === 'install.index' ? 'active' : '' }}">Install</li>
                    <li class="{{ Route::current()->getName() === 'finish.index' ? 'active' : '' }}">Finish</li>
                </ul>

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>

    @stack('custom-js')
</body>

</html>

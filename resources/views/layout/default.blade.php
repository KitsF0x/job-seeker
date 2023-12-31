<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    {{-- Libraries --}}
    @vite(['node_modelules/bootstrap/js/index.esm.js', 'node_modules/bootstrap/scss/bootstrap.scss'])
</head>

<body style="height: 100vh">
    <div class="d-flex flex-column justify-content-between" style="height: 100%">
        @include('layout.navbar')
        <div class="container">
            @yield('content')
        </div>
        @include('layout.footer')
    </div>
</body>

</html>

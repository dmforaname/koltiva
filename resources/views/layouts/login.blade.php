<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="Diaz Mahendra">
        <title>Login - Koltiva</title>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

        <!-- Custom styles for this template -->
        <link href="/css/login.css" rel="stylesheet">
        @stack('styles')
    </head>
    <body>

        <header>
            <!-- Fixed navbar -->
            <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav ml-auto float-right">
                        <li class="nav-item {!! (Request::segment(1) == 'login') ? 'active':'' !!}">
                            <a class="nav-link" href="/login">Login</a>
                        </li>
                        <li class="nav-item {!! (Request::segment(1) == 'register') ? 'active':'' !!}">
                            <a class="nav-link" href="/register">Register</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        @yield('content')

        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
        @stack('scripts')

    </body>
</html>

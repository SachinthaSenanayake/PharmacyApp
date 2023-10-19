@extends('layouts.app')
@section('content')

<head>
    <title>login</title>
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-lg mb-5">
        <div class="container">
            <a class="navbar-brand mr-auto">Welcome</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @guest
                    <li class="nav-item" >
                        <a class="nav-link" href="{{ route('register-user') }}" style="text-align: right">User Registration</a>
                    </li>
                    @else
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <main class="login-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="card">
                        <h3 class="card-header text-center">Login</h3>
                        @if(\Session::has('message'))
                            <div class="alert alert-info">
                                {{\Session::get('message')}}
                            </div>
                        @endif
                        <div class="card-body">
                            <form method="POST" action="{{ route('postlogin') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Email" id="email" class="form-control" name="email"
                                        autofocus>
                                    @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <input type="password" placeholder="Password" id="password" class="form-control" name="password">
                                    @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>

                                <div class="d-grid mx-auto">
                                    <button type="submit" class="btn btn-dark btn-block">Sign In</button>
                                </div><br>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</body>

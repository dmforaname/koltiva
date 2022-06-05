@extends('layouts.login')

@section('content')

<form class="form-signin">
    <div class="text-center mb-4">   
        <h1 class="h3 mb-3 font-weight-normal">Login</h1>
    </div>
    @csrf
    
    <div class="form-label-group">
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputEmail">Email address</label>
    </div>
    <div class="form-label-group">
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <label for="inputPassword">Password</label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form>

@endsection
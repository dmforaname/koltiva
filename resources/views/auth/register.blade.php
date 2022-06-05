@extends('layouts.login')

@section('content')

<form class="form-signin">
    <div class="text-center mb-4">   
        <h1 class="h3 mb-3 font-weight-normal">Register</h1>
    </div>
    <div class="form-label-group">
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputEmail">Email address</label>
    </div>
    <div class="form-label-group">
        <input type="text" id="inputName" class="form-control" placeholder="Fullname" required>
        <label for="inputName">Fullname</label>
    </div>
    <div class="form-label-group">
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <label for="inputPassword">Password</label>
    </div>
    <div class="form-group">
        <div class="custom-file">
            <input type="file" class="custom-file-input form-control" id="customFile">
            <label class="custom-file-label" for="customFile">Choose file</label>
        </div>
    </div>
    
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form>

@endsection

@push('scripts')
<script>
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
<script>
@endpush
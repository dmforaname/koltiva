@extends('layouts.login')

@section('content')

<form class="form-signin" method="POST" enctype="multipart/form-data" id="formInsert" action="javascript:void(0)">
    <div class="text-center mb-4">   
        <h1 class="h3 mb-3 font-weight-normal">Login</h1>
    </div>
    @csrf
    
    <div class="form-label-group">
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputEmail">Email address</label>
        <small class="text-danger" id="emailStoreError"></small>
    </div>
    <div class="form-label-group">
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <label for="inputPassword">Password</label>
        <small class="text-danger" id="passwordStoreError"></small>
    </div>

    <button class="btn btn-lg btn-primary btn-block" type="submit" id="storeButton">Sign in</button>
</form>

@endsection


@push('scripts')
<script>

$("#formInsert").submit(function(e) {

    e.preventDefault()
    storeError()
    $('#storeButton').prop('disabled', true)

    var formData = new FormData(this)

    $.ajax({

        type:'POST',
        url:"{{ route('Login.store') }}",
        data: formData,
        cache:false,
        contentType: false,
        processData: false,  
        success:function(data){

            toastr.success(data.message)
            $("#formInsert").trigger("reset")
            $('#storeButton').prop('disabled', false)
        },
        error:function (e){

            $('#storeButton').prop('disabled', false)
            var err = e.responseJSON.errors
            storeError(err)
        },
        statusCode: {
            422: function() {
                toastr.error('Login failed!')
            },
        }
    });
});


function storeError(err) {

    $('#emailStoreError').text(err?err.email:"")
    $('#passwordStoreError').text(err?err.password:"")
}
</script>
@endpush
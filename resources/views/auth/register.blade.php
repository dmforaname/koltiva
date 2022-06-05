@extends('layouts.login')

@section('content')

<form class="form-signin" method="POST" enctype="multipart/form-data" id="formInsert" action="javascript:void(0)">
    <div class="text-center mb-4">   
        <h1 class="h3 mb-3 font-weight-normal">Register</h1>
    </div>
    @csrf

    <div class="form-label-group">
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputEmail">Email address</label>
        <small class="text-danger" id="emailStoreError"></small>
    </div>
    <div class="form-label-group">
        <input type="text" name="name" id="inputName" class="form-control" placeholder="Full Name" required>
        <label for="inputName">Full Name</label>
        <small class="text-danger" id="nameStoreError"></small>
    </div>
    <div class="form-label-group">
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <label for="inputPassword">Password</label>
        <small class="text-danger" id="passwordStoreError"></small>
    </div>
    <div class="form-label-group">
        <input type="password" name="password_confirmation" id="inputPasswordConfirmation" class="form-control" placeholder="Password" required>
        <label for="inputPasswordConfirmation">Password Confirmation</label>
    </div>
    <div class="form-group">
        <div class="custom-file">
            <input type="file" name="image" class="custom-file-input form-control" id="customFile" required>
            <label class="custom-file-label" for="customFile">Choose file</label>
            <small class="text-danger" id="imageStoreError"></small>
        </div>
    </div>
    
    <button class="btn btn-lg btn-primary btn-block" type="submit" id="storeButton">Sign in</button>
</form>

@endsection

@push('scripts')
<script>
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

$(".custom-file-label").removeClass("selected").html('Choose file');

$("#formInsert").submit(function(e) {

    e.preventDefault()
    storeError()
    $('#storeButton').prop('disabled', true)

    var formData = new FormData(this)

    $.ajax({

        type:'POST',
        url:"{{ route('Register.store') }}",
        data: formData,
        cache:false,
        contentType: false,
        processData: false,  
        success:function(data){

            toastr.success(data.message)
            $("#formInsert").trigger("reset")
            //$('.dataTables').DataTable().ajax.reload()
            $(".custom-file-label").removeClass("selected").html('Choose file');
            $('#storeButton').prop('disabled', false)
        },
        error:function (e){

            toastr.error('an error occurred')
            $('#storeButton').prop('disabled', false)
            var err = e.responseJSON.errors
            storeError(err)
        }
    });
});


function storeError(err) {

    $('#nameStoreError').text(err?err.name:"")
    $('#emailStoreError').text(err?err.email:"")
    $('#passwordStoreError').text(err?err.password:"")
    $('#imageStoreError').text(err?err.image:"")
}
</script>
@endpush
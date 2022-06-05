@extends('layouts.admin')

@section('content')
   
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Users</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#storeModal">Add User</button>
          </div>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-sm table-bordered table-hover table-striped dataTables">
          <thead class="thead-dark">
            <tr>
              <th>No.</th>
              <th>Email</th>
              <th>Name</th>
              <th>Image Profile</th>
              <th>Updated At</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
@endsection

@push('modals')
<!-- Modal -->
<div class="modal fade" id="storeModal" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Users</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form-signin" method="POST" enctype="multipart/form-data" id="formInsert" action="javascript:void(0)">
      <div class="modal-body">
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
                <label class="custom-file-label" for="customFile"></label>
                <small class="text-danger" id="imageStoreError"></small>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="storeButton">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endpush

@push('scripts')
<script>

mainLoad()
$("#overlay").fadeIn()
$(".custom-file-label").removeClass("selected").html('Choose file')

function mainLoad()
{
  $.when(checkToken()).done(function (ct) {

    //console.log('Welcome')
    $('head title').text(`User - Koltiva`)
    $("#overlay").fadeOut()
    getDataTables(url,columns)
  });
}

var columns = [
        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
        {data: 'email', name: 'email'},
        {data: 'name', name: 'name'},
        {data: 'new_image', name: 'new_image'},
        {data: 'updatedAt', name: 'updatedAt'},
    ];

var url = "{{ route('UserApi.index') }}";


$("#formInsert").submit(function(e) {

  e.preventDefault()
  storeError()
  $('#storeButton').prop('disabled', true)

  var formData = new FormData(this)

  $.ajax({

      type:'POST',
      url:"{{ route('UserApi.store') }}",
      data: formData,
      cache:false,
      contentType: false,
      processData: false,  
      success:function(data){

          toastr.success(data.message)
          $("#formInsert").trigger("reset")
          $(".custom-file-label").removeClass("selected").html('Choose file')
          $('#storeButton').prop('disabled', false)
          $('#storeModal').modal('hide')
          $('.dataTables').DataTable().ajax.reload(null, false)
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


$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>
@endpush

@push('styles')
<style>
  img.imgProfile {
    height: auto;
    width: auto;
  }

  .clickRow {
    cursor: pointer;
}
</style>

@endpush
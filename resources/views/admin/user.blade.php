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

<!-- edit modal --> 
<div class="modal fade" id="ajaxModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalHeading"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" id="formEdit" action="javascript:void(0)" >  
            <div class="modal-body">
              <div class="row">
                <div class="form-group col-sm-12">
                  <label class="col-sm-6 control-label">Email</label>
                  <input type="text" class="form-control" id="uuid" name="uuid" hidden>
                  <input type="email" class="form-control" id="emailView" name="email" placeholder="Enter Email" required>
                  <small class="text-danger" id="emailError"></small>
                </div>
                <div class="form-group col-sm-12">
                  <label class="col-sm-6 control-label">Full Name</label>
                  <input type="text" class="form-control" id="nameView" name="name" placeholder="Enter Full Name" required>
                  <small class="text-danger" id="nameError"></small>
                </div>
                <div class="form-group col-sm-12">
                  <label class="col-sm-6 control-label">Images <small>Keep empty if dont need to update</small><!--<small><a href="javascript:void(0)" data-toggle="popover" id="imgPopover">Show Image</a></small>--></label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="customFileView" name="image">
                    <label class="custom-file-label" for="customFile"></label>
                    <small class="text-danger" id="imageError"></small>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" id="edit-button" class="btn btn-primary" onclick="event.preventDefault(); clickEdit();">Edit</button>
              <button type="submit" id="save-button" class="btn btn-success">Save</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>   
<!-- /.edit modal -->
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


$(document).ready(function() {

  $('.dataTables tbody').on('click', 'tr', function () {

    $("#overlay").fadeIn();　
    $("#save-button").hide();
    
    trId = $(this).attr('id');

    console.log(trId)

    $.ajax({
      method : "GET",
      url:"/api/users/"+trId,
      success: function (data) {

        var data = data.data

        $("#overlay").fadeOut()
        $('#modalHeading').html("Edit User")
        $('#ajaxModal').modal('show')
        $('#uuid').val(data.uuid)
        $('#emailView').val(data.email).prop('disabled', true)
        $('#nameView').val(data.name).prop('disabled', true)
        $('#customFileView').prop('disabled', true)
        $("#edit-button").show()
        //setPopover(data.image)
      },
      error: function (data) {
          
          // Get error data
          $("#overlay").fadeOut()
          toastr.error('Failed To Load Data')
          console.log('Error:', data)
      }
    });
  });
});


function clickEdit()
{
  $('#emailView').prop('disabled', false)
  $('#nameView').prop('disabled', false)
  $('#customFileView').prop('disabled', false)
  $("#edit-button").hide()
  $("#save-button").show()
}

$("#formEdit").submit(function(e){

  e.preventDefault();
  $('#save-button').prop('disabled', true);



  var uuid = $("input[name=uuid]").val();

  console.log(uuid)
  var formData = new FormData(this);

  $.ajax({

    type:'POST',
    url:"/api/users/"+uuid,
    headers: {"X-HTTP-Method-Override": "PUT"},
    data: formData,
    cache:false,
    contentType: false,
    processData: false,  
    success:function(data){

      $('#ajaxModal').modal('hide')
      toastr.success(data.message)
      $('.dataTables').DataTable().ajax.reload(null, false)
    },
    error:function (e){

      editError(e.responseJSON.errors)
      toastr.error('Failed To Update Data')
    }
  });
});

function editError(err)
{
  $('#emailError').text(err?err.title:"")
  $('#imageError').text(err?err.image:"")
  $('#nameError').text(err?err.description:"")
  $('#save-button').prop('disabled', false)
}

$('#ajaxModal').on('hidden.bs.modal', function () {

  $("#formEdit").trigger("reset")
  editError()
})

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
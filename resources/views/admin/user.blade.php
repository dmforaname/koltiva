@extends('layouts.admin')

@section('content')
   
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Users</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Add User</button>
          </div>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>No.</th>
              <th>Email</th>
              <th>Name</th>
              <th>Image Profile</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
@endsection


@push('scripts')
<script>

mainLoad()
$("#overlay").fadeIn()

function mainLoad()
{
  $.when(checkToken()).done(function (ct) {

    //console.log('Welcome')
    //$('head title').text(`Dashboard - ${ct.data.hospital_name}`)

    console.log(ct)
    $("#overlay").fadeOut();
  });
}

</script>
@endpush
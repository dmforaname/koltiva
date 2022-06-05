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
        <table class="table table-sm table-bordered table-hover table-striped dataTables">
          <thead class="thead-dark">
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
    ];

var url = "{{ route('UserApi.index') }}";

</script>
@endpush

@push('styles')
<style>
  img.imgProfile {
    height: auto;
    width: auto;
  }
</style>

@endpush
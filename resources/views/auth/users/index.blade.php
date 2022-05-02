@extends('layouts.app')

@section('title', 'User Managment')

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<style>
body {
    color: #566787;
    font-family: 'Varela Round', sans-serif;
    font-size: 13px;
}
.table-responsive {
    margin: 30px 0;
}
.table-wrapper {
    min-width: 1000px;
    background: #fff;
    padding: 20px 25px;
    border-radius: 3px;
    box-shadow: 0 1px 1px rgba(0,0,0,.05);
}
.table-title {
    padding-bottom: 15px;
    background: #ffc107;
    color: #fff;
    padding: 16px 30px;
    margin: -20px -25px 10px;
    border-radius: 3px 3px 0 0;
}
.table-title h2 {
    margin: 5px 0 0;
    font-size: 24px;
}
.table-title .btn {
    color: #566787;
    float: right;
    font-size: 13px;
    background: #fff;
    border: none;
    min-width: 50px;
    border-radius: 2px;
    border: none;
    outline: none !important;
    margin-left: 10px;
}
.table-title .btn:hover, .table-title .btn:focus {
    color: #566787;
    background: #f2f2f2;
}
.table-title .btn i {
    float: left;
    font-size: 21px;
    margin-right: 5px;
}
.table-title .btn span {
    float: left;
    margin-top: 2px;
}
table.table tr th, table.table tr td {
    border-color: #e9e9e9;
    padding: 12px 15px;
    vertical-align: middle;
}
table.table tr th:first-child {
    width: 60px;
}
table.table tr th:last-child {
    width: 100px;
}
table.table-striped tbody tr:nth-of-type(odd) {
    background-color: #fcfcfc;
}
table.table-striped.table-hover tbody tr:hover {
    background: #f5f5f5;
}
table.table th i {
    font-size: 13px;
    margin: 0 5px;
    cursor: pointer;
}	
table.table td:last-child i {
    opacity: 0.9;
    font-size: 22px;
    margin: 0 5px;
}
table.table td a {
    font-weight: bold;
    color: #566787;
    display: inline-block;
    text-decoration: none;
}
table.table td a:hover {
    color: #ffc107;
}
table.table td a.settings {
    color: #ffc107;
}
table.table td a.delete {
    color: #F44336;
}
table.table td i {
    font-size: 19px;
}
table.table .avatar {
    border-radius: 50%;
    vertical-align: middle;
    margin-right: 10px;
}
.status {
    font-size: 30px;
    margin: 2px 2px 0 0;
    display: inline-block;
    vertical-align: middle;
    line-height: 10px;
}
.text-success {
    color: #10c469;
}
.text-info {
    color: #62c9e8;
}
.text-warning {
    color: #FFC107;
}
.text-danger {
    color: #ff5b5b;
}
.pagination {
    float: right;
    margin: 0 0 5px;
}
.pagination li a {
    border: none;
    font-size: 13px;
    min-width: 30px;
    min-height: 30px;
    color: #999;
    margin: 0 2px;
    line-height: 30px;
    border-radius: 2px !important;
    text-align: center;
    padding: 0 6px;
}
.pagination li a:hover {
    color: #666;
}	
.pagination li.active a, .pagination li.active a.page-link {
    background: #ffc107;
}
.pagination li.active a:hover {        
    background: #ffc107;
}
.pagination li.disabled i {
    color: #ccc;
}
.pagination li i {
    font-size: 16px;
    padding-top: 6px
}
.hint-text {
    float: left;
    margin-top: 10px;
    font-size: 13px;
}
</style>
<script>
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
});
</script>

<div class="container-xl">
    <div class="row justify-content-start">
        <div class="col-md-3">
             <input type="text" name="search" class="form-control" id="searchUser" placeholder="Search" required/>
        </div>
    </div>	
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-5">
                        <h2>User <b>Management</b></h2>
                    </div>
                    <div class="col-sm-7">
                        <a href="{{ route('auth.users.adduser') }}" class="btn btn-secondary"><i class="material-icons">&#xE147;</i> <span>Add New User</span></a>
                        <a href="/users/exportCsv" class="btn btn-secondary"><i class="material-icons">&#xE24D;</i> <span>Export to Excel</span></a>								
                    </div>
                </div>
            </div>
            <table id="users" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>						
                        <th>Date Created</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td id="{{ $user->id }}">{{ $user->id }}</td>
                            <td id="name{{ $user->id }}"><a href="#" id="name{{ $user->id }}">{{ $user->name }}</a></td>
                            <td id="email{{ $user->id }}">{{ $user->email }}</td>
                            <td>{{ $user->created_at }}</td>                        
                            <td id="type{{ $user->id }}">{{ $user->type }}</td>
                            <td id="status{{ $user->id }}"><span class="{{ $user->status == 'active' ? 'status text-success' : ($user->status == 'in_active'? 'status text-warning' : 'status text-danger') }}">&bull;</span>{{ $user->status }}</td>
                            <td>
                                <a href="#" rowId="{{ $user->id }}" class="settings" title="Settings" data-toggle="modal" data-target="#editModal" type="button"><i class="material-icons">&#xE8B8;</i></a>
                                <a href="/users/delete/{{ $user->id }}" rowId="{{ $user->id }}" class="delete" title="Delete" data-toggle="tooltip" type="button"><i class="material-icons">&#xE5C9;</i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="clearfix">
                <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
                <ul class="pagination">
                    <li class="page-item disabled"><a href="#">Previous</a></li>
                    <li class="page-item"><a href="#" class="page-link">1</a></li>
                    <li class="page-item"><a href="#" class="page-link">2</a></li>
                    <li class="page-item active"><a href="#" class="page-link">3</a></li>
                    <li class="page-item"><a href="#" class="page-link">4</a></li>
                    <li class="page-item"><a href="#" class="page-link">5</a></li>
                    <li class="page-item"><a href="#" class="page-link">Next</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>


<!-- Edit Modal HTML -->
<div class="modal fade editModall" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit User Information</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label for="name" class="col-form-label">Name:</label>
              <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
              <input type="text" class="form-control" id="editName" name="name">
            </div>
            <div class="form-group">
              <label for="email" class="col-form-label">Email:</label>
              <input type="text" class="form-control" id="editEmail" name="email">
            </div>

            <div class="form-group">
                <label for="type" class="col-form-label">Role:</label>
                <select name="type" id="editRole" class="form-control">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status" class="col-form-label">Status:</label>
                <select name="status" id="editStatus" class="form-control">
                    <option value="active">Active</option>
                    <option value="in_active">In active</option>
                    <option value="suspended">Suspended</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <input type="button" class="btn btn-primary editAccount" value="Save Changes" />
        </div>
      </div>
    </div>
  </div>
  <!-- Edit Modal HTML END-->

  <script>
    $(document).ready(function() { 
        $('.settings').on('click', function() {
            var id = $(this).attr('rowId');
            $("#editName").val($("#name"+id).text());
            $("#editEmail").val($("#email"+id).text());
            $("#editRole").val($("#type"+id).text());
            $("#editStatus").val($("#status"+id).text().slice(1));
            $(".editAccount").attr('rowId', id);
        });
    

     // Edit Account From Admin Side

  $(".editAccount").on('click', function() {
    var id = $(this).attr('rowId');
    var name = $('#editName').val();
    var email = $('#editEmail').val();
    var type = $('#editRole').val();
    var status = $('#editStatus').val();
    var token = $('#token').val();

    $.ajax({
        type: 'POST',
        url: "/users/update/"+id,
        data: {
            id: id,
            name: name,
            email: email,
            type: type,
            status: status,
            _token: token
        },
        success: function(data) {
            if (data.success == true) {
                Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'Ok'
                }).then(() => {
                    $(".editModall").hide();
                    $(".modal-backdrop").hide();
                    location.reload();
                });
            } else {
                 Swal.fire({
                    title: 'Error!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'Ok'
                 });
                }
            }
        });
    });
    // Delete Account From Admin Side
    $(".delete").on("click", function() {
        var id = $(this).attr('rowId');
        $.ajax({
            type: 'POST',
            url: "/users/delete/"+id,
            data: {
                id: id,
                _token: token
            },
            success: function(data) {
                
            }
        });
    });
});

// Search users table
$(document).ready(function () {
        $("#searchUser").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#users tbody tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
  </script>
@endsection
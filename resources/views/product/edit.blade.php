@extends('layouts.app')

@section('title', 'Product Managment')

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
             <input type="text" name="search" class="form-control" id="searchProduct" placeholder="Search" required/>
        </div>
    </div>	
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-5">
                        <h2>Product <b>Management</b></h2>
                    </div>
                    <div class="col-sm-7">
                        <a href="{{ route('product.create') }}" class="btn btn-secondary" data-toggle="modal" data-target="#addModal"><i class="material-icons">&#xE147;</i> <span>Add New Product</span></a>
                        <a href="/product/exportCsv" class="btn btn-secondary"><i class="material-icons">&#xE24D;</i> <span>Export to Excel</span></a>								
                    </div>
                </div>
            </div>
            <table id="products" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product Image</th>
                        <th>Product Name</th>						
                        <th>Product Price</th>
                        <th>Product Availability</th>
                        <th>Product Quantity</th>
                        <th>Product Condition</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td id="{{ $product->id }}">{{ $product->id }}</td>
                            <td id="image{{ $product->id }}"><img src="/{{ $product->image }}" width=100 onclick="return showImg('{{$product->image}}','{{$product->images}}');"></td>
                            <td id="name{{ $product->id }}"><a href="#" id="name{{ $product->id }}">{{ $product->name }}</a></td>
                            <td id="price{{ $product->id }}">${{ $product->price }}</td>                     
                            <td id="availability{{ $product->id }}">{{ $product->availability }}</td>                     
                            <td id="product_qty{{ $product->id }}">{{ $product->product_qty }}</td>                     
                            <td id="condition{{ $product->id }}">{{ $product->condition }}</td>
                            <td>
                                <a href="#" rowId="{{ $product->id }}" class="settings" title="Settings" data-toggle="modal" data-target="#editModal" type="button"><i class="material-icons">&#xE8B8;</i></a>
                                <a href="/product/delete/{{ $product->id }}" rowId="{{ $product->id }}" class="delete" title="Delete" data-toggle="tooltip" type="button"><i class="material-icons">&#xE5C9;</i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="clearfix">
                <div class="hint-text">Showing {{($products->currentpage()-1)*$products->perpage()+1}} to {{ $products->currentpage()*(($products->perpage() < $products->total()) ? $products->perpage(): $products->total())}} of {{ $products->total()}} entries</div>
                <ul class="pagination">
                    <li class="page-item">
                        {!! $products->links() !!}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal HTML -->
<div class="modal fade addModall" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add New Product</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                    <form method="post" action="{{ route('product.create') }}" id="add_form" name="addForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file" class="col-form-label">Product Image:</label>
                        <input type="file" class="form-control" name="file" id="file">
                    </div>

                    <div class="form-group">
                    <label for="name" class="col-form-label">Product Name:</label>
                    <input type="text" class="form-control" id="addName" name="name">
                    </div>

                    <div class="form-group">
                        <label for="price" class="col-form-label">Product Price:</label>
                        <input type="number" class="form-control" id="addPrice" name="price">
                    </div>

                    <div class="form-group">
                        <label for="availability" class="col-form-label">Product Availability:</label>
                        <select name="availability" id="addavailability" class="form-control" required>
                            <option value="" selected disabled>Select</option>
                            <option value="available">Available</option>
                            <option value="in_stock">In stock</option>
                            <option value="out_of_stock">Out of stock</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="product_qty" class="col-form-label">Product Quantity:</label>
                        <input type="number" class="form-control" id="addQuantity" name="product_qty">
                    </div>

                    <div class="form-group">
                        <label for="condition" class="col-form-label">Product Condition:</label>
                        <select name="condition" id="addCondition" class="form-control" required>
                            <option value="" selected disabled>Select</option>
                            <option value="new">New</option>
                            <option value="old">Old</option>
                            <option value="used">Used</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-form-label">Product Description:</label>
                        <input type="text" class="form-control" id="addDescription" name="description">
                    </div>

                    <div class="form-group">
                        <label for="stripe_plan" class="col-form-label">Stripe Plan:</label>
                        <input type="text" class="form-control" id="addStripe_plan" name="stripe_plan">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary addProduct">Save Changes</button>
                    </div>
                </form>
         </div>
        </div>
    </div>
  </div>
  <!-- Add Modal HTML END-->

<!-- Edit Modal HTML -->
<div class="modal fade editModall" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                    <form method="post" id="edit_form" name="editForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file" class="col-form-label">Product Image:</label>
                        <input type="file" class="form-control" name="file" id="file">
                    </div>

                    <div class="form-group">
                    <label for="name" class="col-form-label">Product Name:</label>
                    <input type="text" class="form-control" id="editName" name="name">
                    </div>

                    <div class="form-group">
                        <label for="price" class="col-form-label">Product Price:</label>
                        <input type="number" class="form-control" id="editPrice" name="price">
                    </div>

                    <div class="form-group">
                        <label for="availability" class="col-form-label">Product Availability:</label>
                        <select name="availability" id="editavailability" class="form-control" required>
                            <option value="" selected disabled>Select</option>
                            <option value="available">Available</option>
                            <option value="in_stock">In stock</option>
                            <option value="out_of_stock">Out of stock</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="product_qty" class="col-form-label">Product Quantity:</label>
                        <input type="number" class="form-control" id="editQuantity" name="product_qty">
                    </div>

                    <div class="form-group">
                        <label for="condition" class="col-form-label">Product Condition:</label>
                        <select name="condition" id="editCondition" class="form-control" required>
                            <option value="" selected disabled>Select</option>
                            <option value="new">New</option>
                            <option value="old">Old</option>
                            <option value="used">Used</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-form-label">Product Description:</label>
                        <input type="text" class="form-control" id="editDescription" name="description">
                    </div>

                    <div class="form-group">
                        <label for="stripe_plan" class="col-form-label">Stripe Plan:</label>
                        <input type="text" class="form-control" id="editStripe_plan" name="stripe_plan">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary editProduct">Save Changes</button>
                    </div>
                </form>
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
            $("#editPrice").val($("#price"+id).text().replace("$", ""));
            $("#editAvailability").val($("#availability"+id).text());
            $("#editQuantity").val($("#product_qty"+id).text());
            $("#editCondition").val($("#condition"+id).text().trim());
            $(".editProduct").attr('rowId', id);
        });


        // Add Product From Admin Side
        $("#add_form").submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = new FormData(this);
            $.ajax({
                method: form.attr('method'),
                url: form.attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'Ok'
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

        // Edit Product From Admin Side
        $("#edit_form").submit(function(e) {
            e.preventDefault();
            var rowId = $(".editProduct").attr('rowId');
            var form = $(this);
            var formData = new FormData(this);
            $.ajax({
                method: form.attr('method'),
                url: "/product/update/"+rowId,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.success = true) {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'Ok'
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

        // Delete Product From Admin Side
        $(".delete").on("click", function() {
            var id = $(this).attr('rowId');
            $.ajax({
                type: 'POST',
                url: "/product/delete/"+id,
                data: {
                    id: id,
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
                            location.reload();
                        });
                }
                }
            });
        });
        // Search products table
    $("#searchProduct").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#products tbody tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

  </script>
@endsection
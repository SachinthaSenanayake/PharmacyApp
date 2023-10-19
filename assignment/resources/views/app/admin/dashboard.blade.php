@extends('layouts.app')
@section('content')

<body>
<nav class="navbar navbar-light navbar-expand-lg mb-5">
    <div class="container">
        <a class="navbar-brand mr-auto" ><h3><b>Kamal Pharmacy</b></h3></a>

        <a class="nav-link" href="{{ route('user.userdashboard') }}">User Dashboard</a>
        <a class="nav-link" href="{{ route('register-admin') }}">Admin Registration</a>
        <div>        
            <input type="text" id="search_id" placeholder="Enter Customer ID">
            <button type="button" class="btn btn-primary search_cus_btn" data-bs-dismiss="modal">Search</button>
        </div>

    </div>
</nav>

<div class="col-md-3 customer-form-left" id="customer-form">
    
    <div class="customer-form-top">
        <h4>Add new Customer</h4>
    </div>
    <div class="form-body">
        
        <form>
            <div id="success_message"></div>
            <input type="hidden" id="edit_id"><br>
            <input type="text" class="name form-control" placeholder="Customer Name" required="" id="name"><br>
            <input type="email" class="email form-control" placeholder="Customer Email" required="" id="email"><br>
            <input type="text" class="address form-control" placeholder="Customer Address" required="" id="address"><br>
            <input type="text" class="phone form-control" placeholder="Customer Phone" required="" id="phone"><br>
            <button type="button" class="btn btn-primary save_customer" id="button">Save</button>

            <ul id="saveform_errorlist"></ul>
            <ul id="updateform_errorlist"></ul>
        </form>

    </div>
</div>
<div class="col-md-6 customer-form-right" id="customer-table">
    
    <div class="customer-form-top">

    </div>
    <div class="form-body">

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="DeleteCustomerModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Delete Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="delete_cus_id">
                <h4>Are you sure you want to delete this data?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary delete_cus_btn" data-bs-dismiss="modal">Delete</button>
            </div>
        </div>
    </div>
</div>

<form action="{{route('logout')}}" method="POST">
    @method('post')
    @csrf
    <button>Logout</button>
</form>


@endsection

@section('scripts')

<script>

    fetchCustomer();

    function fetchCustomer()
    {
        $.ajax({
                type:"GET",
                url:"/fetch-customer",
                datatype:"json",
                success:function(response){

                    $('tbody').html("");
                    $.each(response.customers, function(key,item){
                        $('tbody').append('<tr>\
                                <td>'+item.id+'</td>\
                                <td>'+item.name+'</td>\
                                <td>'+item.email+'</td>\
                                <td>'+item.address+'</td>\
                                <td>'+item.phone+'</td>\
                                <td><button type="button" value="'+item.id+'" class="edit_customer btn btn-primary tbn-sm">Edit</button></td>\
                                <td><button type="button" value="'+item.id+'" class="delete_customer btn btn-danger tbn-sm">Delete</button></td>\
                            </tr>');
                    });
                }
            });
    }

    $(document).ready (function(){
        $(document).on ('click','#button',function(e){
            e.preventDefault();
            
            var data={
                'name':$('.name').val(),
                'email':$('.email').val(),
                'address':$('.address').val(),
                'phone':$('.phone').val(),
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });



            $.ajax({
                type:"POST",
                url:"/admin/dashboard",
                data:data,
                datatype:"json",
                success:function(response){

                    if(response.status==400)
                    {
                        $('#saveform_errorlist').html("");
                        $('#saveform_errorlist').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#saveform_errorlist').append('<li>'+err_values+'</li>');                        
                        });
                    }
                    else
                    {
                        $('#saveform_errorlist').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#customer-form').find('input').val("");
                        fetchCustomer();
                    }                
                }
            });
        })
    })


    $(document).on ('click','.edit_customer',function(e){
        e.preventDefault();
        var cus_id=$(this).val();

        $.ajax({
                type:"GET",
                url:"/edit-customer/"+cus_id,

                success:function(response){

                    if(response.status==404)
                    {
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-danger');
                        $('#success_message').text(response.message);
                        $('.save_customer').text("Update");
                        $('#button').attr('id','btn');
                    }
                    else
                    {
                        $('#name').val(response.customer.name);
                        $('#email').val(response.customer.email);
                        $('#address').val(response.customer.address);
                        $('#phone').val(response.customer.phone);
                        $('#edit_id').val(cus_id);
                        $('.save_customer').text("Update");
                        $('#button').attr('id','btn');
                    }
                }
            });
    })
    $(document).on ('click','#btn',function(e){
        e.preventDefault();
        var cus_id=$('#edit_id').val();

        var data={
                'name':$('.name').val(),
                'email':$('.email').val(),
                'address':$('.address').val(),
                'phone':$('.phone').val(),
            }


        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        $.ajax({
                type:"PUT",
                url:"/update-customer/"+cus_id,
                data:data,
                datatype:"json",
                success:function(response){
                    if(response.status==400){
                        $('#updateform_errorlist').html("");
                        $('#updateform_errorlist').addClass('alert alert-danger');
                        $.each(response.errors,function(key,err_values){
                            $('#updateform_errorlist').append('<li>'+err_values+'</li>');
                        
                        });
                        $('.save_customer').text("Save");
                    }
                    else if(response.status==404){
                        $('#updateform_errorlist').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.save_customer').text("Save");
                    }
                    else{
                        $('#updateform_errorlist').html("");
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        fetchCustomer();
                        $('.save_customer').text("Save");
                        $('#customer-form').find('input').val("");
                    }
                }
            })
    })

    $(document).on ('click','.delete_customer',function(e){
        e.preventDefault();
        var cus_id=$(this).val();
        $('#delete_cus_id').val(cus_id);
        $('#DeleteCustomerModal').modal('show');
    })

    $(document).on ('click','.delete_cus_btn',function(e){
        e.preventDefault();
        var cus_id=$('#delete_cus_id').val();

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        $.ajax({
                type:"DELETE",
                url:"/delete-customer/"+cus_id,
                success:function(response){
                    $('#success_message').addClass('alert alert-success');
                    $('#success_message').text(response.message);
                    $('#DeleteCustomerModal').modal('hide');
                    fetchCustomer();
                }
            })
    })

    $(document).on ('click','.search_cus_btn',function(e){
        e.preventDefault();
        var cus_id=$('#search_id').val();

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:"GET",
                url:"/search-customer/"+cus_id,

                success:function(response){

                    if(response.status==404)
                    {
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-danger');
                        $('#success_message').text(response.message);
                    }
                    else
                    {
                        $('#name').val(response.customer.name);
                        $('#email').val(response.customer.email);
                        $('#address').val(response.customer.address);
                        $('#phone').val(response.customer.phone);
                        $('#edit_id').val(cus_id);
                    }
                }
            });
    })

</script>

@endsection
</body>
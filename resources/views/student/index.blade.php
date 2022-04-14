@extends('student.app')

@section('content')
@include('student.nav-bar')
    <div class="container mt-5">
        <h1 class="alert-info text-center mb-5 p-3">
            Ajax Jquery Crud
        </h1>
        <div class="row">
            <form class="col-sm-5" id="myform">
                @csrf
                <h3 class="alert-warning text-center p-2">
                    Add/Update
                </h3>
                <div>
                    <label for="nameid" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" id="name">
                </div>
                <div>
                    <label for="emailid" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email">
                </div>
                <div>
                    <label for="passwordid" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary btn-update" id="btnadd">Save</button>
                </div>
                <div id="msg"></div>
            </form>

            <div class="col-sm-7 text-center">
                <h3 class="alert-warning p-2">
                    Student Data
                </h3>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Action</th>
                        </tr>
                    <tbody id="tbody">
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            // Edit The Student Data ////////////////////////

            $(document).on('click', '.btn-edit', function () {
                // console.log("Edit Work");

                let id = $(this).attr('value')
                // console.log(id);
                $.ajax({
                    type: "get",
                    url: "/edit-students/"+id,
                    success: function (response) {
                        // console.log(response.success.name);
                        let data = response.success
                        // console.log(data);
                        if(response.status == 404){
                            $('#notifDiv').fadeIn();
                            $('#notifDiv').css('background', 'red');
                            $('#notifDiv').text(errors);
                            setTimeout(() => {
                                $('#notifDiv').fadeOut();
                            }, 3000);
                        }
                        else{
                            $('#name').val(data.name),
                            $('#email').val(data.email),
                            $('#password').val(data.password)
                        }

                    }
                });
            });


            ////////////////////// Fetch the Student Data And Show in View //////////////////////////
            fetchstudent();

            function fetchstudent() {
                $.ajax({
                    type: "get",
                    url: "/fetchstudent",
                    success: function(data) {
                        // console.log(data.students[0].name);
                        $('#tbody').html("");
                        $.each(data.students, function(key, item) {
                            $('#tbody').append('<tr>\
                                    <td>'+item.id+'</td>/\
                                    <td>'+item.name+'</td>\
                                    <td>'+item.email+'</td>\
                                    <td>'+item.password+'</td>\
                                    <td><button type="submit" value="'+item.id+'" class="btn btn-warning btn-sm btn-edit">Edit</button></td>\
                                    <td><button type="submit" value="'+item.id+'" class="btn btn-danger btn-sm btn-del">Delete</button></td>\
                                    </tr>');
                        })
                    }
                });
            }


           //////////////////// Inserting The Student Data into Student Table ///////////////////////
            $(document).on('click', '#btnadd', function(e) {
                e.preventDefault();
                // console.log('Button Clicked');
                let nm = $("#name").val();
                let em = $("#email").val();
                let pw = $("#password").val();
                mydata = {
                    name: nm,
                    email: em,
                    password: pw
                };
                // console.log(mydata);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "post",
                    url: "/add-students",
                    data: mydata,
                    success: function(data) {
                        console.log(data);
                        if (data.errors) {
                            $('#notifDiv').fadeIn();
                            $('#notifDiv').css('background', 'red');
                            $('#notifDiv').text(data.errors);
                            setTimeout(() => {
                                $('#notifDiv').fadeOut();
                            }, 3000);
                        } else if (data.success) {
                            $("#myform")[0].reset();
                            $('#notifDiv').fadeIn();
                            $('#notifDiv').css('background', 'green');
                            $('#notifDiv').text(data.success);
                            fetchstudent();
                            setTimeout(() => {
                                $('#notifDiv').fadeOut();
                            }, 3000);
                        }
                        else {
                            $('#notifDiv').fadeIn();
                            $('#notifDiv').css('background', 'red');
                            $('#notifDiv').text('An error occured. Please try later');
                            setTimeout(() => {
                                $('#notifDiv').fadeOut();
                            }, 3000);
                        }
                    }
                });
            });

            // Delete the Student Using Ajax
            $("#tbody").on('click','.btn-del', function () {
                console.log("Delete Work");
                let id = $(this).attr("value");
                console.log(id);
            });

        });
    </script>
@endsection

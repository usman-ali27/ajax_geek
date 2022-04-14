@extends('student.app')
@section('content')
    <section>
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h4 class="text-center">Account Register</h4>
                        </div>
                        <div class="card-body">
                            <form id="myform">
                                @csrf
                                <div class="form-group">
                                    <label for="name">User Name</label>
                                    <input type="text" name="username" id="username" class="form-control"
                                        placeholder="Enter User Name">
                                    <span class="text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>


                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        placeholder="Enter Email">
                                    <span class="text-danger">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" class="form-control"
                                        placeholder="Enter Password">
                                    <span class="text-danger">
                                        @error('password')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <button type="submit" class="btn btn-dark btn-block mt-3" id="save_form">Register</button>
                            </form>
                            <p class="mt-2">Already have account?<a href="{{ url('/login') }}"
                                    class="mx-2">Login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('register')
    <script>
        $(document).ready(function() {
            $(document).on('click', '#save_form', function(e) {
                e.preventDefault();
                // console.log("Register");
                let data = {
                    username: $('#username').val(),
                    email: $('#email').val(),
                    password: $('#password').val(),
                }
                // console.log(data);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "post",
                    url: "/do_register",
                    data: data,
                    success: function(response) {
                        if (response.Exist) {
                            $('#notifDiv').fadeIn();
                            $('#notifDiv').css('background', 'red');
                            $('#notifDiv').text(response.Exist);
                            setTimeout(() => {
                                $('#notifDiv').fadeOut();
                            }, 3000);
                        } else if (response.success) {
                            $("#myform")[0].reset();
                            $('#notifDiv').fadeIn();
                            $('#notifDiv').css('background', 'green');
                            $('#notifDiv').text(response.success);
                            setTimeout(() => {
                                $('#notifDiv').fadeOut();
                            }, 3000);
                        } else {
                            $('#notifDiv').fadeIn();
                            $('#notifDiv').css('background', 'red');
                            $('#notifDiv').text('An error occured. Please try later');
                        }
                    }
                });
            });
        });
    </script>
@endsection

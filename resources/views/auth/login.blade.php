@extends('student.app')
@section('content')
    <section>
        <div class="container mt-4">
            <div class="row ">
                <div class="col-md-6 mx-auto">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h4 class="text-center">Account Login</h4>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label for="email">UserName/Email</label>
                                    <input type="email" name="email" id="email" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" class="form-control">
                                </div>

                                <button type="submit" class="btn btn-dark btn-block mt-3" id="loginBtn">LOGIN</button>
                            </form>

                            <p class="mt-2">Don't have account?<a href="{{ url('/register') }}"
                                    class="mx-2">Register</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('login')
    <script>
        $(document).ready(function() {
            $(document).on('click', '#loginBtn', function(e) {
                e.preventDefault();
                // console.log("logged");

                let mydata = {
                    email: $('#email').val(),
                    password: $('#password').val(),
                }
                // console.log(mydata);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "post",
                    url: "/do_login",
                    data: mydata,
                    success: function(response) {
                        if ($.isEmptyObject(response.error)) {
                      if(response.success) {
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('User Successfully Login');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                    window.location = "{{ route('dashboard') }}";
                  } else if(response.verify_email) {
                      $('#notifDiv').fadeIn();
                       $('#notifDiv').css('background', 'red');
                       $('#notifDiv').text('Verify your account first from email');
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
                }
                });

            });
        });
    </script>
@endsection


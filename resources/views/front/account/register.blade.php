@extends('front.layouts.app')

@section('content')
    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                        <li class="breadcrumb-item">Register</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class=" section-10">
            <div class="container">
                <div class="login-form">
                    <form action="" method="post" id="registrationForm" name="registerationForm">
                        <h4 class="modal-title">Register Now</h4>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Name" id="name" name="name">
                            <p class="error"></p>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Email" id="email" name="email">
                            <p class="error"></p>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Password" id="password"
                                name="password">
                            <p class="error"></p>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Confirm Password"
                                id="password_confirmation" name="password_confirmation">
                            <p class="error"></p>
                        </div>
                        <div class="form-group small">
                            <a href="#" class="forgot-link">Forgot Password?</a>
                        </div>
                        <button type="submit" class="btn btn-dark btn-block btn-lg" value="Register">Register</button>
                    </form>
                    <div class="text-center small">Already have an account? <a href="login.php">Login Now</a></div>
                </div>
            </div>
        </section>
    </main>
@endsection
@section('customJs')
    <script type="text/javascript">
        $('#registrationForm').submit(function(e) {
            e.preventDefault()
            $("button[type='submit']").prop('disabled', true)
            $.ajax({
                url: "{{ route('process.register') }}",
                type: "post",
                data: $(this).serializeArray(),
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Check if the response has a 'status' key
                    window.location.href = "{{ route('account.login') }}"

                },
                error: function(jqXHR, exception) {
                    // Handle error response
                    if (jqXHR.responseJSON && jqXHR.responseJSON.errors) {
                        var errors = jqXHR.responseJSON.errors;
                        $('.error').removeClass('is-invalid').html("")
                        $("input[type=text], select").removeClass('is-invalid')
                        $.each(errors, function(key, value) {
                            $(`#${key}`).addClass('is-invalid').closest('.form-group')
                                .find('p')
                                .addClass('invalid-feedback').html(value);
                        })
                    }
                }
            })
        })
    </script>
@endsection

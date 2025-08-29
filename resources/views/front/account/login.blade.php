@extends('front.layout.app');

@section('main')
    <section class="section-5">
        <div class="container my-5">
            <div class="py-lg-2">&nbsp;</div>

            @if (Session::has('success'))
                <div class="alert alert-success">
                    <p>{{ Session::get('success') }}</p>

                </div>
            @endif

            @if (Session::has('error'))
                <div class="alert alert-danger">
                    <p>{{ Session::get('error') }}</p>

                </div>
            @endif

            <div class="row d-flex justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow border-0 p-5">
                        <h1 class="h3">Login</h1>
                        <form action="{{ route('account.authenticate') }}" method="post" name='loginForm' id='loginForm'>
                            @csrf
                            <div class="mb-3">
                                <label for="" class="mb-2">Email*</label>
                                <input type="text" value="{{old('email')}} " name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="example@example.com">

                                @error('email')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror

                            </div>
                            <div class="mb-3">
                                <label for="" class="mb-2">Password*</label>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Enter Password">
                                @error('password')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror

                            </div>
                            <div class="justify-content-between d-flex">
                                <button class="btn btn-primary mt-2">Login</button>
                                <a href="forgot-password.html" class="mt-3">Forgot Password?</a>
                            </div>
                        </form>
                    </div>
                    <div class="mt-4 text-center">
                        <p>Do not have an account? <a href="{{ route('account.registration') }}">Register</a></p>
                    </div>
                </div>
            </div>
            <div class="py-lg-5">&nbsp;</div>

        </div>
    </section>
@endsection

{{--
 @section('customJs')
    <script>
        $("#loginForm").submit(function (e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route('account.processlogin') }}',
                type: 'post',
                data: $("#loginForm").serializeArray(),
                dataType: 'json',
                success: function (response) {

                    if (response.status == false) {

                        var errors = response.errors;



                        if (errors.email) {
                            $("#email").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.email)
                        }

                        else {
                            $("#email").removeClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.email)

                        }

                        if (errors.password) {
                            $("#password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.password)
                        }

                        else {
                            $("#password").removeClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.password)

                        }



                    }

                    else {


                        $("#email").removeClass('is-invalid').siblings('p').addClass('invalid-feedback').html()

                        $("#password").removeClass('is-invalid').siblings('p').addClass('invalid-feedback').html()


                    }
                }

            })
        });
    </script>
@endsection
@endsession --}}

@extends('layout/app')
@section('title')
    Login
@endsection
@section('content')
    <div class="container rounded shadow-lg shadow-intensity-xl shadow-intensity-xl align-items-center justify-content-center"
        style="margin-top: 20vh; ">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp" class="img-fluid"
                    alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    @if ($errors->has('employee_id'))
                        <div class="alert alert-danger alert-block mt-4">
                            {{ $errors->first('employee_id') }}
                        </div>
                    @elseif ($errors->has('password'))
                        <div class="alert alert-danger alert-block mt-4">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                    <form action="{{ route('employees.loginValidate') }}" method="POST">
                        @csrf

                        <!-- admin id -->
                        <div class="form-outline mb-4">
                            <input type="text" id="employee_id" name="employee_id"
                                class="form-control form-control-lg required-field" placeholder="Enter admin id"
                                value="{{ old('employee_id') }}" />
                        </div>


                        <!-- Password -->
                        <div class="form-outline mb-3">
                            <input type="password" id="password" name="password"
                                class="form-control form-control-lg required-field" placeholder="Enter your password" />
                        </div>


                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" class="btn btn-primary btn-lg"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection

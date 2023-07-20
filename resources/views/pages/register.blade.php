@extends('layouts.login')

@section('title', 'Register')

@section('content')

<div class="container">

    <form class="m-auto mt-4 mb-4 w-25" action="{{ route('register') }}" method="post">
        <!-- Heading -->
        <h1 class="text-center" style="margin: 25% 0px">Register Page</h1>

        @csrf

        @include('includes.validationErrors')

        <!-- Email input -->
        <div class="form-outline mb-4">
            <label class="form-label" for="form2Example1">Email</label>
            <input type="email" id="form2Example1" name="email" class="form-control" value="{{ old('email') }}" />
        </div>
        <!-- Password input -->
        <div class="form-outline mb-4">
            <label class="form-label" for="form2Example2">Password</label>
            <input type="password" id="form2Example2" name="password" class="form-control" />
        </div>
        <!-- Password input -->
        <div class="form-outline mb-4">
            <label class="form-label" for="form2Example3">Password Confirmation</label>
            <input type="password" id="form2Example3" name="password_confirmation" class="form-control" />
        </div>
        <!-- Name input -->
        <div class="form-outline mb-4">
            <label class="form-label" for="form2Example4">Name</label>
            <input type="text" id="form2Example4" name="name" class="form-control" />
        </div>

        <div class="text-center">
            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block mb-4">Register</button>
        </div>

        <!-- Register buttons -->
        <div class="text-center">
            <p>Already a member? <a href="{{ route('loginView') }}">Login</a></p>
        </div>
    </form>

</div>

@stop
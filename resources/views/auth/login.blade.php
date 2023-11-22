@extends('layout.default')
@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-5 m-4 p-4">
            <h1>Login</h1>
            <form method="POST" action="{{ route('auth.login') }}">
                @csrf
                @if (Session::has('error'))
                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                @endif
                <div>
                    <span>Email</span>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" />
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <span>Password</span>
                    <input type="password" class="form-control" name="password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mt-3">Login</button>
            </form>
            <p class="text-center">Not a member? <a href="{{ route('auth.registerForm') }}">Create the new account!</a></p>
        </div>
    </div>
@endsection

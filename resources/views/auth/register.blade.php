@extends('layout.default')
@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-5 m-4 p-4">
            <h1>Register</h1>
            <form method="POST" action="{{ route('auth.register') }}">
                @csrf
                @if (Session::has('error'))
                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                @endif
                <div>
                    <span>Username</span>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" />
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
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
                <div>
                    <span>Repeat password</span>
                    <input type="password" class="form-control" name="password-repeat">
                    @error('password-repeat')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mt-3">Register</button>
            </form>
        </div>
    </div>
@endsection

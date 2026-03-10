@extends('layouts.auth')

@section('body')
    <div class="card-body">
        <div class="text-center">
            <h4 class="f-w-500 mb-1">Create New Account</h4>
            <p class="mb-4">Already have an Account? <a href="{{ route('login') }}" class="link-primary ms-1">Login
                    Now</a></p>
        </div>
        <form action="{{ route('register.store') }}" method="post">
            @csrf

            <div class="form-group mb-3">
                <input type="text" class="form-control" id="floatingInput" placeholder="Nama Lengkap" name="name" />
            </div>
            <div class="form-group mb-3">
                <input type="email" class="form-control" id="floatingInput" placeholder="Email Address" name="email" />
            </div>
            <div class="form-group mb-3">
                <input type="password" class="form-control" id="floatingInput1" placeholder="Password" name="password" />
            </div>
            <div class="form-group mb-3">
                <input type="password" class="form-control" id="floatingInput1" placeholder="Repeat Password" name="password_confirmation" />
            </div>

            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary">Daftar</button>
            </div>
        </form>
    </div>
@endsection

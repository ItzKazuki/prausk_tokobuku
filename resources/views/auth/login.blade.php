@extends('layouts.auth')

@section('body')
    <div class="card-body">
        <div class="text-center">
            <h4 class="f-w-500 mb-1">Login with your email</h4>
            <p class="mb-4">Don't have an Account? <a href="{{ route('register.create') }}" class="link-primary ms-1">Create
                    Account</a></p>
        </div>
        <form action="{{ route('login.store') }}" method="post">
            @csrf
            <div class="form-group mb-3">
                <input type="email" class="form-control" id="floatingInput" placeholder="Email Address" name="email" />
            </div>
            <div class="form-group mb-3">
                <input type="password" class="form-control" id="floatingInput1" placeholder="Password" name="password" />
            </div>
            {{-- <div class="d-flex mt-1 justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input input-primary" type="checkbox" id="customCheckc1"
                                        checked="" />
                                    <label class="form-check-label text-muted" for="customCheckc1">Remember me?</label>
                                </div>
                                <a href="../pages/forgot-password-v1.html">
                                    <h6 class="f-w-400 mb-0">Forgot Password?</h6>
                                </a>
                            </div> --}}
            <div class="d-grid mt-4">
                @auth
                    <a href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard.index') : route('user.dashboard.index') }}"
                        class="btn btn-success">Dashboard</a>
                @endauth
                @if (empty(Auth::check()))
                    <button type="submit" class="btn btn-primary">Login</button>
                @endif
            </div>
        </form>
    </div>
@endsection

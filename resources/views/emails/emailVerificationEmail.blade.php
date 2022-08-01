@extends('layout')

@section('content')
    <main class="login-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header"><b>Email Verification Mail</b></div>
                        <div class="card-body">

                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif

                            <form action="{{ route('company.Verify', request('token')) }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">Email-ID</label>
                                    <div class="col-md-6">
                                        <input type="text" id="email" class="form-control" name="email" required autofocus>
                                    </div>
                                </div>

                                @if($company->verify == 1)
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary"> Verify Email </button>
                                    </div>
                                @endif
                                
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
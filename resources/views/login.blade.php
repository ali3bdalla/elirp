@extends('_base')

@section('content')
    <div class=" position-absolute w-100 h-100 left-0 top-0 bg-login-image">
        <div class="d-flex align-items-center justify-content-center w-100 h-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-lg-12 col-md-9">
                        <div class="card o-hidden border-0 shadow-lg my-5">
                            <div class="card-body p-0">
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                                    <div class="col-lg-6">
                                        <div class="p-5">
                                            <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                            </div>
                                            @foreach($oauthClients as $oauth)
                                                <a href="/auth/{{$oauth}}/redirect"
                                                   class="btn btn-{{$oauth}} btn-user btn-block">
                                                    <i class="fab fa-{{$oauth}} fa-fw"></i> Login with {{ $oauth }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

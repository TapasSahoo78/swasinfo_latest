@extends( auth()->user()->hasRole('customer') ? 'customer.layouts.app' : 'layouts.app',['navbar'=>false,'sidebar'=>false,'footer'=>false,'subTitle'=>'','noContent'=>true] )

@section('verify')
<div class="container">
    <div class="row justify-content-center custom-align-center">
        <div class="col-md-8">
            <div class="card ask-to-verify">
                <div class="card-header"><h2>{{ __('Verify Your Email Address') }}</h2></div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                   <p> {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}"></p>
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

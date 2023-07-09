@extends('frontend.layouts.app')

@section('content')
<div class="row">
    <div class="col s12 m6 offset-m3">
        <div class="card0">

            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    <div class="center text-success">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                </div>
            @endif

            <h4 class="center indigo-text uppercase">
                {{ __('Verify Your Email Address') }}
            </h4>

            <div class="center">
                {{ __('Before proceeding, please check your email for a verification link.') }}
            </div>

            <div class="center p-20">
                {{ __('If you did not receive the email') }}
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">{{ __('click here to request another') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection


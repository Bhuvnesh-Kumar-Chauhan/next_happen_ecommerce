@extends('master')

@section('content')
    @php
        $setting = \App\Models\Setting::find(1);
    @endphp

    <section class="section">
        <div class="d-flex flex-wrap align-items-stretch">
            <!-- Left Side - Form -->
            <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
                <div class="p-4 m-3">
                    <!-- Logo -->
                    <img src="{{ $setting->logo ? asset('/images/upload/' . $setting->logo) : asset('/images/logo.png') }}"
                         alt="logo" height="50px" class="mb-4 mt-2 w-auto">

                    <h4 class="text-dark font-weight-normal mb-4">
                        {{ __('Welcome to ') }}
                        <span class="font-weight-bold">{{ $setting->app_name }}</span>
                    </h4>

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="mb-4">
                            @foreach ($errors->all() as $error)
                                <div class="p-4 mb-3 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                                    <span class="font-medium">{{ __('Error!') }}</span> {{ $error }}
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Session Error Message -->
                    @if (Session::has('error'))
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                            <span class="font-medium">{{ __('Error!') }}</span> {{ Session::get('error') }}
                        </div>
                    @endif

                    <!-- Session Success Message -->
                    @if (Session::has('success'))
                        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                            <span class="font-medium">{{ __('Success!') }}</span> {{ Session::get('success') }}
                        </div>
                    @endif

                    <!-- Register Form -->
                    <form method="POST" action="{{ url('admin/register') }}" class="needs-validation" novalidate>
                        @csrf

                        <!-- Form Inputs -->
                        <div class="form-group">
                            <label for="first_name">{{ __('First Name') }}</label>
                            <input id="first_name" type="text" class="form-control" name="first_name" required
                                   placeholder="{{ __('First Name') }}">
                        </div>

                        <div class="form-group">
                            <label for="last_name">{{ __('Last Name') }}</label>
                            <input id="last_name" type="text" class="form-control" name="last_name" required
                                   placeholder="{{ __('Last Name') }}">
                        </div>

                        <div class="form-group">
                            <label for="organization_name">{{ __('Organization Name') }}</label>
                            <input id="organization_name" type="text" class="form-control" name="organization_name" required
                                   placeholder="{{ __('Organization Name') }}">
                        </div>

                        <div class="form-group">
                            <label for="number">{{ __('Contact Number') }}</label>
                            <div class="d-flex">
                                <select name="Countrycode" class="form-control w-25">
                                    <option value="" disabled selected>{{ __('Select Country') }}</option>
                                    @foreach ($phone as $item)
                                        <option class=" " value="{{ $item->phonecode }}">
                                            {{ $item->name . '(+' . $item->phonecode . ')' }}
                                        </option>
                                    @endforeach
                                </select>
                                <input id="number" type="number" class="form-control w-75" name="phone"
                                       placeholder="{{ __('Number') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control" name="email" required
                                   placeholder="{{ __('Email') }}">
                        </div>

                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control" name="password" required
                                   placeholder="{{ __('Password') }}">
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right">
                                {{ __('Create Account') }}
                            </button>
                        </div>
                        
                        <input type="hidden" value="organizer" name="user_type"> 
                    </form>

                    <!-- Already Have an Account -->
                    <div class="text-center mt-4">
                        <p class="text-gray-600">
                            {{ __('Already have an account?') }}
                            <a href="{{ url('/login') }}" class="text-primary hover:underline">{{ __('Login') }}</a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Side - Background Image -->
            <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom"
                 data-background="{{ url('/images/auth_image.png') }}">
                <div class="absolute-bottom-left index-2">
                    <div class="text-light p-5 pb-2">
                        <h1 class="mb-2 display-4 font-weight-bold">{{ __('Welcome') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
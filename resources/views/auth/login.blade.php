<x-guest-layout>

    <style>
        /* Full-screen login background using FESSH image */
        .login-bg {
            background-image: url('{{ asset("assets/images/fessh-login-bg.png") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            width: 100%;
        }
        /* Center the auth wrapper with offset */
        .login-bg .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: flex-start; /* Change from center to flex-start */
            justify-content: center;
            padding: 2rem;
            padding-top: 20rem; /* Add top padding to move card down */
            /* padding-left: 50rem; */
        }
        /* Override authentication card styles */
        .min-h-screen {
            background: none !important;
            padding: 0 !important;
            min-height: 0 !important;
        }

        /* Target the exact card container from the component */
        .w-full.sm\:max-w-md {
            width: 340px !important;
            max-width: 340px !important;
            margin-top: 0 !important;
        }

        /* Style the white card background */
        .bg-white {
            background: rgba(255, 255, 255, 0.95) !important;
            border-radius: 8px !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
        }

        /* Remove default background */
        .bg-gray-100 {
            background: none !important;
        }

        /* Force form width */
        form {
            width: 100% !important;
            max-width: none !important;
        }

        /* Adjust form inputs */
        input.block {
            width: 100% !important;
            max-width: none !important;
        }
        /* Add a subtle overlay to improve readability */
        .login-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            /* background: rgba(0, 0, 0, 0.2); */
            z-index: 0;
        }
        .auth-wrapper {
            position: relative;
            z-index: 1;
        }
    </style>

    <div class="login-bg">
        <div class="auth-wrapper">
            <x-authentication-card>

                <x-slot name="logo">

                </x-slot>

                <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <div>
            <h2 style="text-align: center; font-size: large; font-weight: bold;">Login</h2>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                placeholder="KL123456@college.uptm.edu.my"/>
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password"
                placeholder="**************"/>
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    {{-- <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a> --}}
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
            </x-authentication-card>
        </div>
    </div>

</x-guest-layout>

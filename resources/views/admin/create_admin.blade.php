<!DOCTYPE html>
<html lang="en">
  <head>
    @include('admin.css')
  </head>
  <body>
    <div class="container-scroller">
      @include('admin.header')
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        @include('admin.sidebar')
        <div class="main-panel">
                    <div class="content-wrapper d-flex justify-content-center align-items-center" style="min-height: 80vh;">
                        <div class="card shadow-lg border-0 w-100" style="max-width: 800px;">
                            <div class="card-header bg-primary text-white text-center">
                                <h3 class="h4 mb-0">Create Admin</h3>
                            </div>
                            <div class="card-body p-4">
                                <form method="POST" action="{{ route('admin.store_admin') }}">
                                    <x-validation-errors class="mb-4" />
                                    @if(session('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif

                                    @if(session('error'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            {{ session('error') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif
                                    @csrf
                                    <div class="mb-3">
                                        <x-label for="name" value="{{ __('Name') }}" />
                                        <x-input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                    </div>
                                    <div class="mb-3">
                                        <x-label for="email" value="{{ __('Email') }}" />
                                        <x-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" />
                                    </div>
                                    <div class="mb-3">
                                        <x-label for="userId" value="{{ __('Staff Id') }}" />
                                        <x-input id="userId" class="form-control" type="text" name="userId" :value="old('userId')" autocomplete="userId" />
                                    </div>
                                    <div class="mb-3">
                                        <x-label for="password" value="{{ __('Password') }}" />
                                        <x-input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
                                    </div>
                                    <div class="mb-3">
                                        <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                                        <x-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
                                    </div>
                                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                        <div class="mb-3">
                                            <x-label for="terms">
                                                <div class="form-check">
                                                    <x-checkbox name="terms" id="terms" required class="form-check-input" />
                                                    <label class="form-check-label ms-2">
                                                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="text-decoration-underline text-primary">'.__('Terms of Service').'</a>',
                                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="text-decoration-underline text-primary">'.__('Privacy Policy').'</a>',
                                                        ]) !!}
                                                    </label>
                                                </div>
                                            </x-label>
                                        </div>
                                    @endif
                                    <div class="d-grid mt-4">
                                        <x-button class="btn btn-primary btn-lg">
                                            {{ __('Create Admin') }}
                                        </x-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

          </div>
        </div>
      </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          @include('admin.footer')
    </div>
  </body>
</html>

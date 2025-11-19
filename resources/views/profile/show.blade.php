@php
use Illuminate\Support\Facades\Auth;
@endphp

<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="/public">
    @if(Auth::user()->role == 'lecturer')
      @include('lecturer.css')
    @elseif(Auth::user()->role == 'student')
      @include('student.css')
    @elseif(Auth::user()->role == 'admin')
      @include('admin.css')
    @endif
    <style>
        .card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background: #4B49AC;
            color: white;
            border-radius: 10px 10px 0 0;
            padding: 1.5rem;
        }
        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1.5rem;
        }
        .form-section {
            background: white;
            padding: 2rem;
            margin-bottom: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      @if(Auth::user()->role == 'lecturer')
        @include('lecturer.header')
      @elseif(Auth::user()->role == 'student')
        @include('student.header')
      @elseif(Auth::user()->role == 'admin')
        @include('admin.header')
      @endif

      <div class="container-fluid page-body-wrapper">
        @if(Auth::user()->role == 'lecturer')
          @include('lecturer.sidebar')
        @elseif(Auth::user()->role == 'student')
          @include('student.sidebar')
        @elseif(Auth::user()->role == 'admin')
          @include('admin.sidebar')
        @endif

        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row justify-content-center">
              <div class="col-12 col-xl-11">

                <!-- Main Profile Card -->
                <div class="card">

                    <div class="card-body p-4">
                        <!-- Password Update Section -->
                        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                            <div class="form-section">
                                @livewire('profile.update-password-form')
                            </div>
                        @endif

                        <!-- Browser Sessions Section -->
                        <div class="form-section mb-0">
                            @livewire('profile.logout-other-browser-sessions-form')
                        </div>
                    </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @if(Auth::user()->role == 'lecturer')
      @include('lecturer.footer')
    @elseif(Auth::user()->role == 'student')
      @include('student.footer')
    @elseif(Auth::user()->role == 'admin')
      @include('admin.footer')
    @endif
  </body>
</html>




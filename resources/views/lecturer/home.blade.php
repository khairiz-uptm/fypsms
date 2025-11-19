<!DOCTYPE html>
<html lang="en">
  <head>
    @include('lecturer.css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
      .card {
        background: white;
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        margin-bottom: 25px;
      }
      .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
      }
      .feature-card {
        min-height: 180px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 2rem;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
      }
      .feature-card:hover {
        text-decoration: none;
        color: inherit;
      }
      .feature-icon {
        font-size: 2rem;
        margin-bottom: 1rem;
        color: #4B49AC;
      }
      .feature-title {
        font-size: 1.2rem;
        color: #333;
        margin-bottom: 0.5rem;
      }
      .welcome-card {
        background: linear-gradient(135deg, #f76969 0%, #2c30ff 100%);
        color: white;
        padding: 2rem;
        margin-bottom: 2rem;
        text-align: center;
      }
      .welcome-card h2 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 500;
      }
      .welcome-card p {
        margin: 1rem auto 0;
        opacity: 0.9;
        max-width: 600px;
      }
      .welcome-card:hover {
        transform: none;
      }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      @include('lecturer.header')
      <div class="container-fluid page-body-wrapper">
        @include('lecturer.sidebar')
        <div class="main-panel">
          <div class="content-wrapper">
            <!-- Welcome Card -->
            <div class="row mb-4">
              <div class="col-12">
                <div class="card welcome-card">

                    @if (Auth::user()->profile && Auth::user()->profile->supervisor_name )
                    <h2>Welcome, {{ Str::limit(Auth::user()->profile->supervisor_name, 30, '...') }} !</h2>
                    @else
                    <h2>Welcome, {{ Str::limit(Auth::user()->name, 30, '...')  }}!</h2>
                    @endif

                  <p style="color: white">Manage your Final Year Project students from this dashboard.</p>
                </div>
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
              </div>
            </div>

            <!-- Features Grid -->
            <div class="row">
              <div class="col-xl-6 col-md-6">
                <a href="{{url('view_supervisee', auth()->user()->id)}}" class="card feature-card">
                  <i class="bi bi-people feature-icon"></i>
                  <h5 class="feature-title">My Students</h5>
                  <p class="text-muted mb-0">{{ $totalSupervisees }} Supervised Students</p>
                </a>
              </div>
              <div class="col-xl-6 col-md-6">
                <a href="{{url('view_request', auth()->user()->id)}}" class="card feature-card">
                  <i class="bi bi-clipboard-check feature-icon"></i>
                  <h5 class="feature-title">Supervision Requests</h5>
                  <p class="text-muted mb-0">{{ $pendingRequests }} Pending Requests</p>
                </a>
              </div>
              <div class="col-xl-6 col-md-6">
                <a href="{{url('profile')}}" class="card feature-card">
                  <i class="bi bi-person-badge feature-icon"></i>
                  <h5 class="feature-title">My Profile</h5>
                  <p class="text-muted mb-0">Update Profile Information</p>
                </a>
              </div>
              <div class="col-xl-6 col-md-6">
                @if (!auth()->user()->profile)
                <a href="{{ url('profile') }}" class="card feature-card" onclick="event.preventDefault(); alert('Please create your profile first.');">
                  <i class="bi bi-file-text feature-icon"></i>
                  <h5 class="feature-title">Reports</h5>
                  <p class="text-muted mb-0">You must have a profile</p>
                </a>
                @else
                <a href="{{ route('supervisee.report', auth()->user()->profile->id) }}" class="card feature-card">
                  <i class="bi bi-file-text feature-icon"></i>
                  <h5 class="feature-title">Reports</h5>
                  <p class="text-muted mb-0">Generate Supervision Report</p>
                </a>
                @endif
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
    @include('lecturer.footer')
  </body>
</html>

<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="/public">
    @include('admin.css')
  </head>
  <body>
    <div class="container-scroller">
      @include('admin.header')
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->

        @include('admin.sidebar')

        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row justify-content-center">
              <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 mt-4 mb-4">
                  <div class="card-header bg-primary text-white text-center">
                    <h3 class="h4 mb-0">Supervisee Profile</h3>
                  </div>
                  <div class="card-body">
                    @if ($student_profile)
                      <div class="d-flex flex-column align-items-center mb-4">
                        <img class="rounded-circle shadow mb-3" style="width: 140px; height: 140px; object-fit: cover; border: 4px solid #e9ecef;" src="{{ $student_profile->student_profile_picture ? asset('uploads/students/' . $student_profile->student_profile_picture) : asset('uploads/students/default_profile.jpg') }}" alt="Profile Picture">
                        <h4 class="mb-1 mt-2">{{ $student_profile->student_name }}</h4>
                        <span class="text-muted">{{ $student_profile->student_profile->email }}</span>
                      </div>
                      <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item"><strong></strong></li>
                        <li class="list-group-item"><strong>Phone Number:</strong> {{ $student_profile->student_phone }}</li>
                        <li class="list-group-item"><strong>Current Semester:</strong> Semester {{ $student_profile->student_semester }}</li>
                        <li class="list-group-item"><strong>Session:</strong> {{ $student_profile->student_session }}</li>
                        <li class="list-group-item"><strong>Course:</strong> {{ $student_profile->student_course }}</li>
                        <li class="list-group-item"><strong></strong></li>
                      </ul>
                    @else

                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->

    </div>
    @include('admin.footer')
  </body>
</html>

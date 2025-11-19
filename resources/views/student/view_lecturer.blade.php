<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="/public">
    @include('student.css')
  </head>
  <body>
    <div class="container-scroller">
      @include('student.header')
        <div class="container-fluid page-body-wrapper">
        @include('student.sidebar')
            <div class="main-panel">
                <div class="content-wrapper">

                    <div class="row mt-4 mb-4 g-4">
                        <div class="col-lg-6">
                            <div class="card shadow-lg border-0 h-100">
                                <div class="card-header bg-primary text-white text-center">
                                    <h3 class="h4 mb-0">Profile</h3>
                                </div>
                                <div class="card-body">
                                    @if ($supervisor != null)
                                        <div class="d-flex flex-column align-items-center mb-4">
                                            <img class="rounded-circle shadow mb-3" style="width: 140px; height: 140px; object-fit: cover; border: 4px solid #e9ecef;" src="{{ $supervisor->supervisor_profile_picture ? asset('uploads/supervisors/' . $supervisor->supervisor_profile_picture) : asset('uploads/default_profile.jpg') }}" alt="Profile Picture">
                                            <h4 class="mb-1 mt-2">{{ $supervisor->supervisor_name }}</h4>
                                            <span class="text-muted">{{ $supervisor->profile->email }}</span>
                                        </div>
                                        <ul class="list-group list-group-flush mb-3">
                                            <li class="list-group-item"><strong></strong></li>
                                            <li class="list-group-item"><strong>Phone Number:</strong> {{ $supervisor->supervisor_phone }}</li>
                                            <li class="list-group-item"><strong>Department:</strong> {{ $supervisor->supervisor_department }}</li>
                                            <li class="list-group-item"><strong>Expertise:</strong> {{ $supervisor->supervisor_expertise }}</li>
                                            <li class="list-group-item"><strong></strong></li>
                                        </ul>
                                    @else
                                        <div class="card-header bg-primary text-white text-center">
                                            <h3 class="h4 mb-0">Profile doesn't exist!</h3>
                                        </div>
                                    @endif
                                    @if ($supervisor)
                                        <div class="text-center mt-4">
                                            <a href="{{ url('request_page', $supervisor->id) }}?title={{ urlencode(request('title')) }}" class="btn btn-outline-warning btn-sm rounded-pill me-2" onclick="return confirm('Are you sure to request supervision from this lecturer?')">Request Supervision</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card shadow-lg border-0 h-100">
                                <div class="card-header bg-danger text-white text-center">
                                    <h3 class="h4 mb-0">Supervisee List</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped">
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
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Project Title</th>
                                                <th>Course</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($supervisees as $supervisee)
                                            <tr>
                                                <td class="wrap-text" title="{{ $supervisee->student->student_name }}">
                                                    {{ Str::limit($supervisee->student->student_name ?? '-', 70, '...') }}
                                                </td>
                                                <td class="wrap-text" title="{{ $supervisee->project_title }}">
                                                    {{ Str::limit($supervisee->project_title ?? '-', 50, '...') }}
                                                </td>
                                                <td>
                                                    {{ $supervisee->student->student_course ?? '-' }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
        </div>

    </div>
    @include('student.footer')
  </body>
</html>

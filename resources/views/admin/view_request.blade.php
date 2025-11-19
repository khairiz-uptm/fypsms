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
        @include('admin.sidebar')

        <div class="main-panel">
          <div class="content-wrapper">

        <div class="col-12">
            <div class="card shadow-lg border-0 h-100 w-100" style="max-width: 100vw;">
                        <div class="card-header bg-danger text-white text-center">
                            <h3 class="h4 mb-0">Supervision Request</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
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
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Name</th>
                                            <th>Project Title</th>
                                            <th>Course</th>
                                            <th>Status</th>
                                            <th>Requested at</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($supervisee_requests->isEmpty())
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                You have no supervision requests.
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @else
                                        @foreach ($supervisee_requests as $supervisee_request)
                                        <tr>
                                            <td class="wrap-text" title="{{ $supervisee_request->student->supervisee_name ?? '-' }}">
                                                <img class="rounded-circle shadow mb-3" style="width: 60px; height: 60px; object-fit: cover; border: 4px solid #e9ecef;" src="{{ $supervisee_request->student->student_profile_picture ? asset('uploads/students/' . $supervisee_request->student->student_profile_picture) : asset('uploads/students/default_profile.jpg') }}" alt="Profile Picture">
                                            </td>

                                            <td class="wrap-text" title="{{ $supervisee_request->student->student_name ?? '-' }}">
                                                {{ Str::limit($supervisee_request->student->student_name, 70, '...') ?? '-' }}
                                            </td>
                                            <td class="wrap-text" title="{{ $supervisee_request->project_title ?? '-' }}">
                                                {{ Str::limit($supervisee_request->project_title, 70, '...') ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $supervisee_request->student->student_course ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $supervisee_request->status ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $supervisee_request->request_date ?? '-' }}
                                            </td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center">
                                                    <div class="" role="group" aria-label="Request actions">
                                                        <a href="{{ url('view_supervisee_profile', $supervisee_request->student->id) }}" class="btn btn-sm btn-primary me-2" title="View Profile">
                                                            <i class="bi bi-person me-1" aria-hidden="true"></i>View Profile
                                                        </a>
                                                        <a href="{{ url('/approve_request', $supervisee_request->id) }}" class="btn btn-sm btn-success me-2" onclick="return confirm('Are you sure to approve this request?')" title="Approve">
                                                            <i class="fa fa-check me-1" aria-hidden="true"></i>Approve
                                                        </a>
                                                        <a href="{{ url('/decline_request', $supervisee_request->id) }}" class="btn btn-sm btn-outline-danger me-2" onclick="return confirm('Are you sure to decline this request?')" title="Decline">
                                                            <i class="fa fa-times me-1" aria-hidden="true"></i>Decline
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
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

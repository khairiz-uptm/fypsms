<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="/public">
    @include('lecturer.css')
  </head>
  <body>
    <div class="container-scroller">
      @include('lecturer.header')
      <div class="container-fluid page-body-wrapper">
        @include('lecturer.sidebar')

        <div class="main-panel">
          <div class="content-wrapper">

            {{-- Start sini --}}

            <div class="col-12">
    <div class="card shadow-lg border-0 h-100 w-100 " style="max-width: 100vw;">
        <div class="card-header bg-danger text-white text-center">
            <h3 class="h4 mb-0">Supervisee List</h3>
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
                    <div class="d-flex justify-content-end mb-3">

                        <a href="{{ route('supervisee.report', $supervisor->id) }}"
                        class="btn btn-danger shadow-sm d-flex align-items-center gap-2">
                            <i class="bi bi-file-earmark-pdf-fill fs-5"></i>
                            <span class="fw-semibold">+ Generate PDF</span>
                        </a>
                    </div>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Project Title</th>
                            <th>Description/Message</th>
                            <th>Course</th>
                            <th>Status</th>
                            <th style="text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($supervisees->isEmpty())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                You have no supervisee.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @else
                        @foreach ($supervisees as $supervisee)
                        <tr>
                            <td class="wrap-text" title="{{ $supervisee->student->student_name ?? '-' }}">
                                {{ Str::limit($supervisee->student->student_name, 80, '...') ?? '-' }}
                            </td>

                            <td class="wrap-text" title="{{ $supervisee->project_title ?? '-' }}">
                                {{ Str::limit($supervisee->project_title, 80, '...') ?? '-' }}
                            </td>

                            <td class="wrap-text" title="{{ $supervisee->request_message ?? '-' }}">
                                {{ Str::limit($supervisee->request_message, 80, '...') ?? '-' }}
                            </td>

                            <td>
                                {{ $supervisee->student->student_course ?? '-' }}
                            </td>

                            <td>
                                {{ $supervisee->status ?? '-' }}
                            </td>

                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center">
                                    <div class="" role="group" aria-label="Request actions">
                                        <a href="{{ route('student.report', $supervisee->student->id) }}" class="btn btn-danger btn-sm me-2" title="Generate Student Report">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                        <a href="{{ url('view_supervisee_profile', $supervisee->student->id) }}" class="btn btn-sm btn-primary me-2" title="View Profile">
                                            <i class="bi bi-person me-1" aria-hidden="true"></i>View Profile
                                        </a>
                                        <a href="{{ url('decline_request', $supervisee->id) }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure to decline this request?')" title="Decline">
                                            <i class="fa fa-times me-1" aria-hidden="true"></i>Decline Supervision
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


            {{-- End sini --}}


            </div>
          </div>
        </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->

    </div>
    @include('lecturer.footer')
  </body>
</html>

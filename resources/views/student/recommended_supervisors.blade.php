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

                    <div class="row justify-content-center mb-2">
                        <div class="col-12 mb-3">
                            <div class="card border-0 shadow rounded-4 h-100 bg-white">
                                <div class="card-body p-4">

                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <i class="h5 mb-0">
                                            <strong>Project Title:</strong> {{ $projectTitle }}
                                        </i>
                                        <a href="{{ url('/propose_title') }}" class="btn btn-outline-warning rounded-pill px-4">
                                            Change Title
                                        </a>
                                    </div>
                                    <div>
                                        <small class="text-muted" style="font-style: italic"><strong style="color: red">*</strong> Recommended supervisors are not always accurate. Please read their expertise first before attempting to request.</small>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="col-12">
                            <div class="card border-0 shadow rounded-4 h-100 bg-white">
                                <div class="card-header bg-info text-white text-center rounded-top-4 py-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="h4 mb-0">
                                            <i class="h4 mb-0">Supervisor Recommended</i>
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body p-4">
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
                                        @if($supervisors->isEmpty())
                                            <p>No matching supervisors found.</p>
                                        @else
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Phone</th>
                                                        <th>Expertise</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($supervisors as $supervisor)
                                                    @php
                                                        $status = $statuses->firstWhere('lecturer_id', $supervisor->id);
                                                        $hasApproved = $statuses->contains('status', 'approved');
                                                    @endphp
                                                        <tr>
                                                            <td>
                                                                <img class="rounded-circle shadow mb-3" style="width: 60px; height: 60px; object-fit: cover; border: 4px solid #e9ecef;" src="{{ $supervisor->supervisor_profile_picture ? asset('uploads/supervisors/' . $supervisor->supervisor_profile_picture) : asset('uploads/supervisors/default_profile.jpg') }}" alt="Profile Picture">
                                                            </td>
                                                            <td class="wrap-text">{{ $supervisor->supervisor_name }}</td>
                                                            <td class="wrap-text">{{ $supervisor->profile->email }}</td>
                                                            <td>{{ $supervisor->supervisor_phone }}</td>
                                                            <td class="wrap-text">{{ $supervisor->supervisor_expertise }}</td>
                                                            <td>
                                                                @if ($hasApproved)
                                                                    {{-- Already approved by one lecturer, block all --}}
                                                                    <a href="{{ url('view_lecturer', $supervisor->id) }}" class="btn btn-secondary" disabled>Can't Request</a>

                                                                @elseif ($status && $status->status == 'pending')
                                                                    <a href="{{ url('view_lecturer', $supervisor->id) }}" class="btn btn-warning" disabled>Requested</a>

                                                                @elseif ($status && $status->status == 'rejected')
                                                                    <a href="{{ url('view_lecturer', $supervisor->id) }}" class="btn btn-danger" disabled>Rejected</a>

                                                                @else
                                                                    {{-- No approval yet, can request --}}
                                                                    <a href="{{ url('view_lecturer', $supervisor->id) }}?title={{ urlencode($projectTitle) }}" class="btn btn-primary">Request</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                        {{-- {{ $supervision_requests->links('pagination::bootstrap-5') }} --}}
                                    </div>
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
    @include('student.footer')
  </body>
</html>

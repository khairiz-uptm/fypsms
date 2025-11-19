<!DOCTYPE html>
<html lang="en">
  <head>
    @include('student.css')
  </head>
  <body>
    <div class="container-scroller">
      @include('student.header')
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        @include('student.sidebar')
        <div class="main-panel">
          <div class="content-wrapper">
            <!-- Page Title Header Starts-->

                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4 mb-0 flex-grow-1">Find Supervisor</h3>
                        <form action="{{ url('search_supervisor') }}" method="GET" class="d-flex align-items-center gap-2 ms-auto" style="max-width: 400px;">
                          <input class="form-control rounded-pill px-3 py-2" style="font-size: 1rem;" type="search" name="query" placeholder="Lecturer / Expertise" aria-label="Search" value="{{ $query ?? '' }}">
                          <button class="btn btn-outline-primary rounded-pill px-4 py-2" style="font-size: 1rem; height: 42px;" type="submit">Search</button>
                        </form>
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-hover align-middle">
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
                                <th scope="col"></th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Expertise</th>
                                <th scope="col">Progress</th>
                                <th scope="col">Profile</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($supervisors as $supervisor)
                                @php
                                    $status = $statuses->firstWhere('lecturer_id', $supervisor->id);
                                    $hasApproved = $statuses->contains('status', 'approved');
                                @endphp
                            <tr>
                                <td class="wrap-text" title="{{ $supervisor->supervisor_name ?? '-' }}">
                                    <img class="rounded-circle shadow mb-3" style="width: 60px; height: 60px; object-fit: cover; border: 4px solid #e9ecef;" src="{{ $supervisor->supervisor_profile_picture ? asset('uploads/supervisors/' . $supervisor->supervisor_profile_picture) : asset('uploads/supervisors/default_profile.jpg') }}" alt="Profile Picture">
                                </td>

                                <td class="wrap-text" title="{{ $supervisor->supervisor_name ?? '-' }}">
                                    {{ Str::limit($supervisor->supervisor_name, 70,'...') }}
                                </td>

                                <td class="wrap-text" title="{{ $supervisor->profile->email ?? '-' }}">
                                    {{ Str::limit($supervisor->profile->email, 70, '...') }}
                                </td>

                                <td>
                                    {{ $supervisor->supervisor_phone }}
                                </td>

                                <td class="wrap-text" title="{{ $supervisor->supervisor_expertise ?? '-' }}">
                                    {{ Str::limit($supervisor->supervisor_expertise, 70, '...') }}
                                </td>

                                <td>
                                     {{ optional($statuses->firstWhere('lecturer_id', $supervisor->id))->status ?? 'not requested' }}
                                </td>
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
                                        <a href="{{ url('view_lecturer', $supervisor->id) }}" class="btn btn-primary">Request</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                        {{ $supervisors->links('pagination::bootstrap-5') }}
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

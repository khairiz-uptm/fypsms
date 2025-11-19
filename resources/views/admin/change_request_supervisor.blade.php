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

                    <div class="row justify-content-center mb-2">

                        <div class="col-12 mb-3">
                            <div class="card border-0 shadow rounded-4 h-100 bg-white">
                                <div class="card-header bg-info text-white text-center rounded-top-4 py-4">
                                    <h3 class="h4 mb-0">
                                        <i class="h4 mb-0">Current Suppervisor</i>
                                    </h3>
                                </div>
                                <div class="card-body p-4">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Supervisor Requested</th>
                                                    <th>Student Name</th>
                                                    <th>Phone</th>
                                                    <th>Department</th>
                                                    <th>Expertise</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="fw-semibold wrap-text" title="{{ $requestModel->supervisor->supervisor_name }}">
                                                        <i class="bi bi-calendar-event me-1 text-primary"></i>
                                                        {{ Str::limit($requestModel->supervisor->supervisor_name, 70,'...') }}
                                                    </td>

                                                    <td class="fw-semibold wrap-text" title="{{ $requestModel->student->student_name }}">
                                                        <i class="bi bi-calendar-event me-1 text-primary"></i>
                                                        {{ Str::limit($requestModel->student->student_name, 30,'...') }}
                                                    </td>

                                                    <td class="fw-semibold wrap-text" title="{{ $requestModel->supervisor->supervisor_phone }}">
                                                        <i class="bi bi-calendar-event me-1 text-primary"></i>
                                                        {{ Str::limit($requestModel->supervisor->supervisor_phone, 70,'...') }}
                                                    </td>

                                                    <td class="fw-semibold wrap-text" title="{{ $requestModel->supervisor->supervisor_department }}">
                                                        <i class="bi bi-calendar-event me-1 text-primary"></i>
                                                        {{ Str::limit($requestModel->supervisor->supervisor_department, 70,'...') }}
                                                    </td>

                                                    <td class="fw-semibold wrap-text" title="{{ $requestModel->supervisor->supervisor_expertise }}">
                                                        <i class="bi bi-calendar-event me-1 text-primary"></i>
                                                        {{ Str::limit($requestModel->supervisor->supervisor_expertise, 70,'...') }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card border-0 shadow rounded-4 h-100 bg-white">
                                <div class="card-header bg-info text-white text-center rounded-top-4 py-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="h4 mb-0">
                                            <i class="h4 mb-0">Change Supervisor</i>
                                        </h3>

                                        <form action="{{ url('search_supervisor/' . $requestModel->id) }}" method="GET" class="d-flex align-items-center gap-2" style="max-width: 400px;">
                                            <input class="form-control rounded-pill px-3 py-2" style="font-size: 1rem;" type="search" name="query" placeholder="Search..." aria-label="Search" value="{{ $query ?? '' }}">
                                            <button class="btn btn-primary rounded-pill px-4 py-2" style="font-size: 1rem; height: 42px;" type="submit">Search</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="">Name</th>
                                                    <th class="">Email</th>
                                                    <th class="">Department</th>
                                                    <th class="">Expertise</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($supervisors_profile as $supervisor_profile)
                                                <tr>
                                                    <td class="fw-semibold wrap-text" title="{{ $supervisor_profile->supervisor_name }}">
                                                        <i class="bi bi-calendar-event me-1 text-primary"></i>
                                                        {{ Str::limit($supervisor_profile->supervisor_name, 70,'...') }}
                                                    </td>

                                                    <td class="fw-semibold wrap-text" title="{{ $supervisor_profile->profile->email }}">
                                                        <i class="bi bi-calendar-event me-1 text-primary"></i>
                                                        {{ Str::limit($supervisor_profile->profile->email, 70,'...') }}
                                                    </td>

                                                    <td class="fw-semibold wrap-text" title="{{ $supervisor_profile->supervisor_department }}">
                                                        <i class="bi bi-calendar-event me-1 text-primary"></i>
                                                        {{ Str::limit($supervisor_profile->supervisor_department, 70,'...') }}
                                                    </td>

                                                    <td class="fw-semibold wrap-text" title="{{ $supervisor_profile->supervisor_expertise }}">
                                                        <i class="bi bi-calendar-event me-1 text-primary"></i>
                                                        {{ Str::limit($supervisor_profile->supervisor_expertise, 70,'...') }}
                                                    </td>

                                                    <td class="text-center">
                                                        <a href="{{ url('/update_requested_supervisor/' . $requestModel->id . '/' . $supervisor_profile->id) }}"
                                                            class="btn btn-outline-warning btn-sm rounded-pill me-2"
                                                            onclick="return confirm('Are you sure to change to this lecturer?')">
                                                            <i class="bi bi-pencil-square"></i> Change to This Supervisor
                                                        </a>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td class="text-center text-muted" colspan="2">No Supervisor found.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        {{ $supervisors_profile->links('pagination::bootstrap-5') }}
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
    @include('admin.footer')
  </body>
</html>

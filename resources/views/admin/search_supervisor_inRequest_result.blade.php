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

                        <div class="col-12">
                            <div class="card border-0 shadow rounded-4 h-100 bg-white">
                                <div class="card-header bg-info text-white text-center rounded-top-4 py-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="h4 mb-0">
                                            <i class="h4 mb-0">Supervisor List</i>
                                        </h3>

                                        <form action="{{ url('search_supervisor_inRequest') }}" method="GET" class="d-flex align-items-center gap-2" style="max-width: 400px;">
                                            <input type="hidden" name="return" value="{{ request('return') }}">
                                            @if(request()->has('student_name'))
                                                <input type="hidden" name="student_name" value="{{ request('student_name') }}">
                                            @endif

                                            <input class="form-control rounded-pill px-3 py-2" style="font-size: 1rem;"
                                                type="search" name="query" placeholder="Search..." aria-label="Search" value="{{ $query ?? '' }}">
                                            <button class="btn btn-primary rounded-pill px-4 py-2" style="font-size: 1rem; height: 42px;" type="submit">
                                                Search
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th></th>
                                                    <th class="">Name</th>
                                                    <th class="">Email</th>
                                                    <th class="">Department</th>
                                                    <th class="">Expertise</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($supervisors as $supervisor_profile)
                                                <tr>
                                                    <td class="wrap-text" title="{{ $supervisor_profile->supervisor_name ?? '-' }}">
                                                        <img class="rounded-circle shadow mb-3" style="width: 60px; height: 60px; object-fit: cover; border: 4px solid #e9ecef;" src="{{ $supervisor_profile->supervisor_profile_picture ? asset('uploads/supervisors/' . $supervisor_profile->supervisor_profile_picture) : asset('uploads/supervisors/default_profile.jpg') }}" alt="Profile Picture">
                                                    </td>

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
                                                        @php
                                                            $separator = Str::contains($returnUrl, '?') ? '&' : '?';
                                                            // Use supervisor_id instead of supervisor_name
                                                            $url = $returnUrl . $separator . 'supervisor_id=' . $supervisor_profile->id;

                                                            // Preserve student_name if exists
                                                            if (request()->has('student_name')) {
                                                                $url .= '&student_name=' . urlencode(request('student_name'));
                                                            }
                                                        @endphp

                                                        <a href="{{ $url }}"
                                                            class="btn btn-outline-warning btn-sm rounded-pill me-2">
                                                            <i class="bi bi-pencil-square"></i> Select Supervisor
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

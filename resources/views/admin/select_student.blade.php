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
                                            <i class="h4 mb-0">Student List</i>
                                        </h3>

                                        <form action="{{ url('search_student_inRequest') }}" method="GET" class="d-flex align-items-center gap-2" style="max-width: 400px;">
                                            <input type="hidden" name="return" value="{{ request('return') }}">
                                            @if(request()->has('supervisor_name'))
                                                <input type="hidden" name="supervisor_name" value="{{ request('supervisor_name') }}">
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
                                                    <th class="">Course</th>
                                                    <th class="">Semester</th>
                                                    <th class="">Current Session</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($students as $student)
                                                <tr>
                                                    <td class="wrap-text" title="{{ $student->student_name ?? '-' }}">
                                                        <img class="rounded-circle shadow mb-3" style="width: 60px; height: 60px; object-fit: cover; border: 4px solid #e9ecef;" src="{{ $student->student_profile_picture ? asset('uploads/students/' . $student->student_profile_picture) : asset('uploads/students/default_profile.jpg') }}" alt="Profile Picture">
                                                    </td>

                                                    <td class="fw-semibold wrap-text" title="{{ $student->student_name }}">
                                                        <i class="me-1 text-primary"></i>
                                                        {{ Str::limit($student->student_name, 70,'...') }}
                                                    </td>

                                                    <td class="fw-semibold wrap-text" title="{{ $student->student_profile->email }}">
                                                        <i class="me-1 text-primary"></i>
                                                        {{ Str::limit($student->student_profile->email, 70,'...') }}
                                                    </td>

                                                    <td class="fw-semibold wrap-text" title="{{ $student->student_course }}">
                                                        <i class="me-1 text-primary"></i>
                                                        {{ Str::limit($student->student_course, 70,'...') }}
                                                    </td>

                                                    <td class="fw-semibold wrap-text" title="Semester {{ $student->student_semester }}">
                                                        <i class="me-1 text-primary"></i>
                                                        Semester {{ Str::limit($student->student_semester, 70,'...') }}
                                                    </td>

                                                    <td class="fw-semibold wrap-text" title="{{ $student->student_session }}">
                                                        <i class="me-1 text-primary"></i>
                                                        {{ Str::limit($student->student_session, 70,'...') }}
                                                    </td>

                                                    <td class="text-center">
                                                        <a href="{{ $returnUrl }}{{ Str::contains($returnUrl, '?') ? '&' : '?' }}student_id={{ urlencode($student->id) }}"
                                                            class="btn btn-outline-warning btn-sm rounded-pill me-2">
                                                            <i class="bi bi-pencil-square"></i> Select Student
                                                        </a>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td class="text-center text-muted" colspan="2">No Student found.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        {{ $students->links('pagination::bootstrap-5') }}
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

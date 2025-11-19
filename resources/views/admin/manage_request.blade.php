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
                                            <i class="h4 mb-0">Manage Request</i>
                                        </h3>

                                        <form action="{{ url('search_request') }}" method="GET" class="d-flex align-items-center gap-2" style="max-width: 400px;">
                                            <input class="form-control rounded-pill px-3 py-2" style="font-size: 1rem;" type="search" name="query" placeholder="Search..." aria-label="Search" value="{{ $query ?? '' }}">
                                            <button class="btn btn-primary rounded-pill px-4 py-2" style="font-size: 1rem; height: 42px;" type="submit">Search</button>
                                        </form>
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
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="">Supervisor Requested</th>
                                                    <th class="">Requested by</th>
                                                    <th class="">Project Title</th>
                                                    <th class="">Requested Message</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($supervision_requests as $request)
                                                <tr>
                                                    <td class="fw-semibold wrap-text" title="{{ $request->supervisor->supervisor_name}}">
                                                        <i class="bi me-1 text-primary"></i>
                                                        {{ Str::limit($request->supervisor->supervisor_name, 70,'...') }}
                                                    </td>

                                                    <td class="fw-semibold wrap-text" title="{{ $request->student->student_name }}">
                                                        <i class="bi me-1 text-primary"></i>{{ Str::limit($request->student->student_name, 70, '...') }}
                                                    </td>

                                                    <td class="fw-semibold wrap-text" title="{{ $request->project_title }}">
                                                        <i class="bi me-1 text-primary"></i>{{ Str::limit($request->project_title, 70, '...') }}
                                                    </td>

                                                    <td class="fw-semibold wrap-text" title="{{ $request->request_message }}">
                                                        <i class="bi me-1 text-primary"></i>{{ Str::limit($request->request_message, 70, '...') }}
                                                    </td>

                                                    <td class="fw-semibold text-center">
                                                        <i class="bi me-1 text-primary"></i>{{ $request->status }}
                                                    </td>

                                                    <td class="text-center">
                                                        <a href="{{ url('/update_student_request', $request->id) }}" class="btn btn-outline-primary btn-sm rounded-pill me-2">
                                                            <i class="bi bi-pencil-square"></i> Update
                                                        </a>
                                                        <a href="{{ url('/delete_request', $request->id) }}" class="btn btn-outline-danger btn-sm rounded-pill" onclick="return confirm('Are you sure to delete this session?')">
                                                            <i class="bi bi-trash"></i> Delete
                                                        </a>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td class="text-center text-muted" colspan="2">No sessions found.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        {{ $supervision_requests->links('pagination::bootstrap-5') }}
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

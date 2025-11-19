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

        <div class="col-12">
            <div class="card shadow-lg border-0 h-100 w-100" style="max-width: 100vw;">
                        <div class="card-header bg-danger text-white text-center">
                            <h3 class="h4 mb-0">Supervision Request</h3>
                        </div>
                        @if ($requests->isNotEmpty())
                            <div class="card-body table-responsive">
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
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>Supervisor Requested</th>
                                        <th>Project Title</th>
                                        <th>Message Sent</th>
                                        <th>Sent at</th>
                                        <th>Status</th>
                                        <th>Request</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requests as $request)
                                    <tr>
                                        <td class="wrap-text" title="{{ $request->supervisor->supervisor_name ?? '-' }}">
                                            {{ Str::limit($request->supervisor->supervisor_name, 70, '...') ?? '-' }}
                                        </td>
                                        <td class="wrap-text" title="{{ $request->project_title ?? '-' }}">
                                            {{ Str::limit($request->project_title, 70, '...') ?? '-' }}
                                        </td>
                                        <td class="wrap-text" title="{{ $request->request_message ?? '-' }}">
                                            {{ Str::limit($request->request_message, 70, '...') ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $request->request_date ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $request->status ?? '-' }}
                                        </td>
                                        <td>
                                            <a href="{{ url('/edit_supervision_request', $request->id) }}" class="btn btn-outline-warning btn-sm rounded-pill me-2">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                            {{-- <a href="{{ url('/delete_supervision_request', $request->id) }}" class="btn btn-outline-danger btn-sm rounded-pill me-2"
                                                onclick="return confirm('Are you sure to remove supervision request to {{ Str::limit($request->supervisor->supervisor_name, 70, '...') ?? '-' }}?')">
                                                <i class="bi bi-pencil-square"></i> Delete
                                            </a> --}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                You have not made a supervision requests.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

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

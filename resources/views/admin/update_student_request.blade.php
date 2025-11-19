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
                                <div class="card-header bg-primary text-white text-center">
                                    <h3 class="h4 mb-0">Update Student Request</h3>
                                </div>

                                <div class="card-body p-4">

                                    @if ($errors->any())
                                    <div class="alert alert-danger mb-4">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    <div class="mb-3 mt-4">
                                        <x-label for="supervisor_name" value="{{ __('Supervisor Requested') }}" />
                                        <x-input id="supervisor_name" type="text" name="supervisor_name" class="form-control"
                                            value="{{ old('supervisor_name', $request->supervisor->supervisor_name) }}" disabled/>

                                        <a class="btn btn-secondary mt-2" href="{{ url('change_request_supervisor', $request->id) }}">Change Supervisor</a>
                                    </div>

                                    <div class="mb-3">
                                        <x-label for="student_name" value="{{ __('Student Name') }}" />
                                        <x-input id="student_name" type="text" name="student_name" class="form-control"
                                            value="{{ old('student_name', $request->student->student_name) }}" disabled/>
                                    </div>

                                    <form method="POST" action="{{ url('/updated_student_request', $request->id) }}">
                                    @csrf

                                    <div class="mb-3">
                                        <x-label for="project_title" value="{{ __('Project Title') }}" />
                                        <x-input id="project_title" type="text" name="project_title" class="form-control"
                                            value="{{ old('project_title', $request->project_title) }}" required/>
                                    </div>

                                    <div class="mb-3">
                                        <x-label for="request_message" value="{{ __('Message') }}" />
                                        <x-input id="request_message" type="text" name="request_message" class="form-control"
                                            value="{{ old('request_message', $request->request_message) }}" required/>
                                    </div>

                                    <div class="mb-3">
                                        <x-label for="status" value="{{ __('Request Status') }}" />
                                        <select id="status" name="status" class="form-control">
                                            <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ $request->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="declined" {{ $request->status == 'declined' ? 'selected' : '' }}>Declined</option>
                                        </select>
                                    </div>

                                    <div class="d-grid mt-4">
                                        <x-button class="btn btn-primary btn-lg">
                                            {{ __('Update Student Request') }}
                                        </x-button>
                                    </div>

                                    </form>
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

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
                                    <h3 class="h4 mb-0">Create Supervision</h3>
                                </div>

                                <div class="card-body p-4">

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

                                    <div class="mb-3 mt-4">
                                        <x-label for="supervisor_name" value="{{ __('Supervisor Name') }}" />
                                        @php
                                            $selectedSupervisor = null;

                                            if(request()->has('supervisor_id')) {
                                                $selectedSupervisor = \App\Models\SupervisorProfile::find(request('supervisor_id'));
                                            }

                                        @endphp

                                        <x-input id="supervisor_name" type="text" name="supervisor_name" class="form-control"
                                            value="{{ $selectedSupervisor->supervisor_name ?? old('supervisor_name', $supervisorName->supervisor_name ?? 'Please Select a Supervisor') }}"
                                            disabled/>

                                        <a class="btn btn-secondary mt-2" href="{{ url('select_request_supervisor?return=' . urlencode(request()->fullUrl())) }}">
                                            Browse Supervisors
                                        </a>
                                    </div>

                                    <div class="mb-3">
                                        <x-label for="student_name" value="{{ __('Student Name') }}" />
                                        @php
                                            $selectedStudent = null;

                                            if(request()->has('student_id')) {
                                                $selectedStudent = \App\Models\StudentProfile::find(request('student_id'));
                                            }

                                        @endphp

                                        <x-input id="student_name" type="text" name="student_name" class="form-control"
                                            value="{{ $selectedStudent->student_name ?? old('student_name', $studentName->student_name ?? 'Please Select a Student') }}"
                                            disabled/>

                                        <a class="btn btn-secondary mt-2" href="{{ url('select_request_student?return=' . urlencode(request()->fullUrl())) }}">
                                            Browse Students
                                        </a>
                                    </div>

                                    <form method="POST" action="{{ url('/create_student_request') }}">
                                    @csrf

                                    @if($selectedSupervisor)
                                        <input type="hidden" id="supervisor_id" name="supervisor_id" value="{{ $selectedSupervisor->id }}">
                                    @endif

                                    @if($selectedStudent)
                                        <input type="hidden" id="student_id" name="student_id" value="{{ $selectedStudent->id }}">
                                    @endif

                                    <div class="mb-3">
                                        <x-label for="project_title" value="{{ __('Project Title') }}" />
                                        <x-input id="project_title" type="text" name="project_title" class="form-control"
                                            placeholder="optional"/>
                                    </div>

                                    <div class="mb-3">
                                        <x-label for="request_message" value="{{ __('Message') }}" />
                                        <x-input id="request_message" type="text" name="request_message" class="form-control"
                                            placeholder="optional"/>
                                    </div>

                                    <div class="mb-3">
                                        <x-label for="status" value="{{ __('Request Status') }}" />
                                        <select id="status" name="status" class="form-control">
                                            <option value="pending" selected>Pending</option>
                                            <option value="approved">Approved</option>
                                            <option value="declined">Declined</option>
                                        </select>
                                    </div>

                                    <div class="d-grid mt-4">
                                        <x-button class="btn btn-primary btn-lg">
                                            {{ __('Create Supervision') }}
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

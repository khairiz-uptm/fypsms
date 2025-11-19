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
            <div class="row justify-content-center">
              <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 mt-4 mb-4">
                  <div class="card-header bg-primary text-white text-center">
                    <h3 class="h4 mb-0">Profile</h3>
                  </div>
                  <div class="card-body">
                    @if ($user->student_profile)
                      <div class="d-flex flex-column align-items-center mb-4">
                        <img class="rounded-circle shadow mb-3" style="width: 140px; height: 140px; object-fit: cover; border: 4px solid #e9ecef;" src="{{ $user->student_profile->student_profile_picture ? asset('uploads/students/' . $user->student_profile->student_profile_picture) : asset('uploads/supervisors/default_profile.jpg') }}" alt="Profile Picture">
                        <h4 class="mb-1 mt-2">{{ $user->student_profile->student_name }}</h4>
                        <span class="text-muted">{{ $user->email }}</span>
                      </div>
                      <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item"><strong></strong></li>
                        <li class="list-group-item"><strong>Phone Number:</strong> {{ $user->student_profile->student_phone }}</li>
                        <li class="list-group-item"><strong>Student ID:</strong> {{ $user->userId }}</li>
                        <li class="list-group-item"><strong>Course:</strong> {{ $user->student_profile->student_course }}</li>
                        <li class="list-group-item"><strong>Current Semester:</strong> Semester {{ $user->student_profile->student_semester }}</li>
                        <li class="list-group-item"><strong>Current Session:</strong> {{ $user->student_profile->student_session }}</li>
                        <li class="list-group-item"><strong></strong></li>
                      </ul>
                      <div class="text-center">
                        <a href="{{ url('/student_edit_profile', $user->student_profile->id) }}" class="btn btn-primary px-4">Edit Profile</a>
                      </div>
                    @else

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

                      @if ($errors->any())
                        <div class="alert alert-danger">
                          <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                            @endforeach
                          </ul>
                        </div>
                      @endif
                      <form method="POST" action="{{ url('/student_create_profile', $user->id) }}" enctype="multipart/form-data" class="px-2 py-3">
                        @csrf
                        <div class="mb-3">
                          <x-label for="name" value="{{ __('Name') }}" />
                          <x-input id="student_name" class="form-control" type="text" name="student_name" :value="old('student_name')" required autofocus autocomplete="name" />
                        </div>
                        <div class="mb-3">
                          <x-label for="student_email" value="{{ __('Email') }}" />
                          <x-input id="student_email" class="form-control" type="text" name="student_email_display" :value="$user->email" disabled />
                        </div>
                        <div class="mb-3">
                          <x-label for="student_phone" value="{{ __('Phone Number') }}" />
                          <x-input id="student_phone" class="form-control" type="text" name="student_phone" :value="old('student_phone')" required autocomplete="name" />
                        </div>

                        <x-label for="student_course" value="{{ __('Course') }}" />
                            <select id="student_course" name="student_course" class="block mt-1 w-full">
                                <option value="FA001" selected>FA001</option>
                                <option value="BE101">BE101</option>
                                <option value="BE201">BE201</option>
                                <option value="BE202">BE202</option>
                                <option value="BE203">BE203</option>
                                <option value="BE301">BE301</option>
                            </select>

                        <div class="mb-3">
                        <x-label for="student_session" value="{{ __('Session') }}" />
                            <select id="student_session" name="student_session" class="block mt-1 w-full">
                                @foreach ($sessions as $session)
                                    <option value="{{ $session->session_name }}">{{ $session->session_name }}</option>
                                @endforeach (sessi)
                            </select>
                        </div>

                        <x-label for="student_semester" value="{{ __('Current Semester') }}" />
                            <select id="student_semester" name="student_semester" class="block mt-1 w-full">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                @endfor
                            </select>

                        <div class="mb-3">
                          <label>Upload Profile Picture</label>
                          <input type="file" name="student_profile_picture" class="form-control">
                        </div>
                        <div class="text-center">
                          <x-button class="btn btn-primary px-4">
                            {{ __('Create Profile') }}
                          </x-button>
                        </div>
                      </form>
                    @endif
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

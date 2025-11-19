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
          <div class="content-wrapper d-flex justify-content-center align-items-center" style="min-height: 80vh;">

            <div class="card shadow-lg border-0 w-100" style="max-width: 800px;">
              <div class="card-header bg-primary text-white text-center">
                <h3 class="h4 mb-0">Edit User</h3>
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

                <form method="POST" action="{{ url('/update_user', $user->id) }}">
                  @csrf

                  <div class="mb-3">
                    <x-label for="name" value="{{ __('Name') }}" />
                    <input id="name" type="text" name="name" class="form-control"
                           value="{{ old('name', $user->name) }}" required>
                  </div>

                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" class="form-control"
                           value="{{ old('email', $user->email) }}" required>
                  </div>

                  <div class="mb-3">
                    <label for="userId" class="form-label">College ID</label>
                    <input id="userId" type="text" name="userId" class="form-control"
                           value="{{ old('userId', $user->userId) }}" required>
                  </div>

                  <div class="mb-3">
                    <label for="role" class="form-label">User Type</label>
                    <select id="role" name="role" class="form-control">
                      <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Student</option>
                      <option value="lecturer" {{ $user->role == 'lecturer' ? 'selected' : '' }}>Lecturer</option>
                      <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                  </div>

                  <div class="d-grid mt-4">
                    <x-button class="btn btn-primary btn-lg">
                        {{ __('Update User') }}
                    </x-button>
                  </div>

                </form>
              </div>
            </div>

          </div>
        </div>
      </div>


    </div>
    @include('admin.footer')
  </body>
</html>

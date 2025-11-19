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
            <div class="row justify-content-center">
              <div class="col-md-8 col-lg-8">
                <div class="card shadow-lg border-0 mt-4 mb-4">

                  <!-- ✅ Follow same style as Request Form -->
                  <div class="card-header bg-danger text-white text-center">
                    <h3 class="h4 mb-0">Propose a Title</h3>
                  </div>

                  <!-- ✅ Match padding & layout of request form -->
                  <form action="{{ url('recommend_supervisors') }}" method="GET" class="px-5 py-3">

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

                    <div class="mb-3">
                      <x-label for="project_title" value="{{ __('Project Title') }}" />
                      <x-input id="project_title" class="form-control" type="text" name="project_title" :value="old('project_title')" placeholder="Enter your project title" />
                    </div>

                    <div class="text-center">
                      <x-button class="btn btn-primary px-4">
                        {{ __('Find Suitable Supervisors') }}
                      </x-button>
                    </div>

                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      @include('student.footer')
    </div>
  </body>
</html>

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
        <!-- partial:partials/_sidebar.html -->

        @include('student.sidebar')

        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row justify-content-center">
              <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 mt-4 mb-4">
                    <div class="card-header bg-danger text-white text-center">
                        <h3 class="h4 mb-0">Request Form</h3>
                    </div>
                      @if ($errors->any())
                        <div class="alert alert-danger">
                          <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                            @endforeach
                          </ul>
                        </div>
                      @endif
                      <form method="POST" action="{{ url('/request_supervision', $supervisor->id) }}" enctype="multipart/form-data" class="px-5 py-3">
                        @csrf
                        <div class="mb-3">
                          <x-label for="project_title" value="{{ __('Project Title') }}" />
                          <x-input id="project_title" class="form-control" type="text" name="project_title" value="{{ request('title') ?? old('project_title') }}" autofocus autocomplete="name" placeholder="optional"/>
                        </div>
                        <div class="mb-3">
                          <x-label for="request_message" value="{{ __('Description/Message') }}" />
                          <textarea id="request_message" class="form-control" type="text" name="request_message" :value="old('project_message')" autofocus autocomplete="name" placeholder="optional"></textarea>
                        </div>

                        <div class="text-center">
                          <x-button class="btn btn-primary px-4">
                            {{ __('Send Request') }}
                          </x-button>
                        </div>
                      </form>
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

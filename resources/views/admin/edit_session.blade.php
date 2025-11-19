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
        <!-- partial:partials/_sidebar.html -->
        @include('admin.sidebar')
        <div class="main-panel">
          <div class="content-wrapper">

            @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
                @endif

                <form method="POST" action="{{ url('/update_session', $session->id) }}" enctype="">
                    @csrf

                    <div>
                        <x-label for="session_name" value="{{ __('Name') }}" />
                        <x-input id="session_name" class="block mt-1 w-full" type="text"
                        name="session_name" :value="old('session_name')" required autofocus autocomplete="name"
                        value="{{$session->session_name}}"/>
                    </div>

                    <div>
                        <x-button class="btn btn-primary">
                            {{ __('Update Session') }}
                        </x-button>
                    </div>
                </form>

            </div>
          </div>
        </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->

    </div>
    @include('admin.footer')
  </body>
</html>

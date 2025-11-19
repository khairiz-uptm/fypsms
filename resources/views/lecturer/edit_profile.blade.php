<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="/public">
    @include('lecturer.css')
  </head>
  <body>
    <div class="container-scroller">
      @include('lecturer.header')
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->

        @include('lecturer.sidebar')

        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row justify-content-center">
              <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 mt-4 mb-4">
                  <div class="card-header bg-primary text-white text-center">
                    <h3 class="h4 mb-0">Edit Profile</h3>
                  </div>
                  <div class="card-body">
                    @if ($errors->any())
                      <div class="alert alert-danger">
                        <ul class="mb-0">
                          @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                          @endforeach
                        </ul>
                      </div>
                    @endif
                    <form id="editProfileForm" method="POST" action="{{ url('/update_profile', $user->id) }}" enctype="multipart/form-data">
                      @csrf
                      <div class="d-flex flex-column align-items-center mb-4">
                        <img class="rounded-circle shadow mb-3" style="width: 140px; height: 140px; object-fit: cover; border: 4px solid #e9ecef;" src="{{ $user->supervisor_profile_picture ? asset('uploads/supervisors/' . $user->supervisor_profile_picture) : asset('uploads/supervisors/default_profile.jpg') }}" alt="Profile Picture">
                        <div class="w-100">
                          <label class="form-label">Upload Profile Picture</label>
                          <input type="file" name="supervisor_profile_picture" class="form-control">
                        </div>
                      </div>
                      <div class="mb-3">
                        <x-label for="name" value="{{ __('Name') }}" />
                        <x-input id="supervisor_name" class="form-control" type="text" name="supervisor_name" :value="old('supervisor_name', $user->supervisor_name)" required autofocus autocomplete="name" />
                      </div>
                      <div class="mb-3">
                          <x-label for="email" value="{{ __('Email') }}" />
                          <x-input id="supervisor_name" class="form-control" type="text" name="supervisor_name" :value="old('supervisor_name', $trueUser->email)" disabled required autofocus autocomplete="name" />
                        </div>
                      <div class="mb-3">
                        <x-label for="supervisor_phone" value="{{ __('Phone Number') }}" />
                        <x-input id="supervisor_phone" class="form-control" type="text" name="supervisor_phone" :value="old('supervisor_phone', $user->supervisor_phone)" required autocomplete="name" />
                      </div>
                      <div class="mb-3">
                      <x-label for="supervisor_department" value="{{ __('Department') }}" />
                            <select id="supervisor_department" name="supervisor_department" class="block mt-1 w-full">
                                <option value="(FABA) FACULTY OF BUSINESS AND ACCOUNTANCY" {{ $user->supervisor_department == '(FABA) FACULTY OF BUSINESS AND ACCOUNTANCY' ? 'selected' : '' }}>(FABA) FACULTY OF BUSINESS AND ACCOUNTANCY</option>
                                <option value="(FCOM) FACULTY OF COMPUTING & MULTIMEDIA" {{ $user->supervisor_department == '(FCOM) FACULTY OF COMPUTING & MULTIMEDIA' ? 'selected' : '' }}>(FCOM) FACULTY OF COMPUTING & MULTIMEDIA</option>
                                <option value="(FESSH) FACULTY OF EDUCATION, SOCIAL SCIENCE AND HUMANITIES" {{ $user->supervisor_department == '(FESSH) FACULTY OF EDUCATION, SOCIAL SCIENCE AND HUMANITIES' ? 'selected' : '' }}>(FESSH) FACULTY OF EDUCATION, SOCIAL SCIENCE AND HUMANITIES</option>
                                <option value="(IPS) INSTITUTE OF PROFESSIONAL STUDIES" {{ $user->supervisor_department == '(IPS) INSTITUTE OF PROFESSIONAL STUDIES' ? 'selected' : '' }}>(IPS) INSTITUTE OF PROFESSIONAL STUDIES</option>
                                <option value="(IGS) INSTITUTE OF GRADUATE STUDIES" {{ $user->supervisor_department == '(IGS) INSTITUTE OF GRADUATE STUDIES' ? 'selected' : '' }}>(IGS) INSTITUTE OF GRADUATE STUDIES</option>
                                <option value="(CIGLS) CENTRE OF ISLAMIC, GENERAL, AND LANGUAGE STUDIES" {{ $user->supervisor_department == '(CIGLS) CENTRE OF ISLAMIC, GENERAL, AND LANGUAGE STUDIES' ? 'selected' : '' }}>(CIGLS) CENTRE OF ISLAMIC, GENERAL, AND LANGUAGE STUDIES</option>
                            </select>
                        </div>
                      <div class="mb-3">
                        <x-label for="supervisor_expertise" value="{{ __('Expertise') }}" />
                        <input type="hidden" id="supervisor_expertise_input" name="supervisor_expertise" value="{{ old('supervisor_expertise', $user->supervisor_expertise) }}">

                        <select id="expertise_select" class="form-control" multiple size="5" aria-label="Select expertise tags">
                          @if(!empty($expertiseTags) && is_array($expertiseTags))
                            @foreach($expertiseTags as $tag)
                              <option value="{{ $tag }}">{{ $tag }}</option>
                            @endforeach
                          @else
                            @if(!empty($user->supervisor_expertise))
                              @foreach(explode(',', $user->supervisor_expertise) as $t)
                                <option value="{{ trim($t) }}">{{ trim($t) }}</option>
                              @endforeach
                            @endif
                          @endif
                        </select>

                        <small class="form-text text-muted">Select one or more expertise tags. Selected tags will be saved as a comma-separated list.</small>
                      </div>
                      <div class="text-center">
                        <x-button class="btn btn-primary px-4">
                          {{ __('Update Profile') }}
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
    @include('lecturer.footer')

    <!-- Select2 assets (loaded after footer so jQuery is available) -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
      (function(){
        var form = document.getElementById('editProfileForm');
        var select = $('#expertise_select');
        var hidden = document.getElementById('supervisor_expertise_input');
        if(!form || !select.length || !hidden) return;

        select.select2({
          tags: true,
          tokenSeparators: [','],
          width: '100%',
          closeOnSelect: false,
          placeholder: 'Select or add expertise',
          allowClear: true,
          createTag: function (params) {
            var term = $.trim(params.term);
            if (term === '') return null;
            return { id: term, text: term };
          }
        });

        var existing = hidden.value ? hidden.value.split(',').map(function(s){ return s.trim(); }) : [];
        existing.forEach(function(val){
          if(val === '') return;
          if(select.find("option[value='" + val + "']").length === 0) {
            var newOption = new Option(val, val, true, true);
            select.append(newOption).trigger('change');
          } else {
            select.find("option[value='"+val+"']").prop('selected', true);
          }
        });
        select.trigger('change');

        form.addEventListener('submit', function(e){
          var chosen = select.val() || [];
          hidden.value = chosen.join(', ');
        });
      })();
    </script>
  </body>
</html>

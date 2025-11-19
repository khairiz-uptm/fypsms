<!DOCTYPE html>
<html lang="en">
  <head>
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
            <div class="row justify-content-center">
              <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 mt-4 mb-4">
                  <div class="card-header bg-primary text-white text-center">
                    <h3 class="h4 mb-0">Profile</h3>
                  </div>
                  <div class="card-body">
                    @if ($user->profile)
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
                      <div class="d-flex flex-column align-items-center mb-4">
                        <img class="rounded-circle shadow mb-3" style="width: 140px; height: 140px; object-fit: cover; border: 4px solid #e9ecef;" src="{{ $user->profile->supervisor_profile_picture ? asset('uploads/supervisors/' . $user->profile->supervisor_profile_picture) : asset('uploads/supervisors/default_profile.jpg') }}" alt="Profile Picture">
                        <h4 class="mb-1 mt-2">{{ $user->profile->supervisor_name }}</h4>
                        <span class="text-muted">{{ $user->email }}</span>
                      </div>
                      <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item"><strong></strong></li>
                        <li class="list-group-item"><strong>Phone Number:</strong> {{ $user->profile->supervisor_phone }}</li>
                        <li class="list-group-item"><strong>Staff ID:</strong> {{ $user->userId }}</li>
                        <li class="list-group-item"><strong>Department:</strong> {{ $user->profile->supervisor_department }}</li>
                        <li class="list-group-item"><strong>Expertise:</strong> {{ $user->profile->supervisor_expertise }}</li>
                        <li class="list-group-item"><strong></strong></li>
                      </ul>
                      <div class="text-center">
                        <a href="{{ url('/edit_profile', $user->profile->id) }}" class="btn btn-primary px-4">Edit Profile</a>
                      </div>
                    @else
                      @if ($errors->any())
                        <div class="alert alert-danger">
                          <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                            @endforeach
                          </ul>
                        </div>
                      @endif
                      <form method="POST" action="{{ url('/create_profile', $user->id) }}" enctype="multipart/form-data" class="px-2 py-3">
                        @csrf
                        <div class="mb-3">
                          <x-label for="name" value="{{ __('Name') }}" />
                          <x-input id="supervisor_name" class="form-control" type="text" name="supervisor_name" :value="old('supervisor_name')" required autofocus autocomplete="name" />
                        </div>
                        <div class="mb-3">
                          <x-label for="supervisor_email" value="{{ __('Email') }}" />
                          <x-input id="supervisor_email" class="form-control" type="text" name="supervisor_email_display" :value="$user->email" disabled />
                        </div>
                        <div class="mb-3">
                          <x-label for="supervisor_phone" value="{{ __('Phone Number') }}" />
                          <x-input id="supervisor_phone" class="form-control" type="text" name="supervisor_phone" :value="old('supervisor_phone')" required autocomplete="name" />
                        </div>
                        <div class="mb-3">
                            <x-label for="supervisor_department" value="{{ __('Department') }}" />
                                <select id="supervisor_department" name="supervisor_department" class="block mt-1 w-full">
                                    <option value="(FABA) FACULTY OF BUSINESS AND ACCOUNTANCY" selected>(FABA) FACULTY OF BUSINESS AND ACCOUNTANCY</option>
                                    <option value="(FCOM) FACULTY OF COMPUTING & MULTIMEDIA">(FCOM) FACULTY OF COMPUTING & MULTIMEDIA</option>
                                    <option value="(FESSH) FACULTY OF EDUCATION, SOCIAL SCIENCE AND HUMANITIES">(FESSH) FACULTY OF EDUCATION, SOCIAL SCIENCE AND HUMANITIES</option>
                                    <option value="(IPS) INSTITUTE OF PROFESSIONAL STUDIES">(IPS) INSTITUTE OF PROFESSIONAL STUDIES</option>
                                    <option value="(IGS) INSTITUTE OF GRADUATE STUDIES">(IGS) INSTITUTE OF GRADUATE STUDIES</option>
                                    <option value="(CIGLS) CENTRE OF ISLAMIC, GENERAL, AND LANGUAGE STUDIES">(CIGLS) CENTRE OF ISLAMIC, GENERAL, AND LANGUAGE STUDIES</option>
                                </select>
                        </div>
                        <div class="mb-3">
                            <x-label for="supervisor_expertise" value="{{ __('Expertise') }}" />
                            <!-- Hidden input keeps the same field name expected by the backend. JS will populate this with a comma-separated list. -->
                            <input type="hidden" id="supervisor_expertise_input" name="supervisor_expertise" value="{{ old('supervisor_expertise', $user->supervisor_expertise) }}">

                            <!-- Multi-select to pick one or more existing expertise tags. Controller should pass $expertiseTags (array of strings). -->
                            <select id="expertise_select" class="form-control" multiple size="5" aria-label="Select expertise tags">
                            @if(!empty($expertiseTags) && is_array($expertiseTags))
                                @foreach($expertiseTags as $tag)
                                <option value="{{ $tag }}">{{ $tag }}</option>
                                @endforeach
                            @else
                                <!-- Fallback: show the current expertise if no tag list provided -->
                                @if(!empty($user->supervisor_expertise))
                                @foreach(explode(',', $user->supervisor_expertise) as $t)
                                    <option value="{{ trim($t) }}">{{ trim($t) }}</option>
                                @endforeach
                                @endif
                            @endif
                            </select>

                            <small class="form-text text-muted">Select one or more expertise tags. Selected tags will be saved as a comma-separated list.</small>
                            <small class="form-text text-muted">Custom tags are enabled. Type and selected the tag.</small>
                        </div>
                        <div class="mb-3">
                          <label>Upload Profile Picture</label>
                          <input type="file" name="supervisor_profile_picture" class="form-control">
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
    @include('admin.footer')

    <!-- Select2 CSS/JS (CDN) for better tag selection UX (loaded after footer to ensure jQuery is available) -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
      (function(){
        var select = $('#expertise_select');
        var hidden = document.getElementById('supervisor_expertise_input');
        if(!select.length || !hidden) return;

        var form = select.closest('form')[0] || document.getElementById('editProfileForm') || document.getElementById('createProfileForm');

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

        if (form) {
          form.addEventListener('submit', function(e){
            var chosen = select.val() || [];
            hidden.value = chosen.join(', ');
          });
        }
      })();
    </script>
  </body>
</html>

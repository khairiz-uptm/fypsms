<nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="{{url('student_profile')}}" class="nav-link">
                <div class="profile-image">
                  @if (auth()->user()->student_profile && auth()->user()->student_profile->student_profile_picture)
                    <img class="img-xs rounded-circle" style="width: 48px; height: 48px; object-fit: cover;" src="uploads/students/{{ auth()->user()->student_profile->student_profile_picture }}" alt="profile image">
                  @else
                    <img class="img-xs rounded-circle" style="width: 48px; height: 48px; object-fit: cover;" src="uploads/default_profile.jpg" alt="profile image">
                  @endif
                    <div class="dot-indicator bg-success"></div>
                </div>
                <div class="text-wrapper">
                        <p class="profile-name text-truncate" style="max-width: 140px; overflow: hidden; white-space: nowrap;">{{ auth()->user()->student_profile ? auth()->user()->student_profile->student_name : auth()->user()->name }}</p>
                    @if (auth()->user()->student_profile && auth()->user()->student_profile->student_course)
                        <p class="designation">Student of {{auth()->user()->student_profile->student_course }}</p>
                    @else
                        <p class="designation">Please set Profile</p>
                    @endif
                </div>
              </a>
            </li>
            <li class="nav-item nav-category">Navigation Menu</li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('home')}}">
                <i class="menu-icon typcn typcn-document-text"></i>
                <span class="menu-title">Home</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{url('student_profile')}}">
                <i class="menu-icon typcn typcn-document-text"></i>
                <span class="menu-title">Profile</span>
              </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                    <i class="menu-icon typcn typcn-document-add"></i>
                    <span class="menu-title">Supervision</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="auth">
                    <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/find_supervisor')}}"> Find Supervisor </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/propose_title') }}"> Recommend Supervisor </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/view_supervision_request') }}"> Request Status</a>
                    </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                @if (auth()->user()->student_profile && auth()->user()->student_profile->user_id)
                    <a class="nav-link" href="{{ url('/view_my_supervisor', auth()->user()->student_profile->user_id) }}">
                        <i class="menu-icon typcn typcn-document-text"></i>
                        <span class="menu-title">My Supervisor</span>
                    </a>
                @else
                    <a class="nav-link" href="{{ url('/find_supervisor') }}">
                        <i class="menu-icon typcn typcn-document-text"></i>
                        <span class="menu-title">My Supervisor</span>
                    </a>
                @endif

            </li>

          </ul>
        </nav>
        <!-- partial -->

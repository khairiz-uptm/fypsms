<nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="{{url('profile')}}" class="nav-link">
                <div class="profile-image">
                  @if (auth()->user()->profile && auth()->user()->profile->supervisor_profile_picture)
                    <img class="img-xs rounded-circle" style="width: 48px; height: 48px; object-fit: cover;" src="uploads/supervisors/{{ auth()->user()->profile->supervisor_profile_picture }}" alt="profile image">
                  @else
                    <img class="img-xs rounded-circle" style="width: 48px; height: 48px; object-fit: cover;" src="uploads/default_profile.jpg" alt="profile image">
                  @endif
                    <div class="dot-indicator bg-success"></div>
                </div>
                <div class="text-wrapper">
                        <p class="profile-name text-truncate" style="max-width: 140px; overflow: hidden; white-space: nowrap;" title="{{ auth()->user()->profile ? auth()->user()->profile->supervisor_name : auth()->user()->name }}">{{ auth()->user()->profile ? auth()->user()->profile->supervisor_name : auth()->user()->name }}</p>
                    @if(auth()->user()->role)
                        <p class="designation">Coordinator</p>
                    @else
                        <p class="designation">Unauthenticated</p>
                    @endif
                </div>
              </a>
            </li>
            <li class="nav-item nav-category">Supervisor Navigation</li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('home')}}">
                <i class="menu-icon typcn typcn-document-text"></i>
                <span class="menu-title">Home</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{url('profile')}}">
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
                            <a class="nav-link" href="{{url('view_request', auth()->user()->id)}}"> Incoming Request </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('view_supervisee', auth()->user()->id)}}"> Supervisee List </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item nav-category pt-4">Coordinator Navigation</li>

            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#supervision" aria-expanded="false" aria-controls="ui-basic">
                <i class="menu-icon typcn typcn-coffee"></i>
                <span class="menu-title">Manage Supervision</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="supervision">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('manage_request') }}">Manage Requests</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{url('create_supervision')}}">Create Supervision</a>
                  </li>
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="menu-icon typcn typcn-coffee"></i>
                <span class="menu-title">Create Users</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="{{url('create_student')}}">Student</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{url('create_lecturer')}}">Lecturer</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{url('create_admin')}}">Coordinator</a>
                  </li>
                </ul>
              </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#users" aria-expanded="false" aria-controls="auth">
                    <i class="menu-icon typcn typcn-document-add"></i>
                    <span class="menu-title">Manage Users</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="users">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('view_students') }}"> Students </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('view_lecturers') }}"> Lecturers </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('view_admins') }}"> Coordinator </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{ url('student_session') }}">
                <i class="menu-icon typcn typcn-document-text"></i>
                <span class="menu-title">Student Session</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{ url('manage_expertise') }}">
                <i class="menu-icon typcn typcn-document-text"></i>
                <span class="menu-title">Manage Expertise</span>
              </a>
            </li>
          </ul>
        </nav>
        <!-- partial -->

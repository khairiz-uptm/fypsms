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
                        <p class="designation">Supervisor</p>
                    @else
                        <p class="designation">Guest</p>
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

          </ul>
        </nav>
        <!-- partial -->

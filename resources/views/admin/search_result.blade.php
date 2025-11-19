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
            <div class="row justify-content-center mb-2">
                        <div class="col-12">
                            <div class="card border-0 shadow rounded-4 h-100 bg-white">
                                <div class="card-header bg-info text-white text-center rounded-top-4 py-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="h4 mb-0">
                                            <i class="h4 mb-0">View Users</i>
                                        </h3>

                                        <form action="{{ url('search_users') }}" method="GET" class="form-inline my-2 my-lg-0">
                                            <input class="form-control mr-sm-2" type="search" name="query" placeholder="Search for user" aria-label="Search" value="{{ isset($query) ? $query : request('query') }}">
                                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                                        </form>
                                    </div>
                                </div>

                                    <div class="card-body p-4">
                                        <div class="table-responsive">
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
                                        <table class="table table-hover align-middle mb-0">
                                            <thead>
                                                <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">College ID</th>
                                                <th scope="col">Role</th>
                                                <th scope="col">Update</th>
                                                <th scope="col">Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($results))
                                                    @forelse ($results as $user)
                                                        <tr>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->userId }}</td>
                                                        <td>{{ $user->role }}</td>
                                                        <td><a href="{{ url('/edit_user', $user->id) }}" class="btn btn-primary">Update</a></td>
                                                        <td><a href="{{ url('/delete_user', $user->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure to delete this user?')">Delete</a></td>
                                                        </tr>
                                                    @empty
                                                        <tr><td colspan="6">No users found.</td></tr>
                                                    @endforelse
                                                @else
                                                    <tr><td colspan="6">No search query provided.</td></tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
          </div>
        </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          @include('admin.footer')
    </div>
  </body>
</html>

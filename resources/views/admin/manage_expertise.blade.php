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
                <div class="content-wrapper">

                    <div class="row justify-content-center mt-2 mb-2">

                        <div class="col-lg-8 col-md-10 mb-4">
                            <div class="card border-0 shadow rounded-4 h-100 bg-white">
                                <div class="card-header bg-primary text-white text-center rounded-top-4 py-4">
                                    <h3 class="h4 mb-0">
                                        <i class="h4 mb-0">Create New Expertise Tag</i>
                                    </h3>
                                </div>
                                <div class="card-body p-4">
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
                                    <form method="POST" action="{{ url('add_expertise') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <x-label for="expertise_tag" value="{{ __('Expertise Name') }}" />
                                            <x-input id="expertise_tag" class="form-control form-control-lg rounded-pill" type="text" name="expertise_tag" :value="old('expertise_tag')" required autofocus autocomplete="name" placeholder="e.g. Philosophy" />
                                        </div>
                                        <div class="d-grid mt-4">
                                            <x-button class="btn btn-primary btn-lg rounded-pill">
                                                <i class="bi bi-plus-circle me-2"></i>{{ __('Create Tag') }}
                                            </x-button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center mb-2">
                        <div class="col-lg-8 col-md-10">
                            <div class="card border-0 shadow rounded-4 h-100 bg-white">
                                <div class="card-header bg-info text-white text-center rounded-top-4 py-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="h4 mb-0">
                                            <i class="h4 mb-0">Existing Expertise Tag</i>
                                        </h3>

                                        <form action="{{ url('/search_expertise') }}" method="GET" class="d-flex align-items-center gap-2" style="max-width: 400px;">
                                            <input class="form-control rounded-pill px-3 py-2" style="font-size: 1rem;" type="search" name="query" placeholder="Search..." aria-label="Search" value="{{ $query ?? '' }}">
                                            <button class="btn btn-primary rounded-pill px-4 py-2" style="font-size: 1rem; height: 42px;" type="submit">Search</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="">Expertise Name</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($expertiseTags as $expertise)
                                                <tr>
                                                    <td class="fw-semibold">
                                                        <i class="bi me-1 text-primary"></i>{{ Str::limit($expertise->expertise_tag, 50, '...') }}
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ url('/delete_expertise', $expertise->id) }}" class="btn btn-outline-danger btn-sm rounded-pill" onclick="return confirm('Are you sure to delete this session?')">
                                                            <i class="bi bi-trash"></i> Delete
                                                        </a>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td class="text-center text-muted" colspan="2">No Expertise found.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        {{ $expertiseTags->links('pagination::bootstrap-5') }}
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

    </div>
    @include('admin.footer')
  </body>
</html>

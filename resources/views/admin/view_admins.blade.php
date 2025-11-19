<!DOCTYPE html>
<html lang="en">
  <head>
    @include('admin.css')

    <style>

        #users-table td,
        #users-table th {
            max-width: 180px;         /* adjust as needed */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .truncate-text {
            max-width: 180px;      /* You can adjust this */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

    </style>

  </head>
  <body>
    <div class="container-scroller">
      @include('admin.header')
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        @include('admin.sidebar')
        <div class="main-panel">
            <div class="content-wrapper">

                <div class="card border-0 shadow rounded-4 h-100 bg-white mt-4">
                    <div class="card-header bg-primary text-white text-center rounded-top-4 py-4">
                        <h3 class="h4 mb-0">
                            <i class="bi bi-people me-2"></i> View Coordinators
                        </h3>
                    </div>
                    <div class="card-body p-4">
                        <div class="datatable-container">
                            <div class="table-scroll table-responsive">
                                <table id="users-table" class="table table-hover align-middle mb-0">
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

                                    <thead class="table-light">
                                        <tr>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Staff ID</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="content-wrapper"></div>

          </div>
        </div>

    </div>
    @include('admin.footer')
  </body>

    <script>
        $(document).ready(function () {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                pageLength: 5,
                ajax: "{{ url('view_admins') }}",
                columns: [
                    {data: 'name', name: 'name', className: 'truncate-text'},
                    {data: 'email', name: 'email', className: 'truncate-text'},
                    {data: 'userId', name: 'userId'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                dom:
                    "<'row mb-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "tr" +
                    "<'row mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                responsive: true
            });

            $(document).ready(function(){
                $('[data-bs-toggle="tooltip"]').tooltip();
            });

            // Show full value on hover
            $('#users-table').on('mouseenter', 'td.truncate-text', function () {
                const fullText = $(this).text();
                $(this).attr('title', fullText);
            });


        });
    </script>

</html>

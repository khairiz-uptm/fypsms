<!DOCTYPE html>
<html>
<head>
    <title>Student Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 30px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header img {
            width: 80px;
            height: auto;
            margin-bottom: 10px;
        }

        h1, h2, h3 {
            margin: 0;
        }

        h2 {
            margin-top: 10px;
            font-size: 18px;
        }

        .lecturer-info {
            margin-bottom: 20px;
            padding: 10px;
            background: #f8f9fa;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .lecturer-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .lecturer-info th {
            text-align: left;
            width: 25%;
            padding: 4px;
        }

        .lecturer-info td {
            padding: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #f0f0f0;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>

    <div class="header">
        {{-- Optional logo --}}
        <img src="{{ public_path('assets/images/fessh-logo-login.png') }}" alt="University Logo">
        <h1>FESSH FINAL YEAR PROJECT SUPERVISION</h1>
        <h2>Supervisor Supervisee Report</h2>
    </div>

    <div class="lecturer-info">
        <table>
            <tr>
                <th>Student Name:</th>
                <td> {{ $student->student_name }}</td>
            </tr>
            <tr>
                <th>Email:</th>
                <td> {{ $student->student_profile->email }}</td>
            </tr>

            <tr>
                <th>Course:</th>
                <td> {{ $student->student_course ?? 'N/A' }}</td>
            </tr>

            <tr>
                <th>Session:</th>
                <td> {{ $student->student_session ?? 'N/A' }}</td>
            </tr>

            <tr>
                <th>Generated on:</th>
                <td> {{ now()->format('d M Y, h:i A') }}</td>
            </tr>

            <tr>
                <th>Project Title:</th>
                <td> {{ $approvedProject->project_title ?? 'N/A' }}</td>
            </tr>

            <tr>
                <th>Project Description:</th>
                <td> {{ $approvedProject->request_message ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <h3>Student's Supervisor</h3>

    <table>
        <thead>
            <tr>
                <th>Lecturer Name</th>
                <th>Staff ID</th>
                <th>Email</th>
                <th>Department</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($approvedSupervisors as $supervisor)
                <tr>
                    <td>{{ $supervisor->supervisor_name }}</td>
                    <td>{{ $supervisor->profile->userId }}</td>
                    <td>{{ $supervisor->profile->email ?? 'N/A' }}</td>
                    <td>{{ $supervisor->supervisor_department ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center;">No supervisor found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h3 style="padding-top: 20px">Ongoing/Declined Request by Lecturers</h3>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Lecturer Name</th>
                <th>Staff ID</th>
                <th>Email</th>
                <th>Department</th>
                {{-- <th>Request</th> --}}
            </tr>
        </thead>
        <tbody>
            @forelse ($supervisors as $index => $supervisor)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $supervisor->supervisor_name }}</td>
                    <td>{{ $supervisor->profile->userId }}</td>
                    <td>{{ $supervisor->profile->email ?? 'N/A' }}</td>
                    <td>{{ $supervisor->supervisor_department ?? 'N/A' }}</td>
                    {{-- <td>{{ $supervisor->supervisee_request->status ?? 'N/A' }}</td> --}}
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;">No ongoing/declined request.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Generated by FESSH Final Year Project Supervision Management System | Confidential Report</p>
    </div>

</body>
</html>

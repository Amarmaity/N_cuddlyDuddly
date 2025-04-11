@extends('layouts.app')

@section('title', 'Super Admin Dashboard')
@section('breadcrumb', 'Super view')
@section('page-title', 'Super Admin Dashboard')

@section('content')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <table id="employeeDetails" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Designation</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                @if($employee->status == 1)  
                    <tr>
                        <td>{{ $employee->employee_id }}</td>
                        <td>{{ $employee->fname }} {{ $employee->lname }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->designation }}</td>
                        <td>
                            <button onclick="viewEmployeeDetails('{{ $employee->employee_id }}')">View Details</button>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</body>

<script>
    $(document).ready(function () {
        $('#employeeDetails').DataTable();

    });

    function viewEmployeeDetails(empId) {
        window.location.href = "/employee/details/" + empId;
    }
</script>

@endsection

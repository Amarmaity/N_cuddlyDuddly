@extends('layouts.app')

@section('title', 'Apprisal Dashboard')
@section('breadcrumb', 'User Listing')
@section('page-title', 'Apprisal-Section')

@section('content')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <table id="userTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Employee ID</th>
                <th>Designation</th>
                <th>Salary</th>
                <th>Mobile Number</th>
                <th>Email</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr data-status="{{ $user->status ? '1' : '2' }}">
                    <td>{{ $user->fname }} {{ $user->lname }}</td>
                    <td>{{ $user->employee_id }}</td>
                    <td>{{ $user->designation }}</td>
                    <td>{{ $user->salary }}</td>
                    <td>{{ $user->mobno }}</td>
                    <td>{{ $user->email }}</td>
                    <td id="status-{{ $user->employee_id }}">{{ $user->status ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <button class="toggle-btn" data-user-id="{{ $user->employee_id }}"
                            style="background-color: {{ $user->status ? 'red' : 'green' }}; color: white;">
                            {{ $user->status ? 'Deactivate' : 'Activate' }}
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

<script>
    $(document).ready(function () {
        $.fn.dataTable.ext.order['status-order'] = function (settings, col) {
            return this.api().column(col, { order: 'index' }).nodes().map(function (td, i) {
                return $(td).closest('tr').attr('data-status');
            });
        };

        let table = $('#userTable').DataTable({
            columnDefs: [
                { targets: 6, orderDataType: "status-order" } // Apply custom sorting on the status column
            ],
            order: [[6, 'asc']] // Ensure inactive users appear at the bottom
        });
    });

    $(document).on("click", ".toggle-btn", function () {
        let userId = $(this).data("user-id");
        let button = $(this);
        
        $.ajax({
            url: `/toggle-status/${userId}`,
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function (response) {
                if (response.success) {
                    let statusElement = $(`#status-${userId}`);
                    let row = button.closest('tr');
                    
                    if (response.new_status) {
                        statusElement.text("Active");
                        button.text("Deactivate").css("background-color", "red");
                        row.attr("data-status", "1"); // Mark as active
                    } else {
                        statusElement.text("Inactive");
                        button.text("Activate").css("background-color", "green");
                        row.attr("data-status", "2"); // Mark as inactive
                    }

                    // Redraw DataTable to apply sorting
                    $('#userTable').DataTable().order([6, 'asc']).draw();
                } else {
                    alert("Failed to update status: " + response.error);
                }
            },
            error: function () {
                alert("Error toggling status");
            }
        });
    });
</script>

@endsection

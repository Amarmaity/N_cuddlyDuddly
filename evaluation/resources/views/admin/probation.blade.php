@extends('layouts.app')

@section('title', 'Probation Period')

@section('breadcrumb', 'Probation Period')

@section('page-title', 'Probation Period')

@section('content')

    <head>
    </head>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 5px 10px;
            margin: 2px;
            border: none;
            cursor: pointer;
        }

        .btn-toggle {
            background-color: #4CAF50;
            color: white;
        }

        .btn-calendar {
            background-color: #FF9800;
            color: white;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .status-text {
            font-weight: bold;
        }

        .calendar-container {
            display: none;
        }

        /* Custom Search Box Styles */
        #searchInput {
            width: 250px;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin: 20px 0;
        }

        /* Center the search box */
        .search-container {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Center the pagination */
        .pagination-container {
            text-align: center;
            margin-top: 20px;
        }
    </style>

    <h2>Probation Employee Table</h2>
    <table id="employeeTable" class="display">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Employee ID</th>
                <th>Designation</th>
                <th>Salary</th>
                <th>Email</th>
                <th>Status</th> <!-- Ensure this column is present -->
                <th>Probation Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user as $users)
                <tr>
                    <td>{{$users->fname}} {{$users->lname}}</td>
                    <td>{{$users->employee_id}}</td>
                    <td>{{$users->designation}}</td>
                    <td>{{$users->salary}}</td>
                    <td>{{$users->email}}</td>

                    <!-- Display the status (Initially show '--' if no status is set) -->
                    <td><span class="status-text" id="status{{$users->employee_id}}">
                            {{$users->employee_status ?? '--'}}</span></td>

                    <!-- Display the probation date -->
                    <td><span class="probation-date-text" id="probationDate{{$users->employee_id}}">
                            {{$users->probation_date ?? 'Not Set'}}</span></td>

                    <td>
                        <!-- Use dynamic employee ID for each row -->
                        <button class="btn btn-toggle" onclick="toggleStatus('{{ $users->employee_id }}')">Update</button>
                        <button class="btn btn-calendar" onclick="showCalendar('{{ $users->employee_id }}')">Set Probation
                            Date</button>
                        <div id="calendar{{$users->employee_id}}" class="calendar-container">
                            <input type="date" id="probationDateInput{{$users->employee_id}}">
                            <button onclick="setProbationDate('{{ $users->employee_id }}')">Set Date</button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize the DataTable
            $('#employeeTable').DataTable({
                "paging": true,           // Enable pagination
                "searching": true,        // Enable searching
                "ordering": true,         // Enable sorting
                "info": true,             // Show information like total records
                "lengthChange": false,    // Hide the number of rows per page option
                "pageLength": 5          // Number of records per page
            });
        });

        window.toggleStatus = function (employeeId) {
            var statusText = document.getElementById("status" + employeeId);

            var newStatus = statusText.innerText === "Employee" ? "Probation Period" : "Employee";
            statusText.innerText = newStatus;

            $.ajax({
                url: '/employee/' + employeeId + '/status', 
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',  
                    status: newStatus              
                },
                success: function (response) {
                    alert(response.message); 
                },
                error: function (xhr) {
                    alert('Error updating status: ' + xhr.responseText); 
                }
            });
        }


        // Function to show the calendar input for setting probation date
        window.showCalendar = function (employeeId) {
            var calendarContainer = document.getElementById("calendar" + employeeId);
            calendarContainer.style.display = "block";
        }

        // Function to set the probation date
        window.setProbationDate = function (employeeId) {
            var probationDate = document.getElementById("probationDateInput" + employeeId).value;
            if (probationDate) {
                // Send the probation date to the server
                $.ajax({
                    url: '/employee/' + employeeId + '/probation-date', // Endpoint for setting the probation date
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',  // CSRF token for security
                        probation_date: probationDate
                    },
                    success: function (response) {
                        alert(response.message);
                        document.getElementById("calendar" + employeeId).style.display = "none";  // Hide the calendar input
                    },
                    error: function (xhr) {
                        alert('Error setting probation date: ' + xhr.responseText);
                    }
                });
            } else {
                alert("Please select a date.");
            }
        }


        







    </script>

@endsection
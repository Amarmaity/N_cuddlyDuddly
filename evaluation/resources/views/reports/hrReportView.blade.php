@extends('layouts.app')

@section('title', 'Hr Review Dashboard')
@section('breadcrumb', 'Hr Review List')
@section('page-title', 'Hr-Review-Section')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Review Table</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Review Table</title>

    <!-- Include CSS for DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>

    <style>
        table {
            width: 100%;
            max-width: 1500px; /* Set the maximum width */
            border-collapse: collapse;
            margin: 0 auto; /* This will center the table horizontally */
        }
    
        table, th, td {
            border: 1px solid black;
        }
    
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
    
</head>
<body>

    <h2>Employee Review Table</h2>

    <!-- Table where data will be displayed -->
    <table id="employeeReviewTable">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Employee Id</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Example data, replace it with dynamic data from PHP -->
            @foreach($superAddUser as $user)
                @php
                    // Find corresponding review for this user
                    $review = $hrReviewTable->firstWhere('emp_id', $user->employee_id);
                @endphp
                @if($review) <!-- Only display if there is a review for the user -->
                    <tr>
                        <td>{{ $user->fname }} {{ $user->lname }}</td>
                        <td>{{ $user->employee_id }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                             <a href="{{ route('user-hr-details', $user->employee_id) }}" class="btn btn-primary">View Details</a>
                             <a href="{{route('user-report-view-evaluation', $user->employee_id)}}"class="btn btn-primary">View Evaluation</a>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <!-- Initialize DataTables with search functionality -->
    <script>
        $(document).ready(function() {
            $('#employeeReviewTable').DataTable({
                "paging": true,  
                "searching": true,
                "ordering": true, 
                "info": true,  
                "columnDefs": [
                    { "targets": [0, 1, 2], "searchable": true }  // Enable search on specific columns (e.g., Name, ID, Email)
                ]
            });
        });
    </script>

</body>
</html>

</body>
</html>




@endsection
@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('breadcrumb', 'Admin Review List')
@section('page-title', 'Admin-Review-Section')

@section('content')

    {{-- {{dd($superAddUser, $adminReviewTable)}} --}}
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
        </head>

            <style>
                table {
                    width: 100%;
                    max-width: 1606px;
                    /* Set the maximum width */
                    border-collapse: collapse;
                    margin: 0 auto;
                    /* This will center the table horizontally */
                }

                table,
                th,
                td {
                    border: 1px solid black;
                }

                th,
                td {
                    padding: 10px;
                    text-align: left;
                }
            </style>

        </head>

        <body>
            <h2>Employee Review Table</h2>

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
                    @foreach($superAddUser as $user)
                        <tr>
                            <td>{{ $user->fname }} {{$user->lname}}</td>
                            <td>{{ $user->employee_id }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <a href="{{ route('user-admin-details', $user->employee_id) }}" class="btn btn-primary">View Details</a>
                             <a href="{{route('user-report-view-evaluation', $user->employee_id)}}"class="btn btn-primary">View Evaluation</a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Include CSS for DataTables -->
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">

            <!-- Include jQuery -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <!-- Include DataTables JS -->
            <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>



            <script>
                $(document).ready(function () {
                    $('#employeeReviewTable').DataTable({
                        "paging": true,
                        "searching": true,
                        "ordering": true,
                        "info": true
                    });
                });
            </script>
        </body>

@endsection
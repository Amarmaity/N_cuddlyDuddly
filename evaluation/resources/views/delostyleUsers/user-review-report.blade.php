@extends('layouts.app')

@section('title', 'User Review Report')

@section('breadcrumb', "User Review Report / Employee $emp_id")

@section('page-title', 'User Review Report')

@section('content')
    <div class="container">
        <h3>User Review Report for Employee ID: {{ $emp_id }}</h3>

        <!-- Buttons for each report -->
        <div class="row">
            <!-- Evaluation Report Button -->
            @if ($userData['evaluation'] !== null)
                <div class="col-md-3">
                    <button class="btn btn-primary" onclick="loadReport('evaluation', '{{ $emp_id }}')">Evaluation Details</button>
                </div>
            @endif

            <!-- Manager Report Button -->
            @if ($userData['managerReview'] !== null)
                <div class="col-md-3">
                    <button class="btn btn-info" onclick="loadReport('managerReport', '{{ $emp_id }}')">Manager Report</button>
                </div>
            @endif

            <!-- Admin Report Button -->
            @if ($userData['adminReview'] !== null)
                <div class="col-md-3">
                    <button class="btn btn-warning" onclick="loadReport('adminReport', '{{ $emp_id }}')">Admin Report</button>
                </div>
            @endif

            <!-- HR Report Button -->
            @if ($userData['hrReview'] !== null)
                <div class="col-md-3">
                    <button class="btn btn-success" onclick="loadReport('hrReport', '{{ $emp_id }}')">HR Report</button>
                </div>
            @endif

            <!-- Client Report Button -->
            @if ($userData['clientReview'] !== null)
                <div class="col-md-3">
                    <button class="btn btn-danger" onclick="loadReport('clientReport', '{{ $emp_id }}')">Client Report</button>
                </div>
            @endif
        </div>

        <!-- Container to dynamically load the report content -->
    </div>
    <div id="reportDetails" style="margin-top: 20px;"></div>


    <!-- jQuery and AJAX script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
   function loadReport(reportType, empId) {
    // Empty the report content container to avoid appending new content to old content
    $('#reportDetails').empty();

    // Dynamically set the correct URL for the report (should return only the table content)
    let url = '';
    switch (reportType) {
        case 'evaluation':
            url = `/evaluation/details/${empId}`;
            break;
        case 'managerReport':
            url = `/manager/report/${empId}`;
            break;
        case 'adminReport':
            url = `/admin/report/${empId}`;
            break;
        case 'hrReport':
            url = `/hr/report/${empId}`;
            break;
        case 'clientReport':
            url = `/client/report/${empId}`;
            break;
        default:
            // If an unknown report type is provided, set the URL to an empty string or a fallback URL
            console.error('Unknown report type');
            url = '';
            break;
    }

    // If a valid URL is set, make an AJAX request to fetch the report data
    if (url) {
        $.ajax({
            url: url,  // Dynamically constructed URL
            method: 'GET',
            success: function(response) {
                // Inject only the table content into the #reportDetails div
                $('#reportDetails').html(response);  // Only table content
            },
            error: function() {
                $('#reportDetails').html('<p>Sorry, there was an error loading the report.</p>');
            }
        });
    } else {
        $('#reportDetails').html('<p>Invalid report type provided.</p>');
    }
}


    </script>
@endsection

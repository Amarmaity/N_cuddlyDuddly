@extends('layouts.app')

@section('title', 'Appraisal Dashboard')
@section('breadcrumb', 'Appraisal Table')
@section('page-title', 'Appraisal Section')

@section('content')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .search-container {
        display: flex;
        justify-content: space-between;
        padding: 10px;
    }

    .search-container input {
        padding: 5px;
        width: 200px;
    }
</style>

<!-- Appraisal Table -->
<!-- Appraisal Table -->
<div class="table-responsive">
    <div class="search-container">
        <div>
            <label>🔍 Search by Employee ID:</label>
            <input type="search" name="employee_id" id="employee_id" class="form-control" placeholder="e.g.. DS0001">
        </div>
        <div>
            <label>🔍 Search by Employee Name:</label>
            <input type="search" name="employee_name" id="employee_name" class="form-control" placeholder="Enter Employee Name">
        </div>
    </div>

    <h3>📊 <strong>Appraisal Table</strong></h3>

    <table class="table table-striped table-hover apprisal-table">
        <thead id="table-header">
            <tr>
                <th>Employee Name</th>
                <th>HR Review (%)</th>
                <th>Admin Review (%)</th>
                <th>Manager Review (%)</th>
                <!-- Client Review Column will be added dynamically -->
                <th id="client-column-header" style="display: none;">Client Review (%)</th> <!-- Initially hidden -->
                <th>Appraisal Score (%)</th>
                <th>Current Salary (₹)</th>
            </tr>
        </thead>
        <tbody id="appraisal-body">
            <tr>
                <td colspan="7">🔍 Enter Employee ID or Name to view data.</td>
            </tr>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
    function fetchEmployeeData() {
        let employeeId = $('#employee_id').val().trim();
        let employeeName = $('#employee_name').val().trim();

        if (employeeId.length === 0 && employeeName.length === 0) {
            $('#appraisal-body').html('<tr><td colspan="7">🔍 Enter Employee ID or Name to view data.</td></tr>');
            return;
        }

        $.ajax({
            url: "{{ route('apprisal.data') }}",
            method: "GET",
            data: { employee_id: employeeId, employee_name: employeeName },
            success: function (response) {
                let tableRows = '';
                let showClientReviewColumn = response.clientReviewData && response.clientReviewData.length > 0;

                // Show or hide the Client Review column dynamically
                if (showClientReviewColumn) {
                    $('#client-column-header').show(); // Show client review column
                } else {
                    $('#client-column-header').hide(); // Hide client review column
                }

                if (response.status === "pending") {
                    tableRows = `<tr><td colspan="7">${response.message}</td></tr>`;
                } else if (Array.isArray(response.hrReviewData) && response.hrReviewData.length > 0) {
                    response.hrReviewData.forEach((hrReview, index) => {
                        let employeeName = response.employee_name || 'N/A';
                        let adminReview = parseFloat(response.adminReviewData?.[index] || 0);
                        let hrReviewScore = parseFloat(hrReview || 0);
                        let managerReview = parseFloat(response.managerReviewData?.[index] || 0);
                        let clientReview = showClientReviewColumn ? parseFloat(response.clientReviewData?.[index] || 0) : 0;
                        let baseSalary = parseFloat(response.salary) || 0;

                        let avgReviewPercentage = (hrReviewScore + adminReview + managerReview + clientReview) / (showClientReviewColumn ? 4 : 3);
                        let evaluation = avgReviewPercentage >= 80 ? 'Excellent' : avgReviewPercentage >= 60 ? 'Good' : 'Needs Improvement';

                        tableRows += `<tr>
                            <td>${employeeName}</td>
                            <td>${hrReviewScore.toFixed(2)}%</td>
                            <td>${adminReview.toFixed(2)}%</td>
                            <td>${managerReview.toFixed(2)}%</td>`;
                        
                        // Add Client Review column if available
                        if (showClientReviewColumn) {
                            tableRows += `<td>${clientReview.toFixed(2)}%</td>`;
                        }

                        tableRows += `<td>${evaluation} (${avgReviewPercentage.toFixed(2)}%)</td>
                            <td>₹${baseSalary.toFixed(2)}</td>
                        </tr>`;
                    });
                } else {
                    tableRows = '<tr><td colspan="7">No data available.</td></tr>';
                }

                $('#appraisal-body').html(tableRows);
            },
            error: function (xhr) {
                $('#appraisal-body').html(`<tr><td colspan="7">${xhr.responseJSON?.error || 'Error fetching data'}</td></tr>`);
            }
        });
    }

    $('#employee_id, #employee_name').on('keyup', fetchEmployeeData);
});

</script>

@endsection

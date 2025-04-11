@extends('layouts.app')
<!-- Extends app.blade.php (Header, Sidebar, Footer included) -->

@section('title', 'Financial Dashboard')
<!-- Page Title -->

@section('breadcrumb', 'Financial')
<!-- Breadcrumb -->

@section('page-title', 'Financial-Section')
<!-- Page Title in Breadcrumb -->

@section('content')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="container mt-4">
        <!-- Search Inputs -->
        <div class="d-flex justify-content-between flex-wrap mb-3">
            <div class="mb-3">
                <label for="employee_id" class="form-label fw-bold">🔍 Search by Employee ID:</label>
                <input type="search" name="employee_id" id="employee_id" class="form-control" placeholder="e.g. DS0001"
                    style="max-width: 300px;">
            </div>
            <div class="mb-3">
                <label for="employee_name" class="form-label fw-bold">🔍 Search by Employee Name:</label>
                <input type="search" name="employee_name" id="employee_name" class="form-control"
                    placeholder="Enter Employee Name..." style="max-width: 300px;">
            </div>
        </div>

        <!-- Appraisal Table -->
        <form action="{{route('financial-data-store')}}" method="POST" id="financial-data"
            enctype="multipart/form-data">
            @csrf
            <div class="table-responsive">
                <h3 class="text-center mb-3">📊 <strong>Employee Financial Table</strong></h3>
                <table class="table table-striped table-hover financial-table">
                    <thead class="table-dark">
                        {{-- <tr>

                        </tr> --}}
                        <tr>
                            <th>Employee Name</th>
                            <th>Employee ID</th>
                            <th>HR Review (%)</th>
                            <th>Admin Review (%)</th>
                            <th>Manager Review (%)</th>
                            <th id="client-review-header">Client Review (%)</th>
                            <th>Appraisal Score (%)</th>
                            <th>Current Salary (₹)</th>
                            <th>Enter Percentage (%)</th>
                            <th>Updated Salary (₹)</th>
                            <th>Final Salary (₹)</th>
                            <th>Appraisal Date</th>
                            <th>Apply</th>
                        </tr>
                    </thead>
                    <tbody id="appraisal-body">
                        <tr>
                            <td colspan="12" class="text-muted">🔍 Enter Employee ID or Name to view data.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary mt-3" id="save-financial-data">Save</button>
            </div>
        </form>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
    let clientExist = false;
    // Fetch employee data based on ID or Name input
    function fetchEmployeeData() {
        let employeeId = $('#employee_id').val().trim();
        let employeeName = $('#employee_name').val().trim();

        if (employeeId.length === 0 && employeeName.length === 0) {
            $('#appraisal-body').html('<tr><td colspan="12" class="text-muted">Enter Employee ID or Name to view data.</td></tr>');
            return;
        }

        $.ajax({
            url: "{{ route('financial.data') }}",
            method: "GET",
            data: { employee_id: employeeId, employee_name: employeeName },
            success: function (response) {
                let tableRows = '';
                let showClientReview = response.clientReviewData.some(value => value !== null);

                // Show or hide client review column
                if (!showClientReview) {
                    $('#client-review-header').hide();
                    clientExist = false;
                } else {
                    $('#client-review-header').show();
                    clientExist = true;
                }

               
                response.hrReviewData.forEach((hrReview, index) => {
                    let employeeName = response.employee_name || 'N/A';
                    let adminReview = parseFloat(response.adminReviewData[index] || 0);
                    let managerReview = parseFloat(response.managerReviewData[index] || 0);
                    let clientReview = showClientReview ? parseFloat(response.clientReviewData[index] || 0) : null;
                    let baseSalary = parseFloat(response.salary) || 0;
                    let divisor = showClientReview ? 4 : 3;
                    let avgReviewPercentage = (parseFloat(hrReview) + adminReview + managerReview + (clientReview || 0)) / divisor;

                   tableRows += `<tr data-salary="${baseSalary}">
                        <td class="employeeName">${employeeName}</td> <!-- Correct class for employee name -->
                        <td class="employeeId">${employeeId}</td> <!-- Correct class for employee ID -->
                        <td class="hrReview">${parseFloat(hrReview).toFixed(2)}%</td>
                        <td class="adminReview">${adminReview.toFixed(2)}%</td>
                        <td class="managerReview">${managerReview.toFixed(2)}%</td>
                        ${showClientReview ? `<td class="clientReview">${clientReview.toFixed(2)}%</td>` : ''}
                        <td class="avgReview">${avgReviewPercentage.toFixed(2)}%</td>
                        <td class="currentSalary">₹${baseSalary.toFixed(2)}</td>
                        <td><input type="number" id="percentage-input" class="form-control percentage-input" style="width: 100px;" min="0"></td>
                        <td class="updated-salary">₹0.00</td>
                        <td class="final-salary">₹0.00</td>
                        <td class="appraisal-date">${response.appraisalDate || 'N/A'}</td>
                        <td><button type="button" class="btn btn-success btn-sm apply-btn">Apply</button></td>
                    </tr>`;

                });

                $('#appraisal-body').html(tableRows);
            }
        });
    }

    $(document).on("click", ".apply-btn", function () {
    let row = $(this).closest("tr");
    let baseSalary = parseFloat(row.attr("data-salary")) || 0;
    let percentageIncrease = parseFloat(row.find(".percentage-input").val()) || 0;
    
    let appraisalScore ;
    if (clientExist) {
        appraisalScore = parseFloat(row.find("td:eq(6)").text()) || 0; // If client review exists
    } else {
        appraisalScore = parseFloat(row.find("td:eq(5)").text()) || 0; // Else use manager review
    }

    // Calculate the updated salary
    let updatedSalary = (baseSalary * percentageIncrease) / 100;

    // Correct final salary calculation
    let finalSalary = baseSalary + (updatedSalary * appraisalScore / 100);

    // Update the table with calculated values
    row.find(".updated-salary").text(`₹${updatedSalary.toFixed(2)}`);
    row.find(".final-salary").text(`₹${finalSalary.toFixed(2)}`);
});


    // Save form data on submit
    $('#save-financial-data').click(function(e) {
    e.preventDefault();

    let employees = [];
    $('#appraisal-body tr').each(function() {
        let row = $(this);
        let employee = {
            employee_name: row.find(".employeeName").text().trim(),
            emp_id: row.find(".employeeId").text().trim(),
            hr_review: parseFloat(row.find(".hrReview").text()) || 0,
            admin_review: parseFloat(row.find(".adminReview").text()) || 0,
            manager_review: parseFloat(row.find(".managerReview").text()) || 0,
            clint_review: parseFloat(row.find(".clientReview").text()) || 0,
            apprisal_score: parseFloat(row.find(".avgReview").text()) || 0,
            current_salary: parseFloat(row.find(".currentSalary").text().replace('₹', '').trim()) || 0,
            percentage_given: parseFloat(row.find(".percentage-input").val()) || 0,
            update_salary: parseFloat(row.find(".updated-salary").text().replace('₹', '').trim()) || 0,
            final_salary: parseFloat(row.find(".final-salary").text().replace('₹', '').trim()) || 0,
            apprisal_date: row.find(".appraisal-date").text() || 'N/A'
        };

        employees.push(employee);
    });
    

    if (employees.length === 0) {
        alert("No employee data to save!");
        return;
    }


$.ajax({
    url: '{{ route('financial-data-store') }}',
    method: 'POST',
    contentType: "application/json",  //  Fix here
    dataType: 'json',
    data: JSON.stringify({  // Convert data to JSON string
        _token: '{{ csrf_token() }}',
        employees: employees
    }),
    success: function(response) {
        alert('Data saved successfully!');
    },
    error: function(xhr, status, error) {
        console.error(xhr.responseText);  // Log the response from the backend
        alert('An error occurred: ' + error);
    }
});

});


    // Trigger data fetch when user types in search inputs
    $("#employee_id, #employee_name").on("input", fetchEmployeeData);
});

</script>


@endsection
@extends('layouts.app') <!-- Extends app.blade.php (Header, Sidebar, Footer included) -->

@section('title', 'Financial Dashboard') <!-- Page Title -->

@section('breadcrumb', 'Financial') <!-- Breadcrumb -->

@section('page-title', 'Financial-Section') <!-- Page Title in Breadcrumb -->

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
                    <input type="search" name="employee_id" id="employee_id" class="form-control"
                        placeholder="e.g. DS0001" style="max-width: 300px;">
                </div>
                <div class="mb-3">
                    <label for="employee_name" class="form-label fw-bold">🔍 Search by Employee Name:</label>
                    <input type="search" name="employee_name" id="employee_name" class="form-control"
                        placeholder="Enter Employee Name..." style="max-width: 300px;">
                </div>
            </div>

            <!-- Appraisal Table -->
            <form action="#" method="POST" id="financial-data" enctype="multipart/form-data">
                @csrf
                <div class="table-responsive">
                    <h3 class="text-center mb-3">📊 <strong>Employee Financial Table</strong></h3>
                    <table class="table table-striped table-hover financial-table">
                        <thead class="table-dark">
                            <tr>
                                <th>Employee Name</th>
                                <th>Employee ID</th>
                                <th>HR Review (%)</th>
                                <th>Admin Review (%)</th>
                                <th>Manager Review (%)</th>
                                <th>Client Review (%)</th>
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
            </div>
        </div>
        <!-- Include jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
           $(document).ready(function () {
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

                if (response.status === "pending") {
                    tableRows = `<tr><td colspan="12">${response.message}</td></tr>`;
                } else if (response.hrReviewData.length > 0) {
                    response.hrReviewData.forEach((hrReview, index) => {
                        let employeeName = response.employee_name || 'N/A';
                        let adminReview = parseFloat(response.adminReviewData[index] || 0);
                        let managerReview = parseFloat(response.managerReviewData[index] || 0);
                        let clientReview = parseFloat(response.clientReviewData[index] || 0);
                        let baseSalary = parseFloat(response.salary) || 0;

                        let avgReviewPercentage = (parseFloat(hrReview) + adminReview + managerReview + clientReview) / 4;

                        tableRows += `<tr data-salary="${baseSalary}">
                            <td>${employeeName}</td>
                            <td>${employeeId}</td>
                            <td>${parseFloat(hrReview).toFixed(2)}%</td>
                            <td>${adminReview.toFixed(2)}%</td>
                            <td>${managerReview.toFixed(2)}%</td>
                            <td>${clientReview.toFixed(2)}%</td>
                            <td>${avgReviewPercentage.toFixed(2)}%</td>
                            <td>₹${baseSalary.toFixed(2)}</td>
                            <td><input type="number" class="form-control percentage-input" style="width: 100px;" min="0"></td>
                            <td class="updated-salary">₹0.00</td>
                            <td class="final-salary">₹0.00</td>
                            <td>${response.appraisalDate || 'N/A'}</td>
                            <td><button class="btn btn-success btn-sm apply-btn">Apply</button></td>
                        </tr>`;
                    });
                } else {
                    tableRows = '<tr><td colspan="12">No data available.</td></tr>';
                }

                $('#appraisal-body').html(tableRows);
            },
            error: function (xhr) {
                console.log(xhr.responseJSON);
                $('#appraisal-body').html(`<tr><td colspan="12">${xhr.responseJSON.error}</td></tr>`);
            }
        });
    }

    $(document).on("click", ".apply-btn", function (e) {
        e.preventDefault();  // Prevent form submission on Apply button click

        let row = $(this).closest("tr");

        let baseSalary = parseFloat(row.attr("data-salary")) || 0;
        let percentageIncrease = parseFloat(row.find(".percentage-input").val()) || 0;
        let appraisalScore = parseFloat(row.find("td:eq(6)").text()) || 0;

        if (percentageIncrease <= 0 || isNaN(percentageIncrease)) {
            alert("Please enter a valid percentage.");
            return;
        }

        let updatedSalary = (baseSalary * percentageIncrease) / 100;
        let finalSalary = (updatedSalary * appraisalScore) / 100;
        let totalSalary = baseSalary + finalSalary;

        row.find(".updated-salary").text(`₹${updatedSalary.toFixed(2)}`);
        row.find(".final-salary").text(`₹${totalSalary.toFixed(2)}`);
    });

    $("#employee_id, #employee_name").on("input", fetchEmployeeData);

    $("#financial-data").on("submit", function (e) {
    e.preventDefault(); // Prevent page reload

    let allData = [];

    $("#appraisal-body tr").each(function () {
        let row = $(this);
        let employeeId = row.find("td:eq(1)").text();

        if (employeeId.trim() === "") return;

        allData.push({
            employee_name: row.find("td:eq(0)").text(),
            employee_id: employeeId,
            hr_review: row.find("td:eq(2)").text(),
            admin_review: row.find("td:eq(3)").text(),
            manager_review: row.find("td:eq(4)").text(),
            client_review: row.find("td:eq(5)").text(),
            appraisal_score: row.find("td:eq(6)").text(),
            current_salary: row.find("td:eq(7)").text().replace("₹", "").trim(),
            entered_percentage: row.find(".percentage-input").val(),  
            updated_salary: row.find(".updated-salary").text().replace("₹", "").trim(),
            final_salary: row.find(".final-salary").text().replace("₹", "").trim(),
            appraisal_date: row.find("td:eq(11)").text()
        });
    });

    if (allData.length === 0) {
        alert("No data to submit.");
        return;
    }

    $.ajax({
        type: "POST",
        url: "/financial-data-store",  // Your route here
        data: {
            "_token": $("meta[name='csrf-token']").attr("content"),
            "employee_data": allData  // Send the data as an array
        },
        success: function(response) {
            alert(response.message);
        },
        error: function(xhr, status, error) {
            // Check if the error is due to the employee's appraisal already being done
            if (xhr.status === 400) {
                alert(xhr.responseJSON.message);
            } else {
                alert("An error occurred. Please try again.");
            }
        }
    });
});
});
     
</script>
@endsection

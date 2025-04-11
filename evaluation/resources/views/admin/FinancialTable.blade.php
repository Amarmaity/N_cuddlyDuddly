@extends('layouts.app')

@section('title', 'Financial Dashboard')

@section('breadcrumb', 'Financial Data')

@section('page-title', 'Financial Section')

@section('content')

<body>
    <div class="search-container">
        <label>🔍 Search Employee ID:</label>
        <input type="search" id="search_employee_id" placeholder="e.g.. DS0001">

        <label>🔍 Search Employee Name:</label>
        <input type="search" id="search_employee_name" placeholder="Search Employee Name">
    </div>
    <br>

    <!-- Financial Data Table -->
    @if($financialData->count() > 0)
        <h2>Financial Data</h2>
        <table class="table table-striped table-hover userlist-table" id="employeeDetails">
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>HR Review (%)</th>
                    <th>Admin Review (%)</th>
                    <th>Manager Review (%)</th>
                    <th>Client Review (%)</th>
                    <th>Appraisal Score (%)</th>
                    <th>Current Salary</th>
                    <th>Company Given (%)</th>
                    <th>Updated Salary</th>
                    <th>Final Salary</th>
                    <th>Appraisal Date</th>
                </tr>
            </thead>
            <tbody id="employeeList">
                @foreach ($financialData as $financial)
                    <tr>
                        <td>{{ $financial->emp_id }}</td>
                        <td>{{ $financial->fname }} {{ $financial->lname }}</td>
                        <td>{{ $financial->hr_review ?? '-' }}</td>
                        <td>{{ $financial->admin_review ?? '-' }}</td>
                        <td>{{ $financial->manager_review ?? '-' }}</td>
                        <td>{{ $financial->clint_review ?? '-' }}</td>
                        <td>{{ $financial->apprisal_score ?? '-' }}</td>
                        <td>{{ $financial->current_salary ?? '-' }}</td>
                        <td>{{ $financial->percentage_given ?? '-' }}</td>
                        <td>{{ $financial->update_salary ?? '-' }}</td>
                        <td>{{ $financial->final_salary ?? '-' }}</td>
                        <td>{{ $financial->apprisal_date ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No financial data found.</p>
    @endif

</body>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 

<script>

$(document).ready(function () {
    let timeout = null;
    let originalTableHtml = $('#employeeList').html(); // Save the original employee list

    function searchEmployee() {
        let employeeId = $('#search_employee_id').val().trim();
        let employeeName = $('#search_employee_name').val().trim();
        let searchType = ''; // Default search type

        if (employeeId !== "") {
            searchType = 'id';
        } else if (employeeName !== "") {
            searchType = 'name';
        }

        if (employeeId === "" && employeeName === "") {
            clearTimeout(timeout);
            $('#employeeList').html(originalTableHtml);
            $('#employeeDetails').show();
            return;
        }

        if (employeeId.length >= 2 || employeeName.length >= 2) {
            $('#employeeDetails').show();
            $('#employeeList').html('<tr><td colspan="12">Searching...</td></tr>');
        } else {
            $('#employeeDetails').hide();
            return;
        }

        let searchRoute = "{{ route('super.user.search.bar') }}"; // Correct route name

        clearTimeout(timeout);
        timeout = setTimeout(function () {
            $.ajax({
                url: searchRoute,
                type: 'GET',
                data: { query: employeeId || employeeName, type: searchType },
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log("Response received:", response);  // Log the response for debugging

                    $('#employeeList').empty(); // Clear the employee list

                    // Check if there is financial data in the response
                    if (response.financialData && response.financialData.length > 0) {
                        response.financialData.forEach(financial => {
                            let row = `<tr>
                                <td>${financial.emp_id}</td>
                                <td>${financial.fname} ${financial.lname}</td>
                                <td>${financial.hr_review ?? '-'}</td>
                                <td>${financial.admin_review ?? '-'}</td>
                                <td>${financial.manager_review ?? '-'}</td>
                                <td>${financial.clint_review ?? '-'}</td>
                                <td>${financial.apprisal_score ?? '-'}</td>
                                <td>${financial.current_salary ?? '-'}</td>
                                <td>${financial.percentage_given ?? '-'}</td>
                                <td>${financial.update_salary ?? '-'}</td>
                                <td>${financial.final_salary ?? '-'}</td>
                                <td>${financial.apprisal_date ?? '-'}</td>
                            </tr>`;
                            $('#employeeList').append(row);
                        });
                    }

                    // If no data is found in the response
                    if (response.financialData.length === 0) {
                        $('#employeeList').html('<tr><td colspan="12">No matching data found</td></tr>');
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                    alert("An error occurred. Please try again.");
                }
            });
        }, 1500);
    }

    $('#search_employee_id').on('keyup', searchEmployee);
    $('#search_employee_name').on('keyup', function () {
        this.value = this.value.replace(/[^A-Za-z\s]/g, "");
        searchEmployee();
    });
});

</script>

@endsection

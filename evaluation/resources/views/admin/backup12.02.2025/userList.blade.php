@extends('layouts.app')

@section('title', 'Apprisal Dashboard')
@section('breadcrumb', 'User Listing')
@section('page-title', 'Apprisal-Section')

@section('content')

    <style>
        /* Loading animation */
        .loading {
            color: blue;
            font-weight: bold;
            font-size: 14px;
            text-align: center;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        /* Search bar styling */
        .search-container {
            display: flex;
            justify-content: space-between;
            padding: 10px;
        }

        .search-container input {
            padding: 5px;
            width: 200px;
        }

        /* Button styling */
        button {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }

        .inactive {
            background-color: green;
            color: white;
        }
    </style>




    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body>
        <!-- Employee Table -->
        <div class="table-responsive">
            <div class="search-container">
                <div>
                    <label>🔍 Search Employee ID:</label>
                    <input type="search" name="search_id" placeholder="e.g.. DS0001">
                </div>
                <div>
                    <label>🔍 Search Name:</label>
                    <input type="search" name="search_name" placeholder="Search Employee Name">
                </div>
            </div>

            <table class="table table-striped table-hover userlist-table">
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
                <tbody class="table table-striped table-hove userlist-table" id="employee-table">
                    @foreach ($users as $user)
                        @if ($user->status)
                            <tr id="row-{{ $user->employee_id }}">
                                <td>{{ $user->fname }} {{ $user->lname }}</td>
                                <td>{{ $user->employee_id }}</td>
                                <td>{{ $user->designation }}</td>
                                <td>{{ $user->salary }}</td>
                                <td>{{ $user->mobno }}</td>
                                <td>{{ $user->email }}</td>
                                <td id="status-{{ $user->employee_id }}">
                                    {{ $user->status ? 'Active' : 'Inactive' }}
                                </td>
                                <td>
                                    <button id="toggle-{{ $user->employee_id }}" class="toggle-btn"
                                        data-user-id="{{ $user->employee_id }}"
                                        style="background-color: {{ $user->status ? 'red' : 'green' }}; color: white;">
                                        {{ $user->status ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Event listeners for search
            document.querySelector('input[name="search_id"]').addEventListener("input", function () {
                searchEmployee(this.value, "id");
            });

            document.querySelector('input[name="search_name"]').addEventListener("input", function () {
                this.value = this.value.replace(/[^A-Za-z\s]/g, ""); // Allow only letters and spaces
                searchEmployee(this.value, "name");
            });

            // Event delegation for toggle buttons
            document.getElementById("employee-table").addEventListener("click", function (event) {
                if (event.target.classList.contains("toggle-btn")) {
                    let userId = event.target.getAttribute("data-user-id");
                    if (userId) toggleStatus(userId);
                }
            });

            // Load active users initially
            loadMainTable();
        });

        // Function to toggle user status (Active/Inactive)
        function toggleStatus(userId) {
            fetch(`/toggle-status/${userId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let statusElement = document.getElementById(`status-${userId}`);
                        let buttonElement = document.getElementById(`toggle-${userId}`);
                        let row = document.getElementById(`row-${userId}`);

                        if (data.new_status) {
                            // User Activated
                            statusElement.innerText = "Active";
                            buttonElement.innerText = "Deactivate";
                            buttonElement.style.backgroundColor = "red";
                        } else {
                            // User Deactivated
                            statusElement.innerText = "Inactive";
                            buttonElement.innerText = "Activate";
                            buttonElement.style.backgroundColor = "green";

                            // Remove row from main table if search is not active
                            let searchQuery = document.querySelector('input[name="search_id"]').value.trim() ||
                                document.querySelector('input[name="search_name"]').value.trim();
                            if (!searchQuery && row) {
                                row.remove();
                            }
                        }
                    } else {
                        alert("Failed to update status: " + data.error);
                    }
                })
                .catch(error => console.error("Error:", error));
        }

        // Function to search employees by ID or Name
        function searchEmployee(query, type) {
            query = query.trim();

            if (query === "") {
                console.log("Search cleared, reloading main table...");
                loadMainTable(); // Reload only active users
                return;
            }

            fetch(`/search-employee?query=${encodeURIComponent(query)}&type=${type}`)
                .then(response => response.json())
                .then(data => {
                    if (data.message === "User not found" || data.length === 0) {
                        showNoResults();
                    } else {
                        updateTable(data, true); // Show both active & inactive users when searching
                    }
                })
                .catch(error => console.error("Error fetching data:", error));
        }



        // Function to update table with users
        function updateTable(users, showAllUsers = false) {
            let tbody = document.getElementById("employee-table");
            tbody.innerHTML = ""; // Clear existing rows

            users.forEach(user => {
                let isActive = user.status;

                // Show only active users unless searching
                if (!isActive && !showAllUsers) return;

                let statusText = isActive ? "Active" : "Inactive";
                let toggleText = isActive ? "Deactivate" : "Activate";
                let toggleColor = isActive ? "red" : "green";

                let row = `<tr id="row-${user.employee_id}">
                            <td>${user.fname} ${user.lname}</td>
                            <td>${user.employee_id || "-"}</td>
                            <td>${user.designation || "-"}</td>
                            <td>${user.salary || "-"}</td>
                            <td>${user.mobno || "-"}</td> 
                            <td>${user.email || "-"}</td>
                            <td id="status-${user.employee_id}">${statusText}</td>
                            <td>
                                <button id="toggle-${user.employee_id}" class="toggle-btn"
                                    data-user-id="${user.employee_id}"
                                    style="background-color: ${toggleColor}; color: white;">
                                    ${toggleText}
                                </button>
                            </td>
                        </tr>`;
                tbody.insertAdjacentHTML("beforeend", row);
            });
        }



        // Function to show "No Employee Found"
        function showNoResults() {
            let tbody = document.getElementById("employee-table");
            tbody.innerHTML = `<tr><td colspan="8" style="text-align: center; font-weight: bold;">No Employee Found</td></tr>`;
        }

        // Function to load only active users in the main table
        function loadMainTable() {
            fetch(`/get-active-users`)  // Ensure backend route returns only active users
                .then(response => response.json())
                .then(data => updateTable(data, false)) // Show only active users
                .catch(error => console.error("Error loading main table:", error));
        }
    </script>



@endsection
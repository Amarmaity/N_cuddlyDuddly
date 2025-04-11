@extends('layouts.app') <!-- Extends app.blade.php (Header, Sidebar, Footer included) -->

@section('title', 'Super Admin Dashboard') <!-- Page Title -->

@section('breadcrumb', 'Super Admin') <!-- Breadcrumb -->

@section('page-title', 'Super Admin Dashboard') <!-- Page Title in Breadcrumb -->

@section('content')

    <body>



        <div class="container">
            <div class="form-header">
                <h2>Add New User</h2>
            </div>

            <form action="{{ route('save-user') }}" method="POST" enctype="multipart/form-data" id="userForm">
                @csrf

                <!-- Personal Information Section -->
                <div class="form-section">
                    <h5>Personal Information</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="fname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter first name"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter last name"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="dob" name="dob" required>
                        </div>
                        <div class="col-md-6">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="" selected disabled>Select gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="form-section">
                    <h5>Contact Information</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="mobno" class="form-label">Mobile Number</label>
                            <input type="text" class="form-control" id="mobno" name="mobno"
                                placeholder="Enter mobile number" required>
                        </div>
                    </div>
                </div>

                <!-- Work Information Section -->
                <div class="form-section">
                    <h5>Work Information</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="employee_id" class="form-label">Employee ID</label>
                            <input type="text" class="form-control" id="employee_id" name="employee_id"
                                placeholder="e.g..DS00001">
                        </div>
                        <div class="col-md-6">
                            <label for="designation" class="form-label">Designation</label>
                            <select class="form-control" id="user_type_dropdown" name="designation" required>
                                <option value="" selected disabled>Select Designation</option>
                                <option value=" Hr">Hr</option>
                                <option value="SEO">SEO</option>
                                <option value="Admin">Admin</option>
                                <option value="UI/UX Designer">UI/UX Designer</option>
                                <option value="Quality Analyst">Quality Analyst</option>
                                <option value="Software Developer">Software Developer</option>
                                <option value="Manager">Manager</option>
                                <option value="Client">Client</option>
                                <option value="Business Development">Business Development(Sales)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- User Type Selection (Dropdown & Checkboxes) -->
                <div class="form-section">
                    <h5>Select User Type</h5>

                    <!-- Dropdown for User Type -->
                    <div class="row">
                        <div class="col-md-6">
                            <label for="user_type_dropdown" class="form-label">User Type</label>
                            <select class="form-control" id="user_type_dropdown" name="user_type" required>
                                <option value="" selected disabled>Select User Type</option>
                                <option value="admin">Admin</option>
                                <option value="hr">HR</option>
                                <option value="users">Users</option>
                                <option value="manager">Manager</option>
                                <option value="client">Client</option>
                            </select>
                        </div>
                    </div>

                    <!-- Checkboxes for Multiple Roles -->
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h6>Selected Person Can Review:</h6>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="admin" name="user_roles[]"
                                    value="admin">
                                <label class="form-check-label" for="admin">Admin</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="hr" name="user_roles[]" value="hr">
                                <label class="form-check-label" for="hr">HR</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="users" name="user_roles[]"
                                    value="users">
                                <label class="form-check-label" for="users">Users</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="manager" name="user_roles[]"
                                    value="manager">
                                <label class="form-check-label" for="manager">Manager</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="client" name="user_roles[]"
                                    value="client">
                                <label class="form-check-label" for="client">Client</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Information Section -->
                <div class="form-section">
                    <h5>Account Information</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="salary" class="form-label">Salary</label>
                            <input type="number" class="form-control" id="salary" name="salary" placeholder="Enter Salary"
                        >
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Enter password" required>
                        </div>
                    </div>
                </div>

                <!-- Confirmation Checkbox & Save Button -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary mt-3" id="userForm">Save User</button>
                </div>

            </form>

        </div>
    </body>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#userForm').on('submit', function (e) {
                e.preventDefault(); // Prevent default form submission

                var actionUrl = "{{ route('save-user') }}"; // Ensure route exists

                $.ajax({
                    url: actionUrl,
                    type: "POST",
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status === "success") {
                            alert(response.message); // Success alert
                            $('#userForm')[0].reset(); // Reset form after successful submission
                        } else {
                            alert("Failed to submit user data. Please try again.");
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText); // Log error details in console

                        if (xhr.status === 422) { // Laravel validation error
                            var errors = xhr.responseJSON.errors;
                            var errorMessages = '';

                            $.each(errors, function (field, messages) {
                                errorMessages += messages.join("\n") + "\n";
                            });

                            alert(errorMessages); // Show validation errors in alert
                        } else {
                            alert("Something went wrong. Please try again.");
                        }
                    }
                });
            });
        });
    </script>
@endsection 
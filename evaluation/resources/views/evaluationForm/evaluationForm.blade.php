<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Side by Side Form</title>

    @extends('layouts.app')

    <!-- CSRF Token for AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
@section('content')

    <body>

        <!-- Centered Headings -->


        <!-- Form Section -->
        <div class="container">
            <div class="text-center mb-4">
                <h1>EVALUATION</h1>
                <h4>DELOSTYLE STUDIO PRIVATE LIMITED</h4>
            </div>

            <form action="{{route('insert-data-evaluation')}}" method="post" id="evaluationSubmit" class="evaluation__form"
                enctype="multipart/form-data">
                @csrf
                <div class="form-section1">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label for="designation" class="mb-2">Designation:</label>
                            <input type="text" name="designation" id="designation" placeholder="Enter designation" required
                                class="form-control">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="salary_grade" class="mb-2">Salary Grade/Band:</label>
                            <input type="text" name="salary_grade" id="salary_grade" placeholder="Enter Salary Grade"
                                required class="form-control">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="employee_name" class="mb-2">Name of Employee:</label>
                            <input type="text" name="employee_name" id="employee_name" placeholder="Enter name" required
                                class="form-control">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="emp_id" class="mb-2">Employee Id:</label>
                            <input type="text" name="emp_id" id="emp_id" placeholder="Enter Employee Id" required
                                class="form-control">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="department" class="mb-2">Department:</label>
                            <input type="text" name="department" id="department" placeholder="Enter Department" required
                                class="form-control">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="evaluation_purpose" class="mb-2">Evaluation Purpose:</label>
                            <input type="text" name="evaluation_purpose" id="evaluation_purpose"
                                placeholder="Enter Evaluation Purpose" required class="form-control">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="division" class="mb-2">Division:</label>
                            <input type="text" name="division" id="division" placeholder="Enter Division" required
                                class="form-control">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="manager_name" class="mb-2">Manager Name:</label>
                            <input type="text" name="manager_name" id="manager_name" placeholder="Enter Manager Name"
                                required class="form-control">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="joining_date" class="mb-2">Joining Date:</label>
                            <input type="date" name="joining_date" id="joining_date" required class="form-control">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="review_period" class="mb-2">Review Period:</label>
                            <input type="text" name="review_period" id="review_period" placeholder="Enter Review Period"
                                required class="form-control">
                        </div>
                    </div>
                    <div class="text-center mt-5 mb-4">
                        <h4>FUNCTIONAL SKILLS</h4>
                        <h5>CRITERIA</h5>
                        <h5>Quality of Work (Out of 15 Marks)</h5>
                    </div>

                    <!-- Left Section (Ratings) -->
                    <div class="form-section">
                        <label for="accuracy_neatness" class="mb-2">Accuracy, neatness and timeliness of work:</label>
                        <input type="number" name="accuracy_neatness" id="qw1" min="0" max="5" required
                            oninput="qualityWorkTotalRating()" placeholder="Rate Yourself" class="form-control">

                        <label for="comment" class="mb-2">Justyfi Your Review.</label>
                        <textarea name="comments_accuracy" id="comments" class="form-control" rows="5" cols="50"></textarea>

                        <label for="adherence" class="mb-2">Adherence to duties and procedures in Job Description and Work
                            Instructions:</label>
                        <input type="number" name="adherence" id="qw2" min="0" max="5" required
                            oninput="qualityWorkTotalRating()" placeholder="Rate Yourself" class="form-control">

                        <label for="comment" class="mb-2">Justyfi Your Review.</label>
                        <textarea name="comments_adherence" id="comments" class="form-control" rows="5"
                            cols="50"></textarea>

                        <label for="synchronization" class="mb-2">Synchronization with organizations/functional
                            goals:</label>
                        <input type="number" name="synchronization" id="qw3" min="0" max="5" required
                            oninput="qualityWorkTotalRating()" placeholder="Rate Yourself" class="form-control">

                        <label for="functional_goals" class="mb-2">Justyfi Your Review</label>
                        <textarea name="comments_synchronization" id="comments" class="form-control" rows="5"
                            cols="50"></textarea>

                        <label for="qualityworktotalrating" class="mb-2">Quality of Work Total Rating:</label>
                        <input type="text" name="qualityworktotalrating" id="qualityworktotalrating" readonly
                            class="form-control">

                    </div>

                    <!-- Work Habits Section -->
                    <div class="text-center mt-5 mb-4">
                        <h4>Work Habits (Out of 20 Marks)</h4>
                    </div>

                    <!-- Left Section (Ratings) -->
                    <div class="form-section">
                        <div>
                            <label for="punctuality" class="mb-2">Punctuality to workplace:</label>
                            <input type="number" name="punctuality" id="wh1" min="0" max="5" required
                                oninput="workHabitsTotalRating()" placeholder="Rate Yourself" class="form-control">

                            <label for="comments_punctuality" class="mb-2">Justify Your Review:</label>
                            <textarea name="comments_punctuality" id="comments_punctuality" class="form-control" rows="5"
                                cols="50"></textarea>
                        </div>

                        <div>
                            <label for="attendance" class="mb-2">Attendance:</label>
                            <input type="number" name="attendance" id="wh2" min="0" max="5" required
                                oninput="workHabitsTotalRating()" placeholder="Rate Yourself" class="form-control">

                            <label for="comments_attendance" class="mb-2">Justify Your Review:</label>
                            <textarea name="comments_attendance" id="comments_attendance" class="form-control" rows="5"
                                cols="50"></textarea>
                        </div>

                        <div>
                            <label for="initiatives_at_workplace" class="mb-2">Does the employee stay busy, look for things
                                to do, take
                                initiatives at workplace:</label>
                            <input type="number" name="initiatives_at_workplace" id="wh3" min="0" max="5" required
                                oninput="workHabitsTotalRating()" placeholder="Rate Yourself" class="form-control">

                            <label for="comments_initiatives" class="mb-2">Justify Your Review:</label>
                            <textarea name="comments_initiatives" id="comments_initiatives" class="form-control" rows="5"
                                cols="50"></textarea>
                        </div>

                        <div>
                            <label for="submits_reports" class="mb-2">Submits reports on time and meets deadlines:</label>
                            <input type="number" name="submits_reports" id="wh4" min="0" max="5" required
                                oninput="workHabitsTotalRating()" placeholder="Rate Yourself" class="form-control">

                            <label for="comments_submits_reports" class="mb-2">Justify Your Review:</label>
                            <textarea name="comments_submits_reports" id="comments_submits_reports" class="form-control"
                                rows="5" cols="50"></textarea>
                        </div>
                    </div>

                    <!-- Right Section (Total Rating) -->
                    <div class="form-section">
                        <label for="work_habits_rating" class="mb-2">Work Habits Total Rating:</label>
                        <input type="text" name="work_habits_rating" id="work_habits_rating" readonly class="form-control">
                    </div>


                    <!-- Job Knowledge Section -->
                    <div class="text-center mt-5 mb-4">
                        <h4>Job Knowledge (Out of 15 Marks)</h4>
                    </div>

                    <!-- Left Section (Ratings) -->
                    <div class="form-section">
                        <div>
                            <label for="skill_ability" class="mb-2">Skill and ability to perform job satisfactorily:</label>
                            <input type="number" name="skill_ability" id="jk1" min="0" max="5" required
                                oninput="jobKnowledgeTotalRating()" placeholder="Rate Yourself" class="form-control">

                            <label for="comments_skill_ability" class="mb-2">Justify Your Review:</label>
                            <textarea name="comments_skill_ability" id="comments_skill_ability" class="form-control"
                                rows="5" cols="50"></textarea>
                        </div>

                        <div>
                            <label for="learning_improving" class="mb-2">Shown interest in learning and improving:</label>
                            <input type="number" name="learning_improving" id="jk2" min="0" max="5" required
                                oninput="jobKnowledgeTotalRating()" placeholder="Rate Yourself" class="form-control">

                            <label for="comments_learning_improving" class="mb-2">Justify Your Review:</label>
                            <textarea name="comments_learning_improving" id="comments_learning_improving"
                                class="form-control" rows="5" cols="50"></textarea>
                        </div>

                        <div>
                            <label for="problem_solving_ability" class="mb-2">Problem solving ability:</label>
                            <input type="number" name="problem_solving_ability" id="jk3" min="0" max="5" required
                                oninput="jobKnowledgeTotalRating()" placeholder="Rate Yourself" class="form-control">

                            <label for="comments_problem_solving" class="mb-2">Justify Your Review:</label>
                            <textarea name="comments_problem_solving" id="comments_problem_solving" class="form-control"
                                rows="5" cols="50"></textarea>
                        </div>
                    </div>

                    <!-- Right Section (Total Rating) -->
                    <div class="form-section">
                        <div>
                            <label for="jk_total_rating" class="mb-2">Job Knowledge Total Rating:</label>
                            <input type="text" name="jk_total_rating" id="jk_total_rating" readonly class="form-control">
                        </div>
                    </div>

                    <!-- Scoring System Section -->
                    {{-- <div class="text-center mt-5 mb-4">
                        <h4>Scoring System</h4>
                    </div> --}}

                    {{-- <table class="scoring-table">
                        <thead>
                            <tr>
                                <th>Attribute</th>
                                <th>Score</th>
                                <th class="total-cell">Total</th> <!-- Total in the last column -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="attribute-row">
                                <td>Outstanding</td>
                                <td class="score-column">5</td>
                                <td rowspan="5" id="total-score" class="total-cell" name="total_scoring_system"></td>
                                <!-- Single cell for total -->
                            </tr>
                            <tr class="attribute-row">
                                <td>Exceeds Requirements</td>
                                <td class="score-column">4</td>
                            </tr>
                            <tr class="attribute-row">
                                <td>Meets Requirements</td>
                                <td class="score-column">3</td>
                            </tr>
                            <tr class="attribute-row">
                                <td>Needs Improvement</td>
                                <td class="score-column">2</td>
                            </tr>
                            <tr class="attribute-row">
                                <td>Unsatisfactory</td>
                                <td class="score-column">1</td>
                            </tr>
                        </tbody>
                    </table> --}}


                    {{-- Recomendation part --}}

                    <!-- Evaluator Recommendations Section -->
                    <div class="mt-4">
                        <div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="recommendation" class="mb-2">Recommendations:</label>
                                    <textarea name="recomendation" id="evalution_recomendation" rows="5" cols="50"
                                        class="form-control"></textarea>
                                </div>

                                <div class="col-12 col-md-4">
                                    <label for="evalutors_name" class="mb-2">Evaluator's Name::</label>
                                    <input type="text" id="evalutors_name" name="evalutors_name" placeholder="Enter Name"
                                        class="form-control">
                                </div>
                                <div class="col-12 col-md-4">
                                    <label for="signatur" class="mb-2">Signature:</label>
                                    <input type="file" id="signatur" name="evaluator_signatur" placeholder="Signatur.."
                                        class="form-control">
                                </div>

                                <div class="col-12 col-md-4">
                                    <label for="date" class="mb-2">Date:</label>
                                    <input type="date" id="evaluator_date" name="evaluator_signatur_date"
                                        placeholder="Select Date" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Interpersonal Relations/Behaviour Section -->
                    <div class="text-center mt-5 mb-4">
                        <h4>Interpersonal Relations/Behaviour (Out of 25 Marks)</h4>
                    </div>

                    <!-- Left Section (Ratings) -->
                    <div class="form-section">
                        <div>
                            <label for="respond_contributes" class="mb-2">Responds and contributes to team efforts:</label>
                            <input type="number" name="respond_contributes" id="ir1" min="0" max="5" required
                                oninput="interpersonalTotalRating()" placeholder="Rate Yourself" class="form-control">

                            <label for="comments_respond_contributes" class="mb-2">Justify Your Review:</label>
                            <textarea name="comments_respond_contributes" id="comments_respond_contributes" rows="5"
                                cols="50" class="form-control"></textarea>
                        </div>

                        <div>
                            <label for="responds_positively" class="mb-2">Responds positively to suggestions, instructions,
                                and
                                criticism:</label>
                            <input type="number" name="responds_positively" id="ir2" min="0" max="5" required
                                oninput="interpersonalTotalRating()" placeholder="Rate Yourself" class="form-control">

                            <label for="comments_responds_positively" class="mb-2">Justify Your Review:</label>
                            <textarea name="comments_responds_positively" id="comments_responds_positively" rows="5"
                                cols="50" class="form-control"></textarea>
                        </div>

                        <div>
                            <label for="supervisor" class="mb-2">Keeps supervisor informed of all details:</label>
                            <input type="number" name="supervisor" id="ir3" min="0" max="5" required
                                oninput="interpersonalTotalRating()" placeholder="Rate Yourself" class="form-control">

                            <label for="comments_supervisor" class="mb-2">Justify Your Review:</label>
                            <textarea name="comments_supervisor" id="comments_supervisor" rows="5" cols="50"
                                class="form-control"></textarea>
                        </div>

                        <div>
                            <label for="adapts_changing" class="mb-2">Adapts well to changing circumstances:</label>
                            <input type="number" name="adapts_changing" id="ir4" min="0" max="5" required
                                oninput="interpersonalTotalRating()" placeholder="Rate Yourself" class="form-control">

                            <label for="comments_adapts_changing" class="mb-2">Justify Your Review:</label>
                            <textarea name="comments_adapts_changing" id="comments_adapts_changing" rows="5" cols="50"
                                class="form-control"></textarea>
                        </div>

                        <div>
                            <label for="seeks_feedback" class="mb-2">Seeks feedback to improve:</label>
                            <input type="number" name="seeks_feedback" id="ir5" min="0" max="5" required
                                oninput="interpersonalTotalRating()" placeholder="Rate Yourself" class="form-control">

                            <label for="comments_seeks_feedback" class="mb-2">Justify Your Review:</label>
                            <textarea name="comments_seeks_feedback" id="comments_seeks_feedback" rows="5" cols="50"
                                class="form-control"></textarea>
                        </div>
                    </div>

                    <!-- Right Section (Total Rating) -->
                    <div class="form-section">
                        <div>
                            <label for="ir_total_rating" class="mb-2">Interpersonal Relations Total Rating:</label>
                            <input type="text" name="ir_total_rating" id="ir_total_rating" readonly class="form-control">
                        </div>
                    </div>


                    <!-- Leadership Skills Section -->
                    <div class="text-center mt-5 mb-4">
                        <h4>Leadership (Out of 25 Marks)</h4>
                    </div>

                    <!-- Left Section (Ratings) -->
                    <div class="form-section">
                        <div>
                            <label for="challenges" class="mb-2">Aspirant to climb up the ladder, accepts challenges, new
                                responsibilities, and
                                roles (Out of 10):</label>
                            <input type="number" name="challenges" id="ls1" min="0" max="10" required
                                oninput="leadershipTotalRating()" placeholder="Rate Yourself" class="form-control">

                            <label for="comments_challenges" class="mb-2">Justify Your Review:</label>
                            <textarea name="comments_challenges" id="comments_challenges" class="form-control" rows="5"
                                cols="50"></textarea>
                        </div>

                        <div>
                            <label for="personal_growth" class="mb-2">Innovative thinking - contribution to organizations,
                                functions, and
                                personal growth (Out of 10):</label>
                            <input type="number" name="personal_growth" id="ls2" min="0" max="10" required
                                oninput="leadershipTotalRating()" placeholder="Rate Yourself" class="form-control">

                            <label for="comments_personal_growth" class="mb-2">Justify Your Review:</label>
                            <textarea name="comments_personal_growth" id="comments_personal_growth" class="form-control"
                                rows="5" cols="50"></textarea>
                        </div>

                        <div>
                            <label for="work_motivation" class="mb-2">Work motivation (Out of 5):</label>
                            <input type="number" name="work_motivation" id="ls3" min="0" max="5" required
                                oninput="leadershipTotalRating()" placeholder="Rate Yourself" class="form-control">

                            <label for="comments_work_motivation" class="mb-2">Justify Your Review:</label>
                            <textarea name="comments_work_motivation" id="comments_work_motivation" class="form-control"
                                rows="5" cols="50"></textarea>
                        </div>
                    </div>

                    <!-- Right Section (Total Rating) -->
                    <div class="form-section">
                        <div>
                            <label for="leadership_rating" class="mb-2">Leadership Skill Total Rating:</label>
                            <input type="text" name="leadership_rating" id="leadership_rating" readonly
                                class="form-control">
                        </div>
                    </div>

                    {{-- OVERALL PROGRESS --}}
                    <div class="text-center mt-5 mb-4">
                        <h4>OVERALL PROGRESS</h4>
                    </div>
                    <div>
                        <label for="progress_unsatisfactory" class="mb-2">Employee performance and learning is
                            unsatisfactory and is failing to
                            improve at a satisfactory rate:</label>
                        <div class="mb-3">
                            <button type="button" id="progress_unsatisfactory_btn"
                                onclick="toggleYesNo('progress_unsatisfactory')" class="btn btn-primary">Yes</button>
                        </div>
                        <input type="hidden" name="progress_unsatisfactory" id="progress_unsatisfactory" value="No">

                        <label for="comments_unsatisfactory" class="mb-2">Justify Your Review:</label>
                        <textarea name="comments_unsatisfactory" id="comments_unsatisfactory" class="form-control" rows="5"
                            cols="50"></textarea>
                    </div>

                    <div>
                        <label for="progress_acceptable" class="mb-2">Employee performance and learning is acceptable and is
                            improving at a
                            satisfactory rate:</label>
                        <div class="mb-3">
                            <button type="button" id="progress_acceptable_btn" onclick="toggleYesNo('progress_acceptable')"
                                class="btn btn-primary">Yes</button>
                        </div>

                        <input type="hidden" name="progress_acceptable" id="progress_acceptable" value="No">

                        <label for="comments_acceptable" class="mb-2">Justify Your Review:</label>
                        <textarea name="comments_acceptable" id="comments_acceptable" class="form-control" rows="5"
                            cols="50"></textarea>
                    </div>

                    <div>
                        <label for="progress_outstanding" class="mb-2">Employee has successfully demonstrated outstanding
                            overall
                            performance:</label>
                        <div class="mb-3">
                            <button type="button" id="progress_outstanding_btn"
                                onclick="toggleYesNo('progress_outstanding')" class="btn btn-primary">Yes</button>
                        </div>
                        <input type="hidden" name="progress_outstanding" id="progress_outstanding" value="No">

                        <label for="comments_outstanding" class="mb-2">Justify Your Review:</label>
                        <textarea name="comments_outstanding" id="comments_outstanding" class="form-control" rows="5"
                            cols="50"></textarea>
                    </div>



                    <!-- FINAL COMMENTS Section -->
                    {{-- <div class=" mt-4">
                        <div>
                            <label for="final_comment" class="mb-2">FINAL COMMENTS:</label>
                            <textarea name="final_comment" id="f_comment" rows="5" cols="50"
                                class="form-control"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <label for="director_name" class="mb-2">Director's Name:</label>
                                <input type="text" id="d_name" name="director_name" placeholder="Enter Name"
                                    class="form-control">
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="signatur" class="mb-2">Signature:</label>
                                <input type="file" id="signatur" name="director_signatur" placeholder="Signature"
                                    class="form-control">
                            </div>

                            <div class="col-12 col-md-4">
                                <label for="date" class="mb-2">Date:</label>
                                <input type="date" id="date" name="director_signatur_date" placeholder="Select Date"
                                    class="form-control">
                            </div>
                        </div>
                    </div> --}}

                    <div>
                        <button type="submit" class="btn btn-primary" id="evaluationSubmit">Submit</button>
                        <button type="reset" class="btn btn-primary" id="evaluationCancle">Clear</button>
                    </div>
            </form>

            {{-- <div id="confirmationDialog" title="Success" style="display:none;">
                <p id="confirmationMessage"></p>
            </div> --}}
        </div>

        {{-- otp modal --}}
        <div id="otpModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Enter OTP</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="otpForm">
                            @csrf
                            <input type="text" name="otp" class="form-control" placeholder="Enter OTP" required>
                            <button type="submit" class="btn btn-primary mt-3">Verify OTP</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>

@endsection

</html>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $.ajaxSetup({

            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });

        // Handle OTP Request
        $("#evaluationSubmit").submit(function (event) {
            event.preventDefault(); // Prevent default form submission

            let userEmail = $("#emailInput").val(); // Get email dynamically
            console.log(userEmail);

            $.ajax({
                url: "{{ route('evaluation-send-otp') }}", // Send OTP Route
                type: "POST",
                data: {
                    email: userEmail
                },
                success: function (response) {
                    console.log("OTP Sent Response:", response);
                    if (response.success) {
                        $("#otpModal").modal("show"); // Show OTP input modal
                    } else {
                        alert(response.message || "Failed to send OTP!");
                    }
                },
                error: function (xhr) {
                    console.error("OTP Request Error:", xhr.responseText);
                    alert("Something went wrong! Please try again.");
                }
            });
        });


        $("#otpForm").submit(function (event) {
            event.preventDefault();

            $.ajax({
                url: "{{ route('evaluation-verify-otp') }}", // OTP Verification Route
                type: "POST",
                data: {
                    email: "{{ session('otp_email') }}", // Ensure email is included
                    otp: $("input[name='otp']").val(),
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    console.log("OTP Verified Response:", response);
                    if (response.success) {
                        alert("OTP Verified!");
                        $("input[name='otp']").val("")
                        $("#otpModal").modal("hide");
                        submitEvaluationForm(); 
                    } else {
                        alert(response.message || "Invalid OTP!");
                    }
                },
                error: function (xhr) {
                    console.error("OTP Verification Error:", xhr.responseText);
                    alert("Enter Valid OTP! Please try again.");
                }
            });
        });

        
        $(".close").on("click", function () {
            $("#otpModal").modal("hide");
        });

        
        $("#otpModal").on("hidden.bs.modal", function () {
            $("input[name='otp']").val("");
        });


        function submitEvaluationForm() {
            let formData = new FormData($("#evaluationSubmit")[0]); 
            formData.append("email", "{{ session('otp_email') }}"); 

            console.log("Submitting Evaluation Form Data:", [...formData.entries()]); 

            $.ajax({
                url: "{{ route('insert-data-evaluation') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log("Response:", response);
                    if (response.success) {
                        alert("Evaluation submitted successfully!");
                        $("#evaluationSubmit")[0].reset();
                        window.location.href = response.redirect_url;
                    } else {
                        alert(response.message || "Failed to submit evaluation!");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", xhr.responseText);
                    console.error("Status:", status);
                    console.error("Error:", error);
                    alert("Something went wrong! Please try again.");
                }
            });
        }
    });

    //total rating of qualityworktotalrating
    function qualityWorkTotalRating() {
        var qwtotalrating1 = parseInt(document.getElementById('qw1').value) || 0;
        var qwtotalrating2 = parseInt(document.getElementById('qw2').value) || 0;
        var qwtotalrating3 = parseInt(document.getElementById('qw3').value) || 0;

        var qualityworktotalrating = qwtotalrating1 + qwtotalrating2 + qwtotalrating3;

        document.getElementById('qualityworktotalrating').value = qualityworktotalrating;
    }

    //total rating of wor habits.
    function workHabitsTotalRating() {
        var workhabitsrating1 = parseInt(document.getElementById('wh1').value) || 0;
        var workhabitsrating2 = parseInt(document.getElementById('wh2').value) || 0;
        var workhabitsrating3 = parseInt(document.getElementById('wh3').value) || 0;
        var workhabitsrating4 = parseInt(document.getElementById('wh4').value) || 0;

        var workhabitstotalrating = workhabitsrating1 + workhabitsrating2 + workhabitsrating3 + workhabitsrating4;

        document.getElementById('work_habits_rating').value = workhabitstotalrating;
    }

    //total rating  of job Knowladge
    function jobKnowledgeTotalRating() {
        var jk1 = parseInt(document.getElementById('jk1').value) || 0;
        var jk2 = parseInt(document.getElementById('jk2').value) || 0;
        var jk3 = parseInt(document.getElementById('jk3').value) || 0;

        var jkTotal = jk1 + jk2 + jk3;

        document.getElementById('jk_total_rating').value = jkTotal;
    }

    //total rating of interpersonal skill
    function interpersonalTotalRating() {
        var ir1 = parseInt(document.getElementById('ir1').value) || 0;
        var ir2 = parseInt(document.getElementById('ir2').value) || 0;
        var ir3 = parseInt(document.getElementById('ir3').value) || 0;
        var ir4 = parseInt(document.getElementById('ir4').value) || 0;
        var ir5 = parseInt(document.getElementById('ir5').value) || 0;

        var irTotal = ir1 + ir2 + ir3 + ir4 + ir5;

        document.getElementById('ir_total_rating').value = irTotal;
    }

    //leader Ship total rating
    function leadershipTotalRating() {
        var ls1 = parseInt(document.getElementById('ls1').value) || 0;
        var ls2 = parseInt(document.getElementById('ls2').value) || 0;
        var ls3 = parseInt(document.getElementById('ls3').value) || 0;

        var leadershipTotal = ls1 + ls2 + ls3;

        document.getElementById('leadership_rating').value = leadershipTotal;
    }


    function toggleYesNo(field) {
        var button = document.getElementById(field + "_btn");
        var input = document.getElementById(field);

        if (input.value === "No") {
            input.value = "Yes";
            button.innerText = "Yes";  // Corrected
        } else {
            input.value = "No";
            button.innerText = "No";  // Corrected
        }
    }






    // function calculateTotal() {
    //     let total = 0;
    //     document.querySelectorAll(".score-column").forEach(cell => {
    //         total += parseInt(cell.textContent);
    //     });
    //     document.getElementById("total-score").textContent = total;
    // }

    // // Call function on page load
    // calculateTotal();

</script>
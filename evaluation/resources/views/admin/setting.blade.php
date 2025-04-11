@extends('layouts.app')

@section('title', 'Setting')

@section('breadcrumb', 'Setting')

@section('page-title', 'Setting')

@section('content')
    <style>
        .appraisal-container {
            max-width: 400px;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        label {
            display: block;
            margin-top: 15px;
        }

        input,
        select,
        button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #007bff;
            color: white;
            margin-top: 20px;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 50%;
            margin: 15% auto;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

    <div class="appraisal-container">
        <h2>Set Appraisal Percentage</h2>

        <form id="appraisalForm">
            @csrf        
            <label for="companyPercentage">Company % for Appraisal:</label>
            <input type="number" id="companyPercentage" name="company_percentage" placeholder="Enter percentage" min="0"
                max="100" step="0.01" required>
            
            <label for="financialYear">Financial Year:</label>
            <select id="financialYear" name="financial_year" required>
                <option value="2025/2026">2025/2026</option>
                <option value="2026/2027">2026/2027</option>
                <option value="2027/2028">2027/2028</option>
                <option value="2028/2029">2028/2029</option>
            </select>
            <span>From April 1, <span id="startYear">2025</span> to March 31, <span id="endYear">2026</span>.</span>

            <button type="submit">Apply to All</button>
        </form>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('successModal')">&times;</span>
            <h2>Success</h2>
            <p>Appraisal data applied successfully to all employees.</p>
        </div>
    </div>

    <!-- Error Modal -->
    <div id="errorModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('errorModal')">&times;</span>
            <h2>Error</h2>
            <p>There was an error applying the appraisal data. Please try again later.</p>
        </div>
    </div>

    <script>
        const financialYearSelect = document.getElementById("financialYear");
        const startYear = document.getElementById("startYear");
        const endYear = document.getElementById("endYear");

        financialYearSelect.addEventListener("change", function () {
            const selectedYear = financialYearSelect.value.split('/');
            startYear.textContent = selectedYear[0];
            endYear.textContent = selectedYear[1];
        });

        document.getElementById('appraisalForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch("{{ route('submit-apprisal-all') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                console.log('Server response:', data); 
                if (data.message && data.message.includes("submitted")) {
                    openModal('successModal');
                } else {
                    openModal('errorModal');
                }
            })
            .catch(error => {
                console.error('Submission error:', error);
                openModal('errorModal');
            });
        });

        function openModal(modalId) {
            document.getElementById(modalId).style.display = "block";
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }
    </script>
@endsection

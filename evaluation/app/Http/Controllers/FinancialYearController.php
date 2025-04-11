<?php

namespace App\Http\Controllers;

use App\Models\ApprisalTable;
use App\Models\FinancialData;
use App\Models\SuperAddUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class FinancialYearController extends Controller
{
    //

    public function storeFinancialData(Request $request)
    {
        $employeeData = $request->input('employees');
        if (!$employeeData || count($employeeData) === 0) {
            return response()->json(['message' => 'No employee data provided!'], 400);
        }

        // Insert data into the financial_data table
        $dataToInsert = [];
        foreach ($employeeData as $index => $empData) {

            $employee = FinancialData::where('emp_id', $empData['emp_id'])->first();
            if ($employee) {
                $lastAppraisalDate = $employee->apprisal_date;
                $lastAppraisalYear = Carbon::parse($lastAppraisalDate)->year;
                $currentYear = Carbon::now()->year;

                if ($lastAppraisalYear === $currentYear) {
                    return response()->json([
                        'message' => 'Employee ' . $empData['employee_name'] . ', appraisal has already been done. Please wait until next year.'
                    ], 400);
                }
            }


            $dataToInsert[] = [
                'employee_name' => $empData['employee_name'] ?? null,
                'emp_id' => $empData['emp_id'],
                'hr_review' => $empData['hr_review'] ?? 0,
                'admin_review' => $empData['admin_review'] ?? 0,
                'manager_review' => $empData['manager_review'] ?? 0,
                'clint_review' => $empData['clint_review'] ?? 0,
                'apprisal_score' => $empData['apprisal_score'] ?? 0,
                'current_salary' => $empData['current_salary'] ?? 0,
                'percentage_given' => $empData['percentage_given'] ?? 0,
                'update_salary' => $empData['update_salary'] ?? 0,
                'final_salary' => $empData['final_salary'] ?? 0,
                'apprisal_date' => $empData['apprisal_date'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }


        // Insert all data in one query
        FinancialData::insert($dataToInsert);

        return response()->json(['message' => 'Financial data saved successfully!']);
    }


    public function financialTableView(Request $request)
    {

        $financialData = FinancialData::join('super_add_users', 'financial_data.emp_id', '=', 'super_add_users.employee_id')
            ->where('super_add_users.status', 1)
            ->get(['financial_data.*', 'super_add_users.fname', 'super_add_users.lname']); // You can add more fields if needed

        return view('admin.FinancialTable', compact('financialData'));
    }



    public function searchEmployee(Request $request)
    {

        $query = $request->input('query');
        $searchType = $request->input('type');


        if (empty($query) || empty($searchType)) {
            return response()->json(['error' => 'Invalid search parameters.'], 400);
        }


        $queryBuilder = FinancialData::join('super_add_users', 'financial_data.emp_id', '=', 'super_add_users.employee_id');

        if ($searchType === 'id') {

            $financialData = $queryBuilder->where('super_add_users.employee_id', $query)
                ->get(['financial_data.*', 'super_add_users.fname', 'super_add_users.lname']);
        } elseif ($searchType === 'name') {

            $financialData = $queryBuilder->where(function ($subQuery) use ($query) {
                $subQuery->whereRaw("CONCAT(super_add_users.fname, ' ', super_add_users.lname) LIKE ?", ['%' . $query . '%']);
            })->get(['financial_data.*', 'super_add_users.fname', 'super_add_users.lname']);
        } else {

            return response()->json(['error' => 'Invalid search type.'], 400);
        }


        return response()->json(['financialData' => $financialData]);
    }



    //View Setting 
    public function getSettingView(Request $request)
    {
        return view('admin.setting');
    }

    // public function setApprisalPercentage(Request $request)
    // {

    //     $data = [
    //         'financial_year' => $request->input('financial_year'),
    //         'company_percentage' => $request->input('company_percentage'),
    //     ];

    //     ApprisalTable::create($data);
    //     return response()->json(['message' => 'Data Save Successfully']);
    // }



    public function setApprisalPercentage(Request $request)
    {
        $request->validate([
            'financial_year' => 'required|string',
            'company_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $financialYear = $request->input('financial_year');

        // Check if a record already exists for this financial year
        $existing = ApprisalTable::where('financial_year', $financialYear)->first();

        if ($existing) {
            return response()->json([
                'message' => 'Data already exists for this financial year',
                'status' => 'duplicate'
            ]);
        }

        // If not exists, create new
        $data = [
            'financial_year' => $financialYear,
            'company_percentage' => $request->input('company_percentage'),
        ];

        ApprisalTable::create($data);

        return response()->json([
            'message' => 'Data submitted successfully',
            'status' => 'success'
        ]);
    }
}

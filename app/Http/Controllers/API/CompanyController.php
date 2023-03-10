<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    //powerhuan.com/api/company?id=1
    public function all(Request $request)
    {
        $id = $request->input('id');
        //powerhuman.com/api/company?id=1
        $name = $request->input('name');
        $limit = $request->input('limit', 10);

        if ($id) {
            $company = Company::with(['users'])->find($id);
            if ($company) {
                return ResponseFormatter::success($company, 'Company found');
            }
            return ResponseFormatter::error('Company not found', 404);
        }

        //powerhuman.com/api/company
        $companies = Company::with(['users']);
        //powerhuman.com/api/company?name=kunde
        if ($name) {
            $companies->where('name', 'like', '%' . $name . '%');
        }
        return ResponseFormatter::success($companies->paginate($limit), 'Companies found');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function showList() {
        $model = new Company();
        $companies = $model->getList();
    
        return view('companies.list', ['companies' => $companies]);
    }
}

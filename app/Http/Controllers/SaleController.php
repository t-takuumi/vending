<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;

class SaleController extends Controller
{
    public function showList() {
        $model = new Sale();
        $sales = $model->getList();
    
        return view('sales.list', ['sales' => $sales]);
    }
}

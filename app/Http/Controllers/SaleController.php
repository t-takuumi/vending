<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function purchase(Request $request){
        
        $productId = $request->input('product_id');

        $saleModel = new Sale();
        $result =  $saleModel->validateProduct($productId);

        if (isset($result['error'])) {
            return response()->json(['error' => $result['error']], 400);
        }
        $product = $result['product'];

        DB::beginTransaction();
        try {
            $saleModel->insertSale($productId);
            $saleModel->updateProductStock($product);
    
            DB::commit();
            return response()->json(['message' => '購入完了'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => '購入処理失敗'], 500);
        }
    }
}
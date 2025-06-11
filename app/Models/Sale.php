<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{ 
    public function validateProduct($productId) {
        $product = DB::table('products')
            ->where('id', $productId)
            ->first();

        if (!$product) {
            return ['error' => '商品が見つかりません'];
        }
    
        if ($product->stock <= 0) {
            return ['error' => '在庫がありません'];
        }

        return ['product' => $product];

    }

    
    public function insertSale($productId) {
        DB::table('sales')->insert([
            'product_id' => $productId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function updateProductStock($product) {
        DB::table('products')->where('id', $product->id)->update([
            'stock' => $product->stock - 1,
            'updated_at' => now(),
        ]);
    }
}

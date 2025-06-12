<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    public function indexGetList($keyword, $maker, $priceMin, $priceMax, $stockMin, $stockMax) {
        $query = DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->select(
                'products.*',
                'companies.company_name'
            );

        if (!empty($keyword)) {
            $query->where('products.product_name', 'like', '%' . $keyword . '%');
        }

        if (!empty($maker)) {
            $query->where('companies.company_name', 'like', '%' . $maker . '%');
        }

        if (!is_null($priceMin)) {
            $query->where('products.price', '>=', $priceMin);
        }
    
        if (!is_null($priceMax)) {
            $query->where('products.price', '<=', $priceMax);
        }
    
        if (!is_null($stockMin)) {
            $query->where('products.stock', '>=', $stockMin);
        }
    
        if (!is_null($stockMax)) {
            $query->where('products.stock', '<=', $stockMax);
        }

        return $query->get();
    }
    
    public function showGetList($id) {
        $product = DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->select(
                'products.*',
                'companies.company_name'
            )
            ->where('products.id', $id)
            ->first(); 
        
        if (!$product) {
                abort(404); 
        }
        return $product;
    }

    public function editGetList($id) {
        $product = DB::table('products')
            ->where('id', $id)
            ->first();

        if (!$product) {
            abort(404); 
        }
        return $product;
    }


    public function destroyGetList($id) {
        $product = DB::table('products')
            ->where('id', $id)
            ->first();
        
        if (!$product) {
            abort(404);
        }
        
        DB::table('products')->where('id', $id)->delete();
    }


    public function productArticle($request,$img_path) {
        DB::table('products')->insert([
            'product_name' => $request->input('product_name'),
            'company_id' => $request->input('company_id'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'img_path' => $img_path,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function productUpdateArticle($request, $id, $img_path) {
        DB::table('products')->where('id', $id)->update([
            'product_name' => $request->input('product_name'),
            'company_id' => $request->input('company_id'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'img_path' => $img_path,
            'comment' => $request->input('comment'),
            'updated_at' => now(),
        ]);
    }

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

    public function updateProductStock($product) {
        DB::table('products')->where('id', $product->id)->update([
            'stock' => $product->stock - 1,
            'updated_at' => now(),
        ]);
    }
}


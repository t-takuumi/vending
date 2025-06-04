<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    public function indexGetList($keyword, $maker) {
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
}


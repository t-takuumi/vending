<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    public function getList() {
        return DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->select(
                'products.*',
                'companies.company_name'
            )
            ->get();
    }
    
        public function company() {
        return $this->belongsTo(Company::class);
    }

    public function productArticle($request,$img_path) {
        // 登録処理
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


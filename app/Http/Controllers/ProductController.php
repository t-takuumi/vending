<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\productRequest;

class ProductController extends Controller
{
    public function index(Request $request){
        $keyword = $request->input('keyword');
        $maker = $request->input('maker');

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

        $products = $query->get();

        return view('products.index', ['products' => $products]);
    }

    public function show($id) {
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
    
        return view('products.show', ['product' => $product]);
    }

    public function edit($id) {
        $product = DB::table('products')
            ->where('id', $id)
            ->first();
    
        if (!$product) {
            abort(404); 
        }

        $companies = DB::table('companies')->get(); 

        return view('products.edit', [
            'product' => $product,
            'companies' => $companies, 
        ]);
    }

    public function destroy($id) {
        $product = DB::table('products')->where('id', $id)->first();
    
        if (!$product) {
            abort(404);
        }
    
        DB::table('products')->where('id', $id)->delete();
    
        return redirect()->route('products.index')->with('success', '商品を削除しました');
    }

    public function create() {
        $companies = DB::table('companies')->get(); 
        return view('products.create', ['companies' => $companies]);
    }

    public function productSubmit(ProductRequest $request) {

        $img = $request->file('img_path');
        $img_path = null;
    
        if ($img !== null) {
            $file_name = $img->getClientOriginalName();
            $img->storeAs('public/imgs', $file_name);
            $img_path = 'imgs/' . $file_name;
        }

        DB::beginTransaction();
    
        try {
            $model = new Product();
            $model->productArticle($request,$img_path);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return back();
        }

        return redirect()->route('products.index')->with('success', '商品を登録しました');
    }

    public function update(ProductRequest $request, $id) {

        $img = $request->file('img_path');
        $img_path = null;
    
        if ($img !== null) {
            $file_name = $img->getClientOriginalName();
            $img->storeAs('public/imgs', $file_name);
            $img_path = 'imgs/' . $file_name;
        }

        DB::beginTransaction();
    
        try {
            $model = new Product();
            $model->productUpdateArticle($request,$id, $img_path);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return back();
        }
        return redirect()->route('products.index')->with('success', '商品を更新しました');
    }

}


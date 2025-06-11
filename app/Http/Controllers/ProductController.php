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
        $priceMin  = $request->input('price_min');
        $priceMax  = $request->input('price_max');
        $stockMin  = $request->input('stock_min');
        $stockMax  = $request->input('stock_max');

        $ProductModel = new Product();
        $products = $ProductModel->indexGetList($keyword, $maker, $priceMin, $priceMax, $stockMin, $stockMax);
        $CompanyModel = new Company();
        $companies = $CompanyModel->getList();

            // 通常リクエスト or Ajax判定
        if ($request->ajax()) {
            $html = view('products.table', compact('products'))->render();
            return response()->json(['html' => $html]);
        }

        return view('products.index', [
            'products' => $products,
            'companies' => $companies, 
        ]);
    }

    public function show($id) {
        $ProductModel = new Product();
        $product = $ProductModel->showGetList($id);

        return view('products.show', ['product' => $product]);
    }

    public function edit($id) {
        $ProductModel = new Product();
        $product = $ProductModel->editGetList($id);
        $CompanyModel = new Company();
        $companies = $CompanyModel->getList();

        return view('products.edit', [
            'product' => $product,
            'companies' => $companies, 
        ]);
    }

    public function destroy($id) {
        DB::beginTransaction();

        try {
            $ProductModel = new Product();
            $ProductModel->destroyGetList($id);
            DB::commit();

            if (request()->ajax()) {
                return response()->json(['success' => true]);
            }
            
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return back();
        }

        return redirect()->route('products.index')->with('success', '商品を削除しました');
    }

    public function create() {
        $CompanyModel = new Company();
        $companies = $CompanyModel->getList();
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


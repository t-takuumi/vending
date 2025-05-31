@extends('layouts.app')

@section('content')
<h2>商品新規登録画面</h2>

<form action="{{ route('submit') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="product_name">商品名</label>
        <input type="text" class="form-control" id="product_name" name="product_name" placeholder="商品名">
        @if($errors->has('product_name'))
            <p>{{ $errors->first('product_name') }}</p>
        @endif
    </div>

    <select name="company_id">
        @foreach ($companies as $company)
            <option value="{{ $company->id }}">{{ $company->company_name }}</option>
        @endforeach
        @if($errors->has('company_id'))
            <p>{{ $errors->first('company_id') }}</p>
        @endif
    </select>

    <div class="form-group">
        <label for="price">価格</label>
        <input type="text" class="form-control" id="price" name="price" placeholder="価格">
        @if($errors->has('price'))
            <p>{{ $errors->first('price') }}</p>
        @endif
    </div>

    <div class="form-group">
        <label for="stock">在庫数</label>
        <input type="text" class="form-control" id="stock" name="stock" placeholder="在庫数">
        @if($errors->has('stock'))
            <p>{{ $errors->first('stock') }}</p>
        @endif
    </div>

    <div class="form-group">
        <label for="comment">コメント</label>
        <input type="text" class="form-control" id="comment" name="comment" placeholder="コメント">
    </div>

    <div class="form-group">
        <label for="img_path">商品画像</label>
        <input type="file" class="form-control" id="img_path" name="img_path" placeholder="商品画像">
    </div>

    <button type="submit" class="btn btn-warning">新規登録</button>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>

</form>
@endsection

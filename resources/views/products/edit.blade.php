@extends('layouts.app')

@section('content')
<h2>商品情報編集画面</h2>

<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div>
        <label>ID:</label>{{ $product->id }}
    </div>

    <div>
        <label>商品名 <span style="color:red;">*</span></label>
        <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}">
        @if($errors->has('product_name'))
            <p>{{ $errors->first('product_name') }}</p>
        @endif
    </div>

    <div>
        <label>メーカー名 <span style="color:red;">*</span></label>
        <select name="company_id">
            @foreach ($companies as $company)
                <option value="{{ $company->id }}" {{ $company->id == $product->company_id ? 'selected' : '' }}>
                    {{ $company->company_name }}
                </option>
            @endforeach
            @if($errors->has('company_id'))
            <p>{{ $errors->first('company_id') }}</p>
            @endif
        </select>
    </div>

    <div>
        <label>価格 <span style="color:red;">*</span></label>
        <input type="number" name="price" value="{{ old('price', $product->price) }}">
        @if($errors->has('price'))
            <p>{{ $errors->first('price') }}</p>
        @endif
    </div>

    <div>
        <label>在庫数 <span style="color:red;">*</span></label>
        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}">
        @if($errors->has('stock'))
            <p>{{ $errors->first('stock') }}</p>
        @endif
    </div>

    <div>
        <label>コメント:</label><br>
        <textarea name="comment">{{ old('comment', $product->comment) }}</textarea>
    </div>

    <div>
        <label>画像変更:</label>
        <input type="file" name="img_path">
    </div>

    <button type="submit" class="btn btn-warning">更新</button>
    <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary">戻る</a>
</form>
@endsection


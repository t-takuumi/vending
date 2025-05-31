@extends('layouts.app')

@section('content')
    <h2>商品情報詳細画面</h2>

    <p><strong>ID:</strong> {{ $product->id }}</p>
    <p><strong>商品画像:</strong>
        <img src="{{ asset('storage/' . $product->img_path) }}" alt="商品画像" width="200">
    </p>
    <p><strong>商品名:</strong> {{ $product->product_name }}</p>
    <p><strong>メーカー:</strong> {{ $product->company_name ?? '不明' }}</p>
    <p><strong>価格:</strong> ￥{{ $product->price }}</p>
    <p><strong>在庫数:</strong> {{ $product->stock }}</p>
    <p><strong>コメント:</strong> {{ $product->comment ?? 'なし' }}</p>

    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">編集</a>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
@endsection

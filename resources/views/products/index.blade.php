@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品一覧画面</h1>

    <form method="GET" action="{{ route('products.index') }}">
        <input type="text" name="keyword" placeholder="商品名で検索" value="{{ request('keyword') }}">
        <select name="maker">
            <option value="">-- メーカーを選択 --</option>
            @foreach($companies as $company)
                <option value="{{ $company->company_name }}" {{ request('maker') == $company->company_name ? 'selected' : '' }}>
                    {{ $company->company_name }}
                </option>
            @endforeach
        </select>
        <button type="submit">検索</button>
    </form>

    <a href="{{ route('products.create') }}" class="btn btn-warning">新規登録</a>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>メーカー名</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{$product->id}}</td>
                    <td>
                        @if($product->img_path)
                            <img src="{{ asset('storage/' . $product->img_path) }}" alt="商品画像" style="max-width: 100px;">
                        @else
                            画像なし
                        @endif
                    </td>
                    <td>{{$product->product_name}}</td>
                    <td>{{$product->price}}</td>
                    <td>{{$product->stock}}</td>
                    <td>{{$product->company_name}}</td>
                    <td>
                        {{-- 詳細ボタン --}}
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">詳細</a>

                        {{-- 削除ボタン --}}
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか？')">削除</button>
                        </form>
                     </td>
                </tr>
            @endforeach
        </tbody>


    </table>

</div>
@endsection

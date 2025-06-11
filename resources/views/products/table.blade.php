<table id="product-list-table" class="tablesorter">
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
                <tr id="product-row-{{ $product->id }}">
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
                        <button type="button" class="btn btn-danger delete-button" data-id="{{ $product->id }}">削除</button>
                     </td>
                </tr>
            @endforeach
        </tbody>
    </table>

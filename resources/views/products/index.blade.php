@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品一覧画面</h1>

    <form id="search-form">
        <label>商品名</label>
        <input type="text" name="keyword" placeholder="商品名で検索" value="{{ request('keyword') }}">
        <br>
        <label>メーカー名</label>
        <select name="maker">
            <option value="">-- メーカーを選択 --</option>
            @foreach($companies as $company)
                <option value="{{ $company->company_name }}" {{ request('maker') == $company->company_name ? 'selected' : '' }}>
                    {{ $company->company_name }}
                </option>
            @endforeach
        </select>
        <br>
        <!-- 価格検索 -->
        <label>価格:</label>
        <input type="number" name="price_min" placeholder="下限" value="{{ request('price_min') }}">
        〜
        <input type="number" name="price_max" placeholder="上限" value="{{ request('price_max') }}">

        <br>
        <!-- 在庫検索 -->
        <label>在庫数:</label>
        <input type="number" name="stock_min" placeholder="下限" value="{{ request('stock_min') }}">
        〜
        <input type="number" name="stock_max" placeholder="上限" value="{{ request('stock_max') }}">
        <button type="submit">検索</button>
    </form>

    <a href="{{ route('products.create') }}" class="btn btn-warning">新規登録</a>

    <div id="product-table">
        @include('products.table' , ['products' => $products])
    </div>

    <script>
    $(function () {
        $('#search-form').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('products.index') }}",
                type: 'GET',
                data: $(this).serialize(),
                success: function (response) {
                    $('#product-table').html(response.html);
                },
                error: function () {
                    alert('検索に失敗しました');
                }
            });
        });
    });
    </script>
    <script>
    $(document).on('click', '.delete-button', function () {
        if (!confirm('本当に削除しますか？')) return;

        let productId = $(this).data('id');

        $.ajax({
            url: `/products/${productId}`,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                $(`#product-row-${productId}`).remove();
            },
            error: function () {
                alert('削除に失敗しました。');
            }
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        $("#product-list-table").tablesorter({
            sortList: [[0,1]]  // 0列目（ID）を降順（1）で初期ソート
        });
    });
    </script>

</div>
@endsection

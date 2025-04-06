<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    @extends('layout.AdminLayout')
    @section('content')
        <div class="container">
            <h1> {{ $title }} </h1>
            <div class="table-responsive">
                <table class="table table-primary">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">NAME PRODUCT</th>
                            <th scope="col">PRICE</th>
                            <th scope="col">QUANTITY</th>
                            <th scope="col">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productList as $product)
                            <tr class="table-light">
                                <td class="fw-bold">{{ $product->id }}</td>
                                <td class="text-primary">{{ $product->name_product }}</td>
                                <td class="text-success fw-bold">{{ number_format($product->price) }} VND</td>
                                <<td class="text-success fw-bold">{{ number_format($product->quantity) }} VND</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-success"><i class="fas fa-plus"></i> Thêm</a>
                                    <a href="#" class="btn btn-sm btn-primary">Sửa</a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endsection

   
</body>

</html>

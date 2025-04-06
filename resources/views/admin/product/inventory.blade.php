@extends('layout.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Quản lý kho sản phẩm</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên sản phẩm</th>
                                <th>Danh mục</th>
                                <th>Số lượng</th>
                                <th>Giá nhập</th>
                                <th>Giá bán</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>iPhone 13</td>
                                <td>Điện thoại</td>
                                <td>50</td>
                                <td>20,000,000</td>
                                <td>25,000,000</td>
                                <td><span class="badge bg-success">Còn hàng</span></td>
                                <td>
                                    <button class="btn btn-primary btn-sm">Nhập hàng</button>
                                    <button class="btn btn-info btn-sm">Chi tiết</button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Macbook Pro</td>
                                <td>Laptop</td>
                                <td>30</td>
                                <td>35,000,000</td>
                                <td>40,000,000</td>
                                <td><span class="badge bg-warning">Sắp hết</span></td>
                                <td>
                                    <button class="btn btn-primary btn-sm">Nhập hàng</button>
                                    <button class="btn btn-info btn-sm">Chi tiết</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
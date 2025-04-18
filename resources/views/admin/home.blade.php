@extends('layout.AdminLayout')

@section('content')
{{-- @if(auth()->check())
    <div class="alert alert-info">
        Current user role: {{ auth()->user()->role }}
    </div>
@endif --}}
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Dashboard</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>150</h3>
                                    <p>Tổng số sản phẩm</p>
                                </div>
                                <div class="icon">
                                    <i class="bi bi-box-seam"></i>
                                </div>
                                <a href="{{ route('admin.products.index') }}" class="small-box-footer">
                                    Xem chi tiết <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>53</h3>
                                    <p>Tổng số danh mục</p>
                                </div>
                                <div class="icon">
                                    <i class="bi bi-tags"></i>
                                </div>
                                <a href="{{ route('admin.categories.index') }}" class="small-box-footer">
                                    Xem chi tiết <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>44</h3>
                                    <p>Tổng số người dùng</p>
                                </div>
                                <div class="icon">
                                    <i class="bi bi-people"></i>
                                </div>
                                <a href="{{ route('admin.users.index') }}" class="small-box-footer">
                                    Xem chi tiết <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>65</h3>
                                    <p>Tổng doanh thu</p>
                                </div>
                                <div class="icon">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                                <a href="{{ route('admin.statistics.sales') }}" class="small-box-footer">
                                    Xem chi tiết <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

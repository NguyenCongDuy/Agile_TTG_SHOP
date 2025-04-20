@extends('layout.AdminLayout')

@section('content')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/admin-charts.js') }}"></script>
@endpush
{{-- @if(auth()->check())
    <div class="alert alert-info">
        Current user role: {{ auth()->user()->role }}
    </div>
@endif --}}
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <div class="app-content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-primary elevation-1"><i class="bi bi-box-seam"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Products</span>
                            <span class="info-box-number">{{ $totalProducts ?? 150 }}</span>
                            <div class="progress">
                                <div class="progress-bar bg-primary" style="width: 70%"></div>
                            </div>
                            <span class="progress-description">70% of inventory capacity</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="bi bi-cart-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Orders</span>
                            <span class="info-box-number">{{ $totalOrders ?? 53 }}</span>
                            <div class="progress">
                                <div class="progress-bar bg-success" style="width: 50%"></div>
                            </div>
                            <span class="progress-description">50% increase this month</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="bi bi-people"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Customers</span>
                            <span class="info-box-number">{{ $totalUsers ?? 44 }}</span>
                            <div class="progress">
                                <div class="progress-bar bg-warning" style="width: 60%"></div>
                            </div>
                            <span class="progress-description">60% active in last 30 days</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="bi bi-currency-dollar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Revenue</span>
                            <span class="info-box-number">${{ number_format($totalRevenue ?? 15000, 2) }}</span>
                            <div class="progress">
                                <div class="progress-bar bg-danger" style="width: 80%"></div>
                            </div>
                            <span class="progress-description">80% of monthly target</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <div class="col-md-8">
                    <!-- Sales Chart -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Sales Overview</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                    <i class="bi bi-dash-lg"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <p class="d-flex flex-column">
                                    <span class="fw-bold fs-5">${{ number_format($totalRevenue ?? 15000, 2) }}</span>
                                    <span>Total Revenue</span>
                                </p>
                                <p class="d-flex flex-column text-end">
                                    <span class="text-success">
                                        <i class="bi bi-arrow-up"></i> 12.5%
                                    </span>
                                    <span class="text-muted">Since last month</span>
                                </p>
                            </div>
                            <div class="position-relative mb-4">
                                <canvas id="sales-chart" height="300"></canvas>
                            </div>
                            <div class="d-flex flex-row justify-content-end">
                                <span class="me-2">
                                    <i class="bi bi-circle-fill text-primary"></i> This Year
                                </span>
                                <span>
                                    <i class="bi bi-circle-fill text-gray"></i> Last Year
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    <div class="card mb-4">
                        <div class="card-header border-0">
                            <h3 class="card-title">Recent Orders</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-tool btn-sm">
                                    <i class="bi bi-list"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-striped table-valign-middle">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#ORD-2023-001</td>
                                        <td>John Doe</td>
                                        <td><span class="badge bg-success">Completed</span></td>
                                        <td>$250.00</td>
                                        <td>2023-05-15</td>
                                        <td>
                                            <a href="#" class="text-muted">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#ORD-2023-002</td>
                                        <td>Jane Smith</td>
                                        <td><span class="badge bg-warning">Processing</span></td>
                                        <td>$125.50</td>
                                        <td>2023-05-14</td>
                                        <td>
                                            <a href="#" class="text-muted">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#ORD-2023-003</td>
                                        <td>Robert Johnson</td>
                                        <td><span class="badge bg-info">Shipped</span></td>
                                        <td>$543.20</td>
                                        <td>2023-05-13</td>
                                        <td>
                                            <a href="#" class="text-muted">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#ORD-2023-004</td>
                                        <td>Emily Davis</td>
                                        <td><span class="badge bg-danger">Cancelled</span></td>
                                        <td>$75.00</td>
                                        <td>2023-05-12</td>
                                        <td>
                                            <a href="#" class="text-muted">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#ORD-2023-005</td>
                                        <td>Michael Brown</td>
                                        <td><span class="badge bg-success">Completed</span></td>
                                        <td>$325.75</td>
                                        <td>2023-05-11</td>
                                        <td>
                                            <a href="#" class="text-muted">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right col -->
                <div class="col-md-4">
                    <!-- Product Categories Pie Chart -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Product Categories</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                    <i class="bi bi-dash-lg"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="position-relative mb-4">
                                <canvas id="categories-chart" height="200"></canvas>
                            </div>
                            <div class="d-flex flex-row justify-content-center">
                                <span class="me-2">
                                    <i class="bi bi-circle-fill text-primary"></i> Electronics
                                </span>
                                <span class="me-2">
                                    <i class="bi bi-circle-fill text-success"></i> Clothing
                                </span>
                                <span>
                                    <i class="bi bi-circle-fill text-warning"></i> Others
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Top Selling Products -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Top Selling Products</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                    <i class="bi bi-dash-lg"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img src="https://images.unsplash.com/photo-1560343090-f0409e92791a?q=80&w=1964&auto=format&fit=crop" alt="Product 1" class="me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-0">Smartphone X Pro</h6>
                                            <small class="text-muted">Electronics</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">250 sold</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=2070&auto=format&fit=crop" alt="Product 2" class="me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-0">Running Shoes</h6>
                                            <small class="text-muted">Footwear</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">180 sold</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=1999&auto=format&fit=crop" alt="Product 3" class="me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-0">Smart Watch</h6>
                                            <small class="text-muted">Electronics</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">120 sold</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img src="https://images.unsplash.com/photo-1434389677669-e08b4cac3105?q=80&w=2005&auto=format&fit=crop" alt="Product 4" class="me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-0">Cotton T-Shirt</h6>
                                            <small class="text-muted">Clothing</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">95 sold</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img src="https://images.unsplash.com/photo-1491553895911-0055eca6402d?q=80&w=2080&auto=format&fit=crop" alt="Product 5" class="me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-0">Wireless Headphones</h6>
                                            <small class="text-muted">Electronics</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">85 sold</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Customer Acquisition -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Customer Acquisition</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                    <i class="bi bi-dash-lg"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <p class="text-center">
                                    <strong>Goal Completion</strong>
                                </p>
                            </div>
                            <div class="progress-group mb-4">
                                <span class="progress-text">Online Store Visits</span>
                                <span class="float-end"><b>8,100</b>/10,000</span>
                                <div class="progress">
                                    <div class="progress-bar bg-primary" style="width: 81%"></div>
                                </div>
                            </div>
                            <div class="progress-group mb-4">
                                <span class="progress-text">Completed Purchases</span>
                                <span class="float-end"><b>620</b>/1,000</span>
                                <div class="progress">
                                    <div class="progress-bar bg-success" style="width: 62%"></div>
                                </div>
                            </div>
                            <div class="progress-group mb-4">
                                <span class="progress-text">Email Subscribers</span>
                                <span class="float-end"><b>450</b>/500</span>
                                <div class="progress">
                                    <div class="progress-bar bg-warning" style="width: 90%"></div>
                                </div>
                            </div>
                            <div class="progress-group mb-4">
                                <span class="progress-text">Social Media Followers</span>
                                <span class="float-end"><b>2,200</b>/3,000</span>
                                <div class="progress">
                                    <div class="progress-bar bg-info" style="width: 73%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

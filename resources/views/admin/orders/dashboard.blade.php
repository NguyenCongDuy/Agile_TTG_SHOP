@extends('layout.AdminLayout')

@section('content')
<div class="app-main__inner">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Tổng quan đơn hàng</h1>
            <p class="text-muted">Thống kê và phân tích đơn hàng trong hệ thống</p>
        </div>
        <div>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">
                <i class="bi bi-list-ul me-1"></i> Danh sách đơn hàng
            </a>
        </div>
    </div>

    <!-- Order Statistics -->
    <div class="row">
        <!-- Total Orders -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-primary fw-bold text-uppercase mb-1">Tổng đơn hàng</h6>
                            <h2 class="mb-0 fw-bold">{{ $totalOrders }}</h2>
                            <div class="text-muted small mt-2">Tất cả đơn hàng trong hệ thống</div>
                        </div>
                        <div class="icon-circle bg-primary text-white">
                            <i class="bi bi-cart3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-warning fw-bold text-uppercase mb-1">Đơn hàng chờ xử lý</h6>
                            <h2 class="mb-0 fw-bold">{{ $pendingOrders }}</h2>
                            <div class="text-muted small mt-2">Đơn hàng đang chờ xử lý</div>
                        </div>
                        <div class="icon-circle bg-warning text-white">
                            <i class="bi bi-clock-history"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Processing Orders -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-info fw-bold text-uppercase mb-1">Đơn hàng đang xử lý</h6>
                            <h2 class="mb-0 fw-bold">{{ $processingOrders }}</h2>
                            <div class="text-muted small mt-2">Đơn hàng đang được xử lý</div>
                        </div>
                        <div class="icon-circle bg-info text-white">
                            <i class="bi bi-gear"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Orders -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-success fw-bold text-uppercase mb-1">Đơn hàng hoàn thành</h6>
                            <h2 class="mb-0 fw-bold">{{ $completedOrders }}</h2>
                            <div class="text-muted small mt-2">Đơn hàng đã hoàn thành</div>
                        </div>
                        <div class="icon-circle bg-success text-white">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Statistics -->
    <div class="row">
        <!-- Total Revenue -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-success fw-bold text-uppercase mb-1">Tổng doanh thu</h6>
                            <h2 class="mb-0 fw-bold text-success">{{ number_format($totalRevenue) }}đ</h2>
                            <div class="text-muted small mt-2">Tổng doanh thu từ tất cả đơn hàng</div>
                        </div>
                        <div class="icon-circle bg-success text-white">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paid Revenue -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-info fw-bold text-uppercase mb-1">Doanh thu đã thanh toán</h6>
                            <h2 class="mb-0 fw-bold text-info">{{ number_format($paidRevenue) }}đ</h2>
                            <div class="text-muted small mt-2">Doanh thu từ đơn hàng đã thanh toán</div>
                        </div>
                        <div class="icon-circle bg-info text-white">
                            <i class="bi bi-cash-coin"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Chart -->
    {{-- <div class="card shadow mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-primary"><i class="bi bi-graph-up me-2"></i>Biểu đồ đơn hàng</h5>
            <div>
                <select id="chartPeriod" class="form-select form-select-sm">
                    <option value="week">7 ngày qua</option>
                    <option value="month" selected>30 ngày qua</option>
                    <option value="year">Năm nay</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <div id="orderChart" style="height: 300px;"></div>
        </div>
    </div> --}}

    <!-- Recent Orders -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-primary"><i class="bi bi-clock-history me-2"></i>Đơn hàng gần đây</h5>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-list-ul me-1"></i> Xem tất cả
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                            <tr>
                                <td><strong class="text-primary">#{{ $order->id }}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm bg-light rounded-circle me-2">
                                            <span class="avatar-text">{{ substr($order->user->name, 0, 1) }}</span>
                                        </div>
                                        <div>{{ $order->user->name }}</div>
                                    </div>
                                </td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td><strong class="text-success">{{ number_format($order->total_amount) }}đ</strong></td>
                                <td>
                                    <span class="badge bg-{{ $order->status == 'completed' ? 'success' :
                                        ($order->status == 'processing' ? 'info' :
                                        ($order->status == 'cancelled' ? 'danger' : 'warning')) }}">
                                        {{ $order->status == 'completed' ? 'Hoàn thành' :
                                           ($order->status == 'processing' ? 'Đang xử lý' :
                                           ($order->status == 'cancelled' ? 'Đã hủy' : 'Chờ xử lý')) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    .avatar-sm {
        width: 35px;
        height: 35px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
$(document).ready(function() {
    // Sample data for the chart - in a real app, this would come from the backend
    const orderData = {
        week: {
            dates: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            orders: [5, 7, 10, 8, 12, 15, 9],
            revenue: [250000, 350000, 500000, 400000, 600000, 750000, 450000]
        },
        month: {
            dates: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            orders: [30, 42, 35, 50],
            revenue: [1500000, 2100000, 1750000, 2500000]
        },
        year: {
            dates: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            orders: [120, 150, 180, 210, 190, 240, 230, 250, 260, 280, 300, 320],
            revenue: [6000000, 7500000, 9000000, 10500000, 9500000, 12000000, 11500000, 12500000, 13000000, 14000000, 15000000, 16000000]
        }
    };

    // Initialize chart
    function initChart(period) {
        const data = orderData[period];

        const options = {
            series: [{
                name: 'Đơn hàng',
                type: 'column',
                data: data.orders
            }, {
                name: 'Doanh thu',
                type: 'line',
                data: data.revenue
            }],
            chart: {
                height: 300,
                type: 'line',
                toolbar: {
                    show: false
                }
            },
            stroke: {
                width: [0, 4]
            },
            dataLabels: {
                enabled: false,
                enabledOnSeries: [1]
            },
            labels: data.dates,
            xaxis: {
                type: 'category'
            },
            yaxis: [{
                title: {
                    text: 'Số đơn hàng',
                },
            }, {
                opposite: true,
                title: {
                    text: 'Doanh thu'
                },
                labels: {
                    formatter: function(val) {
                        return val.toLocaleString() + 'đ';
                    }
                }
            }],
            colors: ['#4e73df', '#1cc88a']
        };

        const chart = new ApexCharts(document.querySelector("#orderChart"), options);
        chart.render();

        return chart;
    }

    let chart = initChart('month');

    // Handle period change
    $('#chartPeriod').change(function() {
        const period = $(this).val();
        chart.destroy();
        chart = initChart(period);
    });
});
</script>
@endpush
</div>
@endsection

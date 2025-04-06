@extends('layout.AdminLayout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thống kê sản phẩm</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="chart">
                                <canvas id="productsChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Danh mục</th>
                                            <th>Số lượng sản phẩm</th>
                                            <th>Tỷ lệ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Điện thoại</td>
                                            <td>50</td>
                                            <td>33%</td>
                                        </tr>
                                        <tr>
                                            <td>Laptop</td>
                                            <td>30</td>
                                            <td>20%</td>
                                        </tr>
                                        <tr>
                                            <td>Phụ kiện</td>
                                            <td>70</td>
                                            <td>47%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Products Chart
    var productsChart = new Chart(document.getElementById('productsChart'), {
        type: 'pie',
        data: {
            labels: ['Điện thoại', 'Laptop', 'Phụ kiện'],
            datasets: [{
                data: [50, 30, 70],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                ]
            }]
        },
        options: {
            responsive: true
        }
    });
</script>
@endpush 
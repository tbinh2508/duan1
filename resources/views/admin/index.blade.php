@extends('admin.layouts.master')
@section('title')
    Admin
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Doanh thu tháng {{ now()->month }} </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ number_format($total_price_month->total) }} VND</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Doanh thu năm {{ now()->year }}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ number_format($total_price_year->total) }} VND</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Trung bình mỗi đơn hàng
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ number_format($avg_total->total ?? 0) }} VND</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body text-center">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Hoàn tất</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count_success->count ?? 0}}</div>
                            </div>
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Đang xử lý </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count_warning->count ?? 0}}</div>
                            </div>
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Đã hủy</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count_canceled->count ?? 0}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->

        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Doanh thu 12 tháng năm {{ now()->year }}</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="myAreaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Nguồn doanh thu</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="myPieChart"></canvas>
                        </div>

                        <!-- Căn chỉnh các phần tử theo chiều ngang -->
                        <div class="mt-1 text-center small d-flex justify-content-center">
                            <span class="mr-4">
                                <span>{{ number_format($payment_deliver->total ?? 0) }} VND</span>
                            </span>
                            <span class="ml-4">
                                <span>{{ number_format($payment_vnpay->total ?? 0) }} VND</span>
                            </span>
                        </div>

                        <!-- Căn chỉnh phần mô tả loại hình thanh toán -->
                        <div class="text-center small d-flex justify-content-center">
                            <span class="mr-3">
                                <i class="fas fa-circle text-primary"></i> Thanh toán khi nhận hàng
                            </span>
                            <span class="mr-3">
                                <i class="fas fa-circle text-success"></i> Thanh toán Online
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="highcharts-dashboards-wrapper shadow-box">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Số lượng mỗi sản phẩm</h6>
            </div>

            <div id="container"></div>
            <pre id="csv">Vegetable,Amount
                @foreach ($quantityPro as $value)
                {{ "$value->name,$value->quantityproduct" }}
                @endforeach
            </pre>
        </div>
        {{-- Top 5 --}}
        <figure class="highcharts-figure mt-5 shadow-box">
            <div class="d-flex">
                <div class="tablecontainer">
                    <div id="tablecontainer" class=""></div>
                </div>
                <div class="datatable">
                    <table class="table table-striped table-hover align-middle h-100" id="datatable">
                        <thead class="">
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($top5product as $item)
                                <tr>
                                    <td>{{ $item->pro_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->pro_price_regular }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </figure>
        {{-- Ngày trong tháng --}}
        <figure class="highcharts-figure shadow-box mt-5">
            <div id="containerday"></div>

            <button id="plain" class="highcharts-demo-button">Biểu đồ cột</button>
            <button id="inverted" class="highcharts-demo-button">biểu đồ thanh ngang</button>
            <button id="polar" class="highcharts-demo-button">Biểu đồ tròn</button>
        </figure>

    </div>
@endsection
<script>
    let payment_deliver = @json($payment_deliver);
    let payment_vnpay = @json($payment_vnpay);
    let totalTwMonth = @json($totalTwMonth);
    let total_day = @json($total_day);
</script>
<script src="{{ asset('/admin/js/demo/chart-pie-demo.js') }}"></script>
<script src="{{ asset('/admin/js/demo/chart-area-demo.js') }}"></script>

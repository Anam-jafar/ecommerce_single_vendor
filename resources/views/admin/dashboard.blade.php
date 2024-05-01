@extends('admin.layouts.template')

@section('title')
Dashboard - Admin
@endsection

@section('content')
<div class="container p-5" style="color: white;">
    <div class="row">
        <div class="col-md-4">
            <a href="{{ route('allProducts') }}" style="text-decoration: none;">
                <div class="card text-white" style="background-color: #696cff; margin-bottom: 10px;">
                    <div class="card-body">
                        <h5 class="card-title" style="color: white;">Products</h5>
                        <p class="card-text" style="color: white; font-size: 24px;">{{ $productCount }}</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('allCategories') }}" style="text-decoration: none;">
                <div class="card text-white" style="background-color: #696cff; margin-bottom: 10px;">
                    <div class="card-body">
                        <h5 class="card-title" style="color: white;">Categories</h5>
                        <p class="card-text" style="color: white; font-size: 24px;">{{ $categoryCount }}</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('allSubCategories') }}" style="text-decoration: none;">
                <div class="card text-white" style="background-color: #696cff; margin-bottom: 10px;">
                    <div class="card-body">
                        <h5 class="card-title" style="color: white;">Subcategories</h5>
                        <p class="card-text" style="color: white; font-size: 24px;">{{ $subcategoryCount }}</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <a href="{{ route('allOrders') }}" style="text-decoration: none;">
                <div class="card text-white" style="background-color: #696cff; margin-bottom: 10px;">
                    <div class="card-body">
                        <h5 class="card-title" style="color: white;">Ongoing Orders</h5>
                        <p class="card-text" style="color: white; font-size: 24px;">{{ $ongoingOrderCount }}</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('adminPendingOrders') }}" style="text-decoration: none;">
                <div class="card text-white" style="background-color: #696cff; margin-bottom: 10px;">
                    <div class="card-body">
                        <h5 class="card-title" style="color: white;">Pending Orders</h5>
                        <p class="card-text" style="color: white; font-size: 24px;">{{ $pendingOrderCount }}</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{route('customerList')}}" style="text-decoration: none;">
                <div class="card text-white" style="background-color: #696cff; margin-bottom: 10px;">
                    <div class="card-body">
                        <h5 class="card-title" style="color: white;">Customers</h5>
                        <p class="card-text" style="color: white; font-size: 24px;">{{ $customerCount }}</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<div class="container p-5">
    <div class="row">
        <div class="col-md-6">
            <canvas id="bestSellingProductsChart" width="100" height="50"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="worstSellingProductsChart" width="100" height="50"></canvas>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <canvas id="revenueChart" width="200" height="100"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Best selling products chart
    <?php
    $productNames = [];
    $totalOrders = [];
    
    foreach ($bestSellingProducts as $product) {
        $productNames[] =  App\Models\Product::find($product->product_id)->product_name; 
        $totalOrders[] = $product->total_orders;
    }
    $productNamesJson = json_encode($productNames);
    $totalOrdersJson = json_encode($totalOrders);
    ?>

    var bestSellingProductsChart = new Chart(document.getElementById('bestSellingProductsChart'), {
        type: 'bar',
        data: {
            labels: <?php echo $productNamesJson; ?>,
            datasets: [{
                label: 'Best Selling Products',
                data: <?php echo $totalOrdersJson; ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    // Worst selling products chart

    <?php
    $productNames = [];
    $totalOrders = [];
    
    foreach ($worstSellingProducts as $product) {
        $productNames[] =  App\Models\Product::find($product->product_id)->product_name; 
        $totalOrders[] = $product->total_orders;
    }
    $productNamesJson = json_encode($productNames);
    $totalOrdersJson = json_encode($totalOrders);
    ?>
    var worstSellingProductsChart = new Chart(document.getElementById('worstSellingProductsChart'), {
        type: 'bar',
        data: {
            labels: <?php echo $productNamesJson; ?>,
            datasets: [{
                label: 'Worst Selling Products',
                data: <?php echo $totalOrdersJson; ?> ,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    // Revenue chart


    var revenueChart = new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: <?php echo json_encode($revenueLabels); ?>,
            datasets: [{
                label: 'Total Revenue',
                data: <?php echo json_encode($revenueData); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>

@endsection

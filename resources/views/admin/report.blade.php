@extends('layouts.app')

@section('title', 'Reports')

@section('content')
@include('admin.nav')

<div class="container mt-5">
    <div class="header mb-4">
        <h2>Dynamic Charts - Categories, Products</h2>
    </div>

    <div class="row">
        <!-- Category Count Bar Chart -->
        <div class="col-md-6 col-sm-12 mb-4">
            <h4 class="mb-3">Products per Category</h4>
            <div id="productsPerCategoryChart" style="max-width: 100%;"></div>
        </div>

        <!-- Category Distribution Pie Chart -->
        <div class="col-md-6 col-sm-12 mb-4">
            <h4 class="mb-3">Category Distribution</h4>
            <div id="categoryChart" style="max-width: 100%;"></div>
        </div>
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<!-- Chart Initialization Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Products per Category Bar Chart
        const productsPerCategoryOptions = {
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            xaxis: {
                categories: @json($categories->pluck('category_name')),
            },
            series: [{
                name: 'Number of Products',
                data: @json($categories->pluck('products_count')),
            }],
            title: {
                text: 'Number of Products per Category',
                align: 'center',
                style: {
                    fontSize: '18px',
                    fontWeight: '600'
                }
            },
            colors: ['#007bff'],
        };

        const productsPerCategoryChart = new ApexCharts(document.querySelector("#productsPerCategoryChart"), productsPerCategoryOptions);
        productsPerCategoryChart.render();

        // Category Distribution Pie Chart
        const categoryPieOptions = {
            chart: {
                type: 'pie',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            labels: @json($categories->pluck('category_name')),
            series: @json($categories->pluck('products_count')),
            title: {
                text: 'Category Distribution',
                align: 'center',
                style: {
                    fontSize: '18px',
                    fontWeight: '600'
                }
            },
            colors: ['#6610f2', '#dc3545', '#ffc107', '#20c997', '#6f42c1', '#007bff'],
        };

        const categoryPieChart = new ApexCharts(document.querySelector("#categoryChart"), categoryPieOptions);
        categoryPieChart.render();
    });
</script>

@endsection

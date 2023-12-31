<?php
    $num_categories = \App\Models\Category::get()->count();
    $num_products = \App\Models\Product::get()->count();
    $num_categoriesAndProducts = $num_categories + $num_products;
?><!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

@include('includes/head', ['page_title' => "Home | Admin & Dashboard"])

<body>
<!-- Begin page -->
<div id="layout-wrapper">

    @include('includes/header')

    <!-- Left Sidebar End -->
    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Dashboard - Home</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xxl-4 col-lg-6">
                        <div class="card card-height-100">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Categories &amp; Products</h4>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div id="categories-and-products-chart" class="apex-charts" dir="ltr"></div>
                                <div class="mt-3">
                                    <div class="d-flex justify-content-center align-items-center mb-4">
                                        <h2 class="me-3 ff-secondary mb-0">{{ $num_categoriesAndProducts }}</h2>
                                        <div>
                                            <p class="text-muted mb-0">Categories + Products</p>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between border-bottom border-bottom-dashed py-2">
                                        <p class="fw-medium mb-0"><i class="ri-checkbox-blank-circle-fill text-success align-middle me-2"></i> Categories</p>
                                        <div>
                                            <span class="text-success pe-5">{{ $num_categories }} Categories</span>
                                        </div>
                                    </div><!-- end -->
                                    <div class="d-flex justify-content-between border-bottom border-bottom-dashed py-2">
                                        <p class="fw-medium mb-0"><i class="ri-checkbox-blank-circle-fill text-primary align-middle me-2"></i> Products</p>
                                        <div>
                                            <span class="text-primary pe-5">{{ $num_products }} Products</span>
                                        </div>
                                    </div><!-- end -->
                                </div>
                            </div><!-- end cardbody -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div><!-- end row -->

            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        @include('includes/footer')
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->



<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>
<!--end back-to-top-->

<!--preloader-->
<div id="preloader">
    <div id="status">
        <div class="spinner-border text-primary avatar-sm" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>

<!-- JAVASCRIPT -->
@include('includes/javascript')

<script type="module">
    let options = {
        series:[{{ $num_categories }},{{ $num_products }}],
        labels:[
            "Categories",
            "Products"
        ],
        chart:{
            type:"donut",
            height:230
        },
        plotOptions:{
            pie:{
                size:100,
                offsetX:0,
                offsetY:0,
                donut:{
                    size:"90%",
                    labels:{
                        show:!1
                    }
                }
            }
        },
        dataLabels:{
            enabled:!1
        },
        legend:{
            show:!1
        },
        stroke:{
            lineCap:"round",
            width:0
        },
    };
    let chart = new ApexCharts(document.querySelector('#categories-and-products-chart'), options);
    chart.render();
</script>

</body>

</html>

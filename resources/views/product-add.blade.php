<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
      data-sidebar-image="none" data-preloader="disable">

@include('includes/head', ['page_title' => "Product - Add new | Admin & Dashboard"])

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
                            <h4 class="mb-sm-0">Product - Add new</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xxl-12 col-lg-12">
                        <div class="card card-height-100">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Product - Add new</h4>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <form action="{{ route('add-product-insert') }}" id="product_add_form" method="post">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label" for="product_name">Product Name</label>
                                        <input class="form-control" id="product_name" name="product_name" maxlength="100" type="text" value="" placeholder="New Product Name">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="product_desc">Product Description</label>
                                        <input class="form-control" id="product_desc" name="product_desc" type="text" value="" placeholder="New Product Description">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="product_cost">Product Cost</label>
                                        <div class="input-group">
                                            <input class="form-control" id="product_cost" name="product_cost" type="number" value="" data-original-value="0" min="0" placeholder="1200.00">
                                            <span class="input-group-text">€</span>
                                        </div>
                                        <div class="form-text">Product cost must be 0 or higher.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="product_category_id">Product Category</label>
                                        <select class="form-select" id="product_category_id" name="product_category_id">
                                            <option class="fst-italic" value="{{ null }}">Uncategorized</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <input class="btn btn-success" type="submit" value="Add">
                                </form>
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

@include('includes/product-editing-javascript')

</body>

</html>

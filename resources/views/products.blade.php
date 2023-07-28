<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
      data-sidebar-image="none" data-preloader="disable">

@include('includes/head', ['page_title' => "Products | Admin & Dashboard"])

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
                            <h4 class="mb-sm-0">Dashboard - Products</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xxl-12 col-lg-12">
                        <div class="card card-height-100">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Products</h4>
                            </div>
                            @if( session("product_deletion_msg") )<div class="align-items-center d-flex alert alert-{{ session("product_deletion_result") }}">{{ session("product_deletion_msg") }}</div>@endif<!-- end card header -->

                            <div class="card-body">
                                <table id="products_table"
                                       class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                       style="width:100%">
                                    <thead>
                                    <tr>
                                        <th data-ordering="false">#</th>
                                        <th data-ordering="false">Name</th>
                                        <th data-ordering="false">Description</th>
                                        <th data-ordering="false">Cost</th>
                                        <th data-ordering="false">Category</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>{{ $product['id'] }}</td>
                                            <td>{{ $product['name'] }}</td>
                                            <td>{{ $product['desc'] }}</td>
                                            <td>{{ $product['cost'] }}€</td>
                                            <td>{{ $product['category_name'] }}</td>
                                            <td>
                                                <div class="dropdown d-inline-block">
                                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ri-more-fill align-middle"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item"><i
                                                                    class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                                View product</a></li>
                                                        <li>
                                                            <a href="{{ route('edit-product', ["identifier" => $product['id']]) }}" class="dropdown-item edit-item-btn">
                                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit product
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('delete-product') }}" method="POST">
                                                                @method('delete')
                                                                @csrf
                                                                <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                                                                <button class="dropdown-item remove-item-btn" onclick="return confirm('Please confirm deletion.');" type="submit">
                                                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                    Delete product
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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

</body>

</html>

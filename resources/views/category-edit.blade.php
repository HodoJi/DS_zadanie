<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
      data-sidebar-image="none" data-preloader="disable">

@include('includes/head', ['page_title' => "Category editing: $category_name (id: $category_id) | Admin & Dashboard"])

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
                            <h4 class="mb-sm-0">Category editing</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xxl-12 col-lg-12">
                        <div class="card card-height-100">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Category editing: {{ $category_name }}</h4>
                            </div>
                            @if( isset($category_edit_result_msg) )<div class="align-items-center d-flex alert alert-{{ $category_edit_result }}">{{ $category_edit_result_msg }}</div>@endif<!-- end card header -->

                            <div class="card-body">
                                <form action="{{ route('edit-category-save') }}" id="category_edit_form" method="post">
                                    @csrf
                                    <input name="category_id" type="hidden" value="{{ $category_id }}">

                                    <div class="mb-3">
                                        <label class="form-label" for="category_name">Category Name</label>
                                        <input class="form-control" id="category_name" name="category_name" maxlength="100" type="text" value="{{ $category_name }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="category_slug">Category Slug</label>
                                        <input class="form-control" id="category_slug" name="category_slug" type="text" value="{{ $category_slug }}" style="cursor: not-allowed" readonly>
                                        <div class="form-text">Slug is auto-generated from category name, cannot be edited.</div>
                                    </div>

                                    <input class="btn btn-primary" type="submit" value="Save">
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

</body>

</html>

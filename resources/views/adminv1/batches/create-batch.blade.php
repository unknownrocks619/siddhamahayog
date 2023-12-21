@extends("layouts.portal.app")

@section("page_title")
    Batches
@endsection

@section("page_css")
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css"/>
 

@endsection


@section("content")
<section class="content">
    <div class="container">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Batches</h2> 
                </div>
            </div>
        </div>


        <div class="row clearfix">
            <div class="col-lg-12">
                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible mb-2" role="alert">
                        <button type="button" class="close text-info" data-dismiss="alert" aria-label="close">
                            x
                        </button>
                        <div class='d-flex align-items-center'>
                            <i class="bx bx-check"></i>
                            <span>{{ Session::get('success') }}</span>
                        </div>
                    </div>
                @endif
                @if(Session::has('error'))
                    <div class="alert alert-danger alert-dismissible mb-2" role="alert">
                        <button type="button" class="close text-info" data-dismiss="alert" aria-label="close">
                            x
                        </button>
                        <div class='d-flex align-items-center'>
                            <i class="bx bx-check"></i>
                            <span>{{ Session::get('error') }}</span>
                        </div>
                    </div>
                @endif
                <form action="{{ route('admin.batch.admin_batch_store') }}" method="post">
                    @csrf
                    <div class="card">
                        <div class="header">
                            <h2><strong>Create</strong> New Batch </h2>
                            <ul class="header-dropdown">
                                <li class="remove">
                                    <button type="button" onclick="window.location.href='{{ route('admin.batch.admin_batch_list') }}'" class="btn btn-danger btn-sm boxs-close"><i class="zmdi zmdi-close"></i> Close</button>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                                    <div class="form-group">
                                        <b>Batch Name
                                            <sup class="text-danger">*</sup>
                                        </b>
                                        <input type="text" value="{{ old('batch_name') }}" class="form-control" name="batch_name" id="batch_name" />
                                        @error("batch_name")
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                                    <div class="form-group">
                                        <b>Year
                                            <sup class="text-danger">*</sup>
                                        </b>
                                        <input value="{{ old('year') }}" class="form-control" name="year" id="year" required type="text" placeholder="YYYY">
                                        @error("year")
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                                    <div class="form-group">
                                        <b>Month
                                            <sup class="text-danger">*</sup>
                                        </b>
                                        <input require value="{{ old('month') }}" type="text" class='form-control' placeholder="MM" name="month" id="month" />
                                        @error("month")
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-block">Create Batch</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section("page_script")

<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
@endsection
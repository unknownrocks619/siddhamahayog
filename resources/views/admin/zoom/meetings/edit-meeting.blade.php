@extends("layouts.portal.app")

@section("page_title")
    - Meeting - Setup Meeting
@endsection

@section("top_css")
    <link rel="stylesheet" href="{{ asset ('assets/plugins/multi-select/css/multi-select.css') }}">
    <link href="{{ asset ('assets/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />

@endsection

@section("content")
<section class="content">
    <div class="container">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Meetings</h2>                    
                </div>            
                <!-- <div class="col-lg-7 col-md-7 col-sm-12">
                    <ul class="breadcrumb float-md-right padding-0">
                        <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Forms</a></li>
                        <li class="breadcrumb-item active">Basic Elements</li>
                    </ul>
                </div> -->
            </div>
        </div>
        <div class="row clearfix" id="app">
            <zoom-meeting-edit update_path="{{ route('zoom.admin_api_update_zoom_meeting',[$meeting->id]) }}" resource="{{ $meeting }}"></zoom-meeting-edit>
        </div>
    </div>
</section>
@endsection

@section("page_script")

<script src="{{ asset ('assets/plugins/momentjs/moment.js') }}"></script> <!-- Moment Plugin Js --> 
<!-- Bootstrap Material Datetime Picker Plugin Js --> 
<script src="{{ asset ('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script> 
<script src="{{ asset ('assets/plugins/multi-select/js/jquery.multi-select.js') }}"></script> <!-- Multi Select Plugin Js --> 

<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script><!-- Custom Js --> 
<script src="{{ asset ('assets/js/pages/forms/basic-form-elements.js') }}"></script> 
<script src="{{-- asset('assets/js/pages/forms/advanced-form-elements.js') --}}"></script> 

<script src="{{ mix('js/app.js') }}"></script>
@endsection
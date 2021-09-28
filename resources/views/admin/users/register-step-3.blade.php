@extends('layouts.admin')

@section('page_css')
 <!-- BEGIN: Page CSS-->
 <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/css/core/menu/menu-types/vertical-menu.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/pages/widgets.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/css/pages/dashboard-analytics.min.css') }}">
    <!-- END: Page CSS-->
@endSection()

@section('content')
<section class="users-edit">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs mb-2" role="tablist">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" id="account-tab" data-toggle="tab"
                        href="#account" aria-controls="account" role="tab" aria-selected="true">
                        <i class="bx bx-info-circle mr-25"></i>
                        <span class="d-none d-sm-block">Personal Information</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" id="account-tab" data-toggle="tab"
                         aria-controls="information" role="tab" aria-selected="false">
                        <i class="bx bx-info-circle mr-25"></i><span class="d-none d-sm-block">User Verification</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" 
                     aria-controls="information" role="tab" aria-selected="false">
                        <i class="bx bx-info-circle mr-25"></i><span class="d-none d-sm-block">Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center disabled" 
                     aria-controls="information" role="tab" aria-selected="false">
                        <i class="bx bx-info-circle mr-25"></i><span class="d-none d-sm-block">Sewa</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active fade show" id="account" aria-labelledby="account-tab" role="tabpanel">
                    <!-- users edit account form start -->
                    <form enctype="multipart/form-data" method="post" class="form-validate" action="{{ route('users.submit_user_verification',['user_id'=>encrypt($user_detail->id)]) }}">
                        @csrf
                        <div class='row'>
                            <div class="col-md-12">
                                <div class='alert alert-danger' id="msgDisplay" style="display:none"></div>
                            </div>
                        </div>
                        <div class='row bg-warning'>
                            <div class="col-6 col-sm-6">
                                <div class='row'>
                                    <div class='col-md-12 col-sm-12'>
                                        <div class="card card-body" id="screen_preview">Please Wait...loading your camera.</div>
                                    </div>
                                    <div class="col-md-12 pb-2 pt-2">
                                        <button type="button" onClick="take_snapshot()" class="btn btn-primary">Take A Snap</button>
                                    </div>

                                </div>
                            </div>
                            <div class='col-6 col-sm-6'>
                                <div class='row'>
                                    <div class="col-md-12">
                                        <div class='card card-body' id="img_preview">Your snapshot will be displayed here.</div>
                                    </div>
                                    <div class="col-md-12" id="display_col" style="display:none">
                                        <button type="button" id="save_image_button" class="btn btn-success text-white">Confirm Snap</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                    <!-- users edit account form ends -->
                </div>
            </div>
        </div>
    </div>
</section>
@endSection()

@section('page_js')
<script src="{{ asset('js/webcam.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        
        configure();
       
    });

    function configure(){
			Webcam.set({
				width: 320,
				height: 240,
				image_format: 'jpeg',
				jpeg_quality: 100
			});
            Webcam.attach( '#screen_preview' );
            // $("#saveImage").fadeOut('fast',function(){
            //     $(this).attr('disabled',true);
            // })
        }
         // A button for taking snaps
         function take_snapshot() {
                // play sound effect
                // shutter.play();

                // take snapshot and get image data
                Webcam.snap( function(data_uri) {
                    // display results in page
                    document.getElementById('img_preview').innerHTML = 
                        '<img style="height:250px;width:350px" id="imageprev" src="'+data_uri+'" class=" img-thumbnail" />';
                       
                } );
                $("#display_col").fadeIn('fast');
                // Webcam.reset();
        }

            $("#save_image_button").click(function(){
            var base64Image = document.getElementById("imageprev").src;
            // var formData = new FormData();
            // formData.append('')
            Webcam.upload( base64Image, 
                '{{ url("admin/user_webcam_upload") }}?user_id={{ encrypt($user_detail->id) }}',
                 "{{ csrf_token() }}",
                 function(code, text) {
                    var response = JSON.parse(text);
                    
                    if(response.error === false)
                    {
                        $("#msgDisplay").fadeIn('medium',function(){
                         // let's setup this 
                         $(this).attr('class','alert alert-success');
                         $(this).html(response.message);
                         setTimeout(function(){
                             window.location.href=response.redirection;
                        },1000); 
                     })
                    }
                })
            });
        
</script>
@endSection()

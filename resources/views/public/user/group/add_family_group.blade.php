@extends("layouts.clients")

@section("page_css")
    <style type="text/css">
        #overlay {
        background: #ffffff;
        color: #666666;
        position: fixed;
        height: 100%;
        width: 100%;
        z-index: 5000;
        top: 0;
        left: 0;
        float: left;
        text-align: center;
        padding-top: 10%;
        opacity: .80;
        }
        
        .spinner {
            margin: 0 auto;
            height: 64px;
            width: 64px;
            animation: rotate 0.8s infinite linear;
            border: 5px solid firebrick;
            border-right-color: transparent;
            border-radius: 50%;
        }
        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection

@section("breadcrumb")
    <!-- Breadcrumb -->
    <div class="breadcrumb-bar">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12 col-12">
					<nav aria-label="breadcrumb" class="page-breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item"> <a href="{{ route('public_user_dashboard') }}">Dashboard</a></li>
                            <li class='breadcrumb-item'><a href="#">Settings</a></li>
                            <li class='breadcrumb-item'><a href="{{ route('public.family.public_event_family_list') }}">Family Setup</a></li>
                            <li class='breadcrumb-item active' aria-current="page">Add Family Member</li>
						</ol>
					</nav>
					<h2 class="breadcrumb-title">Family Member Setup</h2>
				</div>
			</div>
		</div>
	</div>
	<!-- /Breadcrumb -->
@endsection

@section("content")
    <div id="overlay" style="display:none;">
        <div class="spinner"></div>
        <br/>
            <h4 id="loading_text">Please wait... Connecting to server...</h4>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
                @include("public.inc.navigation")
            </div>
            <div class="col-md-7 col-lg-8 col-xl-9">
                <form method="post" action="{{ route('public.family.public_add_family_to_event') }}">
                    @csrf
                    <div class='card'>
                        <div class='card-header'>
                            <a href="{{ route('public.family.public_event_family_list') }}" class='text-right btn btn-sm btn-secondary'>
                                        <i class='fa fa-arrow-left'></i> &nbsp;    
                                         Family List
                                    </a>
                        </div>
                        <div class='card-body'>
                            <p class='text-info'>All members approved for group video will be marked present after any family members starts his / her session</p>
                            <div id="error"></div>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <label class='label-control'>Select Event<span class='text-danger'>*</span></label>

                                    <select class='form-control' name='event'>
                                        @if(! $single) 
                                            @foreach ($events as $event)
                                                <option value={{ encrypt($event->sibir_record->id) }}"> {{ $event->sibir_record->sibir_title }} </option>
                                            @endforeach
                                        @else
                                            <option value='{{ encrypt($events->id) }}' selected> {{ $events->sibir_title }} </option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class='relation_field'>
                                <div class='row mt-3 family_field' id="family_field">
                                    <div class='col-md-5'>
                                        <label class='label-control'>Login ID / Email</label>
                                        <input type="text" name='login_id[]' class='form-control' />
                                    </div>
                                    <div class='col-md-5'>
                                        <label class='label-control'>Relation</label>
                                        <input type="text" name='relation[]' class='form-control' />
                                    </div>
                                </div>
                            </div>
                            <div class='row mt-2'>
                                <div class='col-md-5'>
                                    <div class="add-more">
                                        <a href="javascript:void(0);" class="add-family-field"><i class="fa fa-plus-circle"></i> Add More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='card-footer'>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <button type="submit" class='btn btn-lg btn-primary'>Save Family Member</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section("page_js")
    <script type="text/javascript">
        $(".add-family-field").on('click', function () {
		
            var educationcontent = '<div class="row mt-4 family_field">' +
                '<div class="col-md-5">' +
                    '<label>Login ID / Email</label>' +
                    '<input type="text" name="login_id[]" class="form-control" />' +
                '</div>'+
                '<div class="col-md-5">' +
                        '<label>Relation</label>' +
                        '<input type="text" name="relation[]" class="form-control">' +
                '</div>' +
                '<div class="col-md-2">'+
                    '<label class="d-md-block d-sm-none d-none">&nbsp;</label>'+
                    '<a href="#" class="btn btn-danger trash">'+
                        '<i class="far fa-trash-alt"></i>'+
                    '</a>'+
                '</div>' +
            '</div>';
            
            $(".relation_field").append(educationcontent);
            return false;
        });

        $(".relation_field").on('click','.trash', function () {
            $(this).closest('.family_field').remove();
            return false;
        });
    </script>

    <script type="text/javascript">
        $("form").submit( function(event) {
            $("#error").fadeOut('fast',function(){
                $(this).removeAttr('class').empty();
            })
            event.preventDefault();
            $.ajax({
                type : "POST",
                data : $(this).serializeArray(),
                url : $(this).attr("action"),
                success : function( response ) {
                    if (response.success === true) {
                        $("#error").attr("class",'alert alert-success').html(response.message);
                        $('form').trigger("reset");
                    } else {
                        $("#error").attr("class",'alert alert-danger');
                        let errorMg = '<p>'+ response.message +'</p>'+
                            '<ul>';
                        
                                $.each( response.data , function (key, value) {
                                    errorMg +='<li>'+ value + '</li>';
                                })
                            errorMg +='</ul>';
                        $("#error").append(errorMg)
                    }

                    $("#error").fadeIn('fast');
                }
            })
        });
    </script>
    <script type="text/javascript">
        $(document).ajaxStart(function() {
            $("#overlay").fadeIn(function() {
                $("#loading_text").html("Please wait... Submitting your family detail.. ");
            });
        });

        $(document).ajaxStop( function() {
            $("#overlay").fadeOut(function() {
                $("#loading_text").html('Please wait... Connecting to server...');
            });
        });
    </script>    
@endsection
@extends("layouts.clients")
@section("breadcrumb")
	<!-- Breadcrumb -->
	<div class="breadcrumb-bar">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12 col-12">
					<nav aria-label="breadcrumb" class="page-breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item"><a href="{{ route('public_user_dashboard') }}">Dashboard</a></li>
                            <li class='breadcrumb-item'><a href="{{ route('public.event.public_list_my_absent_record') }}">Absent Log</a></li>
                            <li class='breadcrumb-item active' aria-current="page">
                                Absent requesition form
						</ol>
					</nav>
					<h2 class="breadcrumb-title">Absent Form</h2>
				</div>
			</div>
		</div>
	</div>
	<!-- /Breadcrumb -->
@endsection

@section("content")
<div class="container-fluid" style="padding-left:0px">
    <div class="row">
        <div class="col-md-5 col-lg-4 col-xl-3" style="padding-left:0px; padding-right:0px">
            @include("public.inc.navigation")
        </div>
        
        <div class="col-md-7 col-lg-8 col-xl-9">
            <x-alert></x-alert>
            <a href="{{ route('public.event.public_list_my_absent_record') }}" class='btn btn-secondary btn-sm mb-2'><i class='fas fa-arrow-left'></i> Back To List</a>
            <form method="post" action="{{ route('public.event.public_store_request_absent_form') }}">
                @csrf
                <div class='card'>
                    <div class='card-body'>
                        <div class='row'>
                            <div class='col-md-6'>
                                @php
                                    $user_event = \App\Models\UserSadhakRegistration::with(['sibir_record'])->where('user_detail_id',auth()->user()->user_detail_id)->get();
                                @endphp
                                <label class='label-control'>Select Event <span class='text-danger'>*</span></label>
                                <select class='form-control' name='event'>
                                    @if($user_event->count()) 
                                        @foreach ($user_event as $event)
                                            <option value='{{ encrypt($event->sibir_record->id) }}'>{{ $event->sibir_record->sibir_title }}</option> 
                                        @endforeach
                                    @else
                                        <option value="">Select Event</option>
                                    @endif
                                </select>
                            </div>
                            <div class='col-md-6'>
                                <label class='label-control'>No of Days <span class='text-danger'>*</span></label>
                                <input type="number" name='nod' class='form-control' />
                            </div>
                        </div>

                        <div class='row mt-3'>
                            <div class='col-md-6'>
                                <label class='label-control'>From Date <span class='text-danger'>*</span></label>
                                <input type="date" name="from_date" class="form-control" />
                            </div>
                        </div>
                        <div class='row mt-3'>
                            <div class='col-md-12'>
                                <label class='label-control'>Write your reason in detail. <span class='text-danger'>*</span></label>
                                <textarea name="reason" class='form-control'></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class='row'>
                            <div class='col-md-6'>
                                <button type="submit" class="btn btn-primary">Send Request</button>
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
    <script src="https://cdn.tiny.cloud/1/gfpdz9z1bghyqsb37fk7kk2ybi7pace2j9e7g41u4e7cnt82/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        $(document).ready(function(){
			tinymce.init({
                selector: 'textarea',
                plugins: 'lists image print preview hr',
                toolbar_mode: 'floating',
                menubar: false
		    });
        })
	</script>
@endsection
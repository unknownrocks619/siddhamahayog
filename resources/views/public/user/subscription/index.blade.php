@extends("layouts.clients")

@section("breadcrumb")

<!-- Breadcrumb -->
<div class="breadcrumb-bar">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12 col-12">
					<nav aria-label="breadcrumb" class="page-breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{ route('public_user_dashboard') }}">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page">My Events</li>
						</ol>
					</nav>
					<h2 class="breadcrumb-title">My Events</h2>
				</div>
			</div>
		</div>
	</div>
	<!-- /Breadcrumb -->

@endsection

@section("content")
<div class="container-fluid" style="padding-left:0px" >
	<div class="row">
		<div class="col-md-5 col-lg-4 col-xl-3 " style="padding-left:0px;padding-right:0px">
			@include("public.inc.navigation")
		</div>			
		<div class="col-md-7 col-lg-8 col-xl-9">
			<div class="row">
				<div class="col-md-12">
					<h4 class="mb-4">Subscribed Events</h4>
					<div class="appointment-tab">
                        <div class="card mb-0">
                            <div class='card-body'>
                                @include("public.inc.support-text")
                                <table class='table table-hover table-bordered'>
                                    <thead>
                                        <tr>
                                            <th>Program Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($my_events as $event)
                                            <tr>
                                                <td>
                                                    {{ $event->sibir_record->sibir_title ?? "Event Not available" }}
                                                    -
                                                    @if($event->sibir_record)
                                                    <a href="{{ route('public.public_add_subscription_amount',encrypt($event->sibir_record->id)) }}" class='text-success'>Add Fund</a> | 
                                                    <a href="{{ route('public.public_subscription_transaction_list',[encrypt($event->sibir_record->id)]) }}" class='text-warning'>View Transaction Detail</a> |
                                                    <a href="{{ route('public.family.public_event_family_list',['event'=>encrypt($event->sibir_record->id)]) }}" class='text-secondary'>My Family / Group</a>|
                                                    <a href="{{ route('public.event.public_list_my_absent_record') }}" class='text-danger'>Request Break</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection


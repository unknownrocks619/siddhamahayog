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
							<li class="breadcrumb-item" aria-current="page">
                                <a hrefe="{{ route('public.public_subscription') }}">
                                    My Events
                                </a>
                            </li>
							<li class="breadcrumb-item active" aria-current="page">
                                {{ $sibir_record->sibir_title }}
                            </li>
						</ol>
					</nav>
					<h2 class="breadcrumb-title">`{{ $sibir_record->sibir_title }}` Transaction Detail</h2>
				</div>
			</div>
		</div>
	</div>
	<!-- /Breadcrumb -->

@endsection

@section("content")
<div class="container-fluid" style="padding-left:0px;">
	<div class="row">
		<div class="col-md-5 col-lg-4 col-xl-3" style="padding-left:0px; padding-right:0px;">
			@include("public.inc.navigation")
		</div>			
		<div class="col-md-7 col-lg-8 col-xl-9">
			<div class="row">
				<div class="col-md-12">
					<h4 class="mb-4">Transaction Detail </h4>
					<div class="appointment-tab">
                        <div class="card mb-0">
                            <div class='card-body'>
                                <div class='card-header'>
                                    <a href="{{ route('public.public_add_subscription_amount',[encrypt($sibir_record->id)]) }}" class='btn btn-primary'>Add Payment Detail</a>
                                    &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
                                    <a href="{{ route('public.public_subscription') }}"><i class='fa fa-arrow-left'></i> Go Back</a>
                                </div>
                                <x-alert></x-alert>
                                <table class='table table-hover table-bordered'>
                                    <thead>
                                        <tr>
                                            <th>Program Name</th>
                                            <th>Amount</th>
                                            <th>Depository Party</th>
                                            <th>Reference No</th>
                                            <th>Support Document </th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @forelse ($transactions as $transaction)
                                            <tr>
                                                <td>
                                                    {{ $sibir_record->sibir_title }}
                                                </td>
                                                <td>
                                                    {{ $transaction->amount }}
                                                </td>
                                                <td>
                                                    {{ $transaction->source }}
                                                </td>
                                                <td>
                                                    {{ $transaction->reference_number }}
                                                </td>
                                                <td>
                                                    @if($transaction->file)
                                                        <a href='#'>Download</a>
                                                    @else
                                                        <span class='bg-info-light'>N/A</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($transaction->status == "Pending")
                                                        <span class='bg-warning-light'>Pending</span>
                                                    @elseif($transaction->status == "Rejected")
                                                        <span class='bg-danger-light'>Rejected</span>
                                                    @else
                                                        <span class='bg-success-light'>Confirmed</span>
                                                    @endif
                                                </td>
                                                
                                            </tr>
                                       @empty
                                           <tr>
                                               <td colspan='7' class='text-center'>
                                                   <span class='text-primary'>No Transaction Detail</span>
                                               </td>
                                           </tr>
                                       @endforelse
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


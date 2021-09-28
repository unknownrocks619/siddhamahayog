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
					<h2 class="breadcrumb-title">`{{ $sibir_record->sibir_title }}` Transaction </h2>
				</div>
			</div>
		</div>
	</div>
	<!-- /Breadcrumb -->

@endsection

@section("content")
<div class="container-fluid" style="paddgin-left:0px">
	<div class="row">
		<div class="col-md-5 col-lg-4 col-xl-3" style="padding-left:0px;padding-right:0px">
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
                                    <a href="{{ url()->previous() }}" class='btn btn-primary'>
                                        <i class='fa fa-arrow-left'></i>
                                        Go Back
                                    </a>
                                </div>
                                <div class='card-body'>
                                    <div class='row'>
                                        <div class='col-md-6'>
                                            <x-alert></x-alert>
                                            <form enctype="multipart/form-data" method="post" action="{{ route('public.public_store_subscription_amount_offline',[encrypt($sibir_record->id)]) }}">
                                                @csrf
                                                <div class='card'>
                                                    <div class='card-header'>
                                                        <h4>Banking / Other Payment</h4>
                                                    </div>
                                                    <div class='card-body'>
                                                        <div class='form-row'>
                                                            <label class='label-control'>Transaction Medium</label>
                                                            <select name="transaction_medium" class='form-control'>
                                                                <option value="bank_deposit">Bank Deposit</option>
                                                                <option value="wire_transfer">Wire Transfer</option>
                                                                <option value="international_payment">International Payment</option>
                                                                <option value="other">Other</option>
                                                            </select>
                                                        </div>
                                                        <div class='form-row mt-3'>
                                                            <label class='label-control'>
                                                                Depository Party
                                                            </label>
                                                            <input type="text" class='form-control' name='depository_party' placeholder="Everest Bank" />
                                                        </div>
                                                        <div class='form-row mt-3'>
                                                            <label class='label-control'>
                                                                Voucher Id / Reference Number
                                                            </label>
                                                            <input type="text" class='form-control' name='reference_number' />
                                                        </div>
                                                        <div class='form-row mt-3'>
                                                            <label class='label-control'>
                                                                Supporting Document / Voucher Print
                                                            </label>
                                                            <input type="file" class='form-control' name='file' type="image/*" />
                                                        </div>
                                                        <div class='form-row mt-3'>
                                                            <label class='label-control'>
                                                                Amount
                                                                <sub>(NPR)</sub>
                                                            </label>
                                                            <input type="text" placeholder='E.g: 50000' class='form-control' name='amount' />
                                                        </div>
                                                        <div class='form-row mt-3'>
                                                            <label class='label-control'>
                                                                Remarks
                                                            </label>
                                                            <textarea class='form-control' name="remarks"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class='card-footer'>
                                                        <div class='row'>
                                                            <div class='col-md-12'>
                                                                <button type="submit" class="btn btn-lg btn-block btn-primary">Submit Detail</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class='col-md-6'>
                                            <form method="post" action="{{ route('public.public_store_subscription_amount_online',[encrypt($sibir_record->id)]) }}">
                                                @csrf
                                                <div class='card'>
                                                    <div class='card-header'>
                                                        <h4>Online Payment</h4>
                                                    </div>
                                                    <div class='card-body'>
                                                        <div class='form-row'>
                                                            <label class='label-control'>Depository Party</label>
                                                            <select class='form-control' name='depository_party'>
                                                                <option value='esewa'>E-Sewa</option>
                                                                <option value='khalti'>Khalti</option>
                                                                <option value='ips-connect'>IPS Connect</option>
                                                                <option value='other'>Other</option>
                                                            </select>
                                                            @error("depository_party")
                                                                <div class='text-danger'> {{ $message }} </div>
                                                            @enderror
                                                        </div>
                                                        <div class='form-row mt-2'>
                                                            <label class='label-control'>Transaction ID / Number</label>
                                                            <input type="text" class='form-control' name="transaction_id" />
                                                            @error("transaction_id")
                                                                <div class='text-danger'> {{ $message }} </div>
                                                            @enderror
                                                        </div>

                                                        <div class='form-row mt-2'>
                                                            <label class='label-control'>Amount</label>
                                                            <input type="text" class='form-control' name="amount" />
                                                            @error("amount")
                                                                <div class='text-danger'> {{ $message }} </div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-row mt-2">
                                                            <label class='label-control'>Remarks</label>
                                                            <textarea class='form-control' class='form-control' name='remarks'></textarea>
                                                            @error("remark")
                                                                <div class='text-danger'> {{ $message }} </div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class='card-footer'>
                                                        <div class='row'>
                                                            <button type="submit" class='btn btn-info'>Submit Detail</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection


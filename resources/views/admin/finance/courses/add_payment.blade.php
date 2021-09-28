@extends("layouts.admin")

@section("content")
<!-- Complex headers table -->
<section id="headers">
    <div class="row">
        <div class="col-12">
            <x-alert></x-alert>
            <form method="post" action="{{ route('courses.admin_save_payment_detail') }}">
                @csrf
                <div class="card">
                    <div class="card-body card-dashboard">
                        <p class="card-text text-right">
                            <!-- <a href='' class='btn btn-info'>Export To Excel</a> -->
                            <a href='{{ route("courses.admin_course_list") }}' class='btn btn-info'>Go Back</a>
                        </p>
                    </div>
                    <div class='card-body'>
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <label class="label-control">Courses</label>
                                    <select name="sibir_record" class='form-control'>
                                        @foreach ($courses as $course)
                                            <option value="{{$course->id}}">
                                                {{ $course->course_title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="label-control">Login ID / Email</label>
                                    <input type="text" value="{{ old('login_id') }}" name="login_id" class='form-control' />
                                </div>
                            </div>
                        </div>

                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <label class='label-control'>
                                        Transaction Amount
                                    </label>
                                    <input type="text" class='form-control' value="{{ old('amount') }}" name="amount" />
                                </div>
                                <div class='col-md-6'>
                                    <label class='label-control'>
                                        Depository Party
                                    </label>
                                    <select name="transaction_medium" class='form-control'>
                                        <option value="bank_deposit">Bank Deposit</option>
                                        <option value="wire_transfer">Wire Transfer</option>
                                        <option value="international_payment">International Payment</option>
                                        <option value="ips-connect">IPS Connect</option>
                                        <option value="esewa">E-Sewa</option>
                                        <option value="khalti">Khalti</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class='row'>
                                <div class="col-md-6">
                                    <label class="label-control">Transaction Date</label>
                                    <input type="date" value="{{ old('transaction_date') }}" class='form-control' name="transaction_date" />
                                </div>
                                <div class="col-md-6">
                                    <label class="label-control">Reference / Transaction Number </label>
                                    <input type="text" class='form-control' value="{{ old('reference_number') }}" name="reference_number" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class='row'>
                                <div class="col-md-6">
                                    <label class="label-control">Depository Party
                                        <br />
                                        <small>If payment partner is bank than fill in bank name.</small>
                                    </label>
                                    <input type="text" value="{{ old('depository_party') }}" class='form-control' name="depository_party" />
                                </div>
                                
                            </div>
                        </div>

                        <div class="form-group">
                            <div class='row'>
                                <div class='col-md-12'>
                                    <label class='label-control'>Remark</label>
                                    <textarea class='form-control' name="admin_remarks">{{ old('admin_remarks') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div id="login_user_detail"></div>
                    </div>
                    <div class='card-footer'>
                        <div class='row'>
                            <div class='col-md-6'>
                                <button type="submit" class='btn btn-primary'>Save Payment Detail</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>  
</section>
<!--/ Complex headers table -->
@endsection

@section("footer_js")
    
@endsection
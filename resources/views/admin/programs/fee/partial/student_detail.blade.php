@if( ! $enrollment)
    <div class="row bg-danger">
        <div class="col-md-12">
            <div class="card">
                <div class="head">
                    <h4 class="card-title text-white">
                        `{{ $member->full_name }}` Not Enrolled.
                    </h4>
                </div>


                <div class="body">
                    <form method="post" action="" id="enroll_student_form">
                        @csrf
                        <div class="row" id="enroll_message"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>
                                        Enroll Date
                                        <sup class="text-danger">*</sup>
                                    </strong>
                                    <input type="date" name="enroll_date" id="enroll_date" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Admission Fee
                                        <sup class="text-danger">
                                            *
                                        </sup>
                                    </strong>
                                    <div class="radio inlineblock m-r-20">
                                        <input type="radio" checked name="admission" id="paid" class="with-gap" value="yes">
                                        <label for="paid">Paid</label>
                                    </div>
                                    <div class="radio inlineblock m-r-20">
                                        <input type="radio" disabled name="admission" id="unpaid" class="with-gap" value="no">
                                        <label for="unpaid">Not Paid</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>
                                        Monthly / Other Amount
                                    </strong>
                                    <input type="text" name="monthly_fee" id="monthly_fee" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Scholarship
                                        <sup class="text-danger">
                                            *
                                        </sup>
                                    </strong>
                                    <div class="radio inlineblock m-r-20">
                                        <input type="radio" checked name="scholarshop" id="yes" class="with-gap" value="yes">
                                        <label for="yes">Yes</label>
                                    </div>
                                    <div class="radio inlineblock m-r-20">
                                        <input type="radio" name="scholarshop" id="no" class="with-gap" value="no">
                                        <label for="no">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" id="enroll_student" class="btn btn-info">Enroll Student</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("form#enroll_student_form").submit(function(event) {
            event.preventDefault();
            $("#enroll_message").empty();
            var current_form = $(this);
            $.ajax({
                type : "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url : "{{ route('admin.program.enroll.admin_store_student_in_program',[$program->id,$member->id]) }}",
                data : $(this).serializeArray(),
                success : function (response) {
                    if (response.success == true ) {
                        $("#enroll_message").html("<div class='col-md-12 alert alert-success'>"+response.message+"</div>")
                        $.ajax({
                            type : "GET",
                            url : "{{ route('admin.program.enroll.admin_program_member_enroll',[$program->id]) }}",
                            data : "member={{$member->id}}",
                            success : function (response) {
                                $("#student_info").html(response);
                            }
                        })
                    } else {
                        $("#enroll_message").html("<div class='col-md-12 alert alert-danger'>"+response.message+"</div>")
                    }
                },
                error : function (respons) {

                }
            })
        });
    </script>
@else
    <div class="row bg-light">
        <div class="col-md-4">
            <div class="card">
                <div class="head">
                    <h4 class="card-title">
                        Payment History
                    </h4>
                </div>
                <div class="body">
                    <strong>Enrolled Date:</strong>{{$enrollment->enroll_date}}
                    <br />
                    <strong>Admission Fee:</strong> {{ default_currency( $program->active_fees->admission_fee ?? 0 ) }}
                    <br />
                    <strong>Last Paid Amount:</strong> {{ default_currency( $last_payment->amount ?? 0) }} ({{ ucwords(strtolower($last_payment->source ?? "NaN")) }})
                    <hr />
                    <strong>Total Paid :</strong> {{ default_currency($last_payment->student_fee->total_amount ?? 0) }}
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div id="payment_message"></div>
            <form id="add_fee_payment_detail" action="{{ route('admin.program.fee.admin_store_student_fee',[$program->id,$member->id]) }}" method="post">
                @csrf
                <div class="card">
                    <div class="head">
                        <h4 class="card-title">
                            Add Fee
                        </h4>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Amount
                                        <sup class="text-danger">*</sup>
                                    </strong>
                                    <input type="text" name="amount" id="amount" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Source
                                        <sup class="text-danger">
                                            *
                                        </sup>
                                    </strong>
                                    <select name="source" id="source" class="form-control">
                                        <option value="cash">Cash</option>
                                        <option value="ips">IPS</option>
                                        <option value="Fonepay">Fonepay</option>
                                        <option value="esewa">Esewa</option>
                                        <option value="esewa">Card</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <strong>
                                        Remarks / Source Detail
                                        <sup class="text-danger">*</sup>
                                    </strong>
                                    <textarea name="source_detail" id="source_detail"  class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row d-none">
                            <div class="col-md-6" id="cash_voucher">
                                <div class="form-group">
                                    <strong>
                                        Voucher / Receipt No.
                                    </strong>
                                    <input type="text" name="cash_voucher_no" class="form-control" id="cash_voucher_field" />
                                </div>
                            </div>
                            <div class="col-md-6" id="ips_account" style="display:none">
                                <div class="form-group">
                                    <strong>
                                        IPS Username / Phone
                                    </strong>
                                    <input type="text" name="ips_account" class="form-control" id="ips_account_field" />
                                </div>
                            </div>
                            <div class="col-md-6" id="fone_payaccount">
                                <div class="form-group">
                                    <strong>
                                        Linked Bank Account / Fonepay account
                                    </strong>
                                    <input type="text" name="fonepay_account" id="fonepay_account_field" class="form-control" /> 
                                </div>
                            </div>
                            <div class="col-md-6" id="esewa_account">
                                <div class="form-group">
                                    <strong>
                                        Esewa UserID
                                    </strong>
                                    <input type="text" name="esewa_account" id="esewa_account_field" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6" id="card_account">
                                <div class="form-group">
                                    <strong>Card Number</strong>
                                    <input type="text" name="card_number" id="card_number_field" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6" id="card_account_number">
                                <div class="form-group">
                                    <strong>
                                        Bank Name
                                    </strong>
                                    <input type="text" name="bank_name" id="bank_name_field_card" class="form-control" /> 
                                </div>
                            </div>

                            <div class="col-md-6" id="deposit_account">
                                <div class="form-group">
                                    <strong>
                                        Bank Voucher Number
                                    </strong>
                                    <input type="text" name="voucher_number" id="deposit_account_field" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-block btn-info">
                                    Save Fee Information
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $("form#add_fee_payment_detail").submit(function(event){
            $("#payment_message").empty();
            event.preventDefault();
            $.ajax({
                type : "POST",
                url : $(this).attr('action'),
                data : $(this).serializeArray(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success : function (response) {
                    if (response.success == true ) {
                        $("#payment_message").html("<div class='col-md-12 alert alert-success'>"+response.message+"</div>")
                    } else {
                        $("#payment_message").html("<div class='col-md-12 alert alert-danger'>"+response.message+"</div>")
                    }
                },
                error : function (response) {

                }
            })
        });
    </script>
@endif
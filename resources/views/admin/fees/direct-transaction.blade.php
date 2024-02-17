@extends('layouts.admin.master')
@push('page_title') Program > Transaction > Add Transasction @endpush
@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">
            {{-- <a href="{{route('admin.program.admin_program_detail',['program' => $program])}}"> Programs</a> / <a href="">Transactions</a> / </span> {{$member->full_name}} --}}
    </h4>
    <div class="row mb-2">
        <div class="col-md-12 d-flex justify-content-between">

            {{-- <a href="{{ route('admin.program.fee.admin_fee_overview_by_program', ['program' => $program])   }}" class="btn btn-danger btn-icon">
                <i class="fas fa-arrow-left"></i>
            </a>
            <button data-bs-target="#quickUserView" data-bs-toggle="modal" data-action="{{route('admin.modal.display',['view' => 'programs.guests.index','program' => $program->getKey()])}}" class="btn btn-primary btn-icon ajax-modal">
                <i class="fas fa-plus"></i>
            </button> --}}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            
            <form action="{{url()->full()}}" method="post" class="ajax-form">
                <div class="card">
                    <h5 class="card-header">Add Transaction</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="selectProgram">Select Program
                                        <sup class="text-danger">*</sup>
                                    </label>
                                    <select name="program" id="program" class="form-control">
                                        @foreach (App\Models\Program::get() as $program)
                                            <option value="{{$program->getKey()}}" @if($program->getKey() == 5) selected @endif>
                                                {{$program->program_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
        
                        <div class="row my-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="member_name">
                                        Full Name
                                        <sup class="text-danger">*</sup>
                                    </label>
                                    <input type="text" name="full_name" value="{{$member?->full_name}}" id="member_name" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone_number">
                                        Phone Number
                                        <sup class="text-danger">*</sup>
                                    </label>
                                    <input type="text" name="phone_number" value="{{$member?->phone_number}}" id="phone_number" class="form-control" />
                                </div>
                            </div>
                        </div>
        
                        <div class="row my-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="voucher_type">Voucher Type
                                        <sup class="text-danger">*</sup>
                                    </label>
                                    <select onchange="window.selectElementChange(this,'voucher_type')"  name="voucher_type" id="voucher_type" class="form-control">
                                        <option selected value="voucher_entry">Voucher Entry</option>
                                        <option value="voucher_upload">Bank Voucher</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6 voucher_type voucher_entry">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="voucher_number">Voucher Number
                                                <sup class="text-danger">*</sup>
                                            </label>
                                            <input type="text" name="voucher_number" id="voucher_number" class="form-control" />
                                        </div>        
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="form-group">
                                            <label for="voucher_type_upload">Upload Voucher</label>
                                            <input type="file" name="voucher_type_upload" id="voucher_type_upload" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 d-none voucher_type voucher_upload">
                                <div class="form-group">
                                    <label for="voucher_number">Bank Voucher Upload
                                        <sup class="text-danger">*</sup>
                                    </label>
                                    <input type="text" name="voucher_upload" id="voucher_number" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount">Amount
                                        <sup class="text-danger">*</sup>
                                    </label>
                                    <input type="text" name="amount" id="amount" class="form-control" />
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="full_address">
                                        Full Address
                                        <sup class="text-danger">*</sup>
                                    </label>
                                    <textarea name="full_address" id="full_address" class="form-control" placeholder="Country, City/Provience, Street Address"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        @if( ! $member)
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="create_account">
                                            Create Account
                                        </label>
                                        <select onchange="window.selectElementChange(this,'create_account')" name="create_account" id="create_account" class="form-control">
                                            <option value="" disabled selected>Select Option for Online Account</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 create_account yes d-none">
                                    <div class="row">
                                        <div class="col-md-12 alert alert-danger">
                                            User will be enrolled in default section and active batch
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="email">Email
                                                    <sup class="text-danger">*</sup>
                                                </label>
                                                <input type="email" name="email" id="email" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <div class="form-group">
                                                <label for="password">Password
                                                    <sup class="text-danger">*</sup>
                                                </label>
                                                <input type="password" name="password" id="password" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-primary">
                                    Save Transaction
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
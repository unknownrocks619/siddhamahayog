@extends('layouts.admin')

@section('page_css')
 <!-- BEGIN: Page CSS-->
 <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/css/core/menu/menu-types/vertical-menu.min.css') }}">
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- END: Page CSS-->
@endSection()

@section('content')
<section class="users-edit">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs mb-2" role="tablist">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center bg-success text-white" id="account-tab" data-toggle="tab"
                        href="#account" aria-controls="account" role="tab" aria-selected="true">
                        <i class="bx bx-info-circle mr-25"></i>
                        <span class="d-none d-sm-block">Personal Information</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center bg-success text-white" id="account-tab" data-toggle="tab"
                         aria-controls="information" role="tab" aria-selected="false">
                        <i class="bx bx-info-circle mr-25"></i><span class="d-none d-sm-block">User Verification</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center bg-success text-white" 
                     aria-controls="information" role="tab" aria-selected="false">
                        <i class="bx bx-info-circle mr-25"></i><span class="d-none d-sm-block">Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" 
                     aria-controls="information" role="tab" aria-selected="false">
                        <i class="bx bx-info-circle mr-25"></i><span class="d-none d-sm-block">Sewa & Reference</span>
                    </a>
                </li>
            </ul>
            <form method="POST" action=" {{ route('users.user-reference',['user_id'=>encrypt($user_detail->id)]) }} ">
                @csrf
                <div class="tab-content">
                    <div class="tab-pane active fade show" id="account" aria-labelledby="account-tab" role="tabpanel">
                        <!-- users edit account form start -->
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label class='control-label'>Referred By Center</label>
                                    @php 
                                        $allCenters = App\Models\Center::get();
                                    @endphp
                                    <select class='form-control' name='refered_branch_id'>
                                        <option>Select Center (Optional)</option>
                                        @foreach ($allCenters as $list_all_centers)
                                            <option value="{{ $list_all_centers->id }}">{{ $list_all_centers->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label class='control-label'>Referred By Person</label>
                                    <select name="refered_by_person" id="refered_by_person" class='form-control'></select>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class='row'>
                            <div class="col-md-6">
                                <div class='form-group'>
                                    <label class='control-label'>Interested Sewa</label>
                                    <select multiple='multiple' name="interested_sewa[]" class='form-control' id='interested_sewa'>
                                        @php 
                                            $allSewas = App\Models\UserSewa::get();
                                        @endphp
                                        @foreach ($allSewas as $sewa)
                                            <option value='{{ $sewa->id }}'>{{ $sewa->sewa_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class='form-group'>
                                    <label class='control-label'>Skills</label>
                                    <input type='text' name='skills' class='form-control' />
                                </div>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-12 text-right'>
                                <label class='control-label'>
                                    <input checked type="checkbox" name='make_booking' value='1' />
                                    Start Visitor Booking Registration After Completion.
                                </label>
                            </div>
                        </div>

                        <div class='row'>
                            <div class="col-md-6">
                                <input type='submit' class='btn btn-primary' value="Save & Continue" />
                            </div>
                        </div>
                        <!-- users edit account form ends -->
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endSection()

@section('page_js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#refered_by_person').select2({
            placeholder: 'Type name or Phone Number',
            tags : true,
            ajax : {
                url : '{{ url(route("get_user_list")) }}',
                dataType : 'json',
                processResults : function (data)
                {
                    // params.page = params.page || 1;
                    return {
                        results : data.results
                      
                    };
                }
            }
        });

        $("#interested_sewa").select2({
            tags: true,
            containerCssClass : "form-control"
        });
    })
</script>
@endSection()
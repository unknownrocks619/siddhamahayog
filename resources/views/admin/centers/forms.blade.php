@extends('layouts.admin')


@section('content')
<section class="users-edit">
    <div class="card">
        <div class='card-header px-2 py-2 bg-dark text-white'>
            <h4 class='card-title text-white'>Add New Center</h4>
        </div>
        <form method="POST" action="{{ route ('centers.submit_center_record') }}">
        @csrf
            <div class='card-body mt-2'>
                <div class='row'>
                    <div class='col-md-6 col-sm-12'>
                        <!-- <h5>Center Information</h5> -->
                        <div class='form-group'>
                            <label class='control-label'>Center Name</label>
                            <input type="text" name='name' class='form-control' value="" />
                        </div>
                        <div class='form-group'>
                            <label class='control-label'>Center Location</label>
                            <input type="text" name='location' class='form-control' value="" />
                        </div>
                        <div class='form-group'>
                            <label class='control-label'>Contact Number (Landline)</label>
                            <input type="text" name='landline' class='form-control' value="" />
                        </div>
                        <div class='form-group'>
                            <label class='control-label'>Google Map (Iframe)</label>
                            <textarea class='form-control' name='iframe_location'></textarea>
                        </div>


                    </div>
                    <div class='col-md-6 col-sm-12'>
                        <div class='form-group'>
                            <label class='control-label'>Center Authorized Person</label>
                            <input type="text" name='contact_person' class='form-control' value="" />
                        </div>
                        <div class='form-group'>
                            <label class='control-label'>Contact Number (Mobile)</label>
                            <input type="text" name='person_phone' class='form-control' value="" />
                        </div>

                    </div>

                </div>

                <div class='row'>
                    <button type='submit' class='btn btn-primary btn-block'>Add Center</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endSection()

@section('page_js')
<!-- <script src="{{ asset ('admin/app-assets/js/scripts/pages/dashboard-analytics.min.js') }}"></script> -->
@endSection()
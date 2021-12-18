@extends('layouts.admin')

@section('content')
<section id="headers">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('events.admin_zoom_settings_add') }}" class='btn btn-primary'>
                        Create Zoom Account
                    </a>
                </div>
                <div class='card-body'>
                    <x-alert></x-alert>
                    <table class='table table-bordered table-hover'>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Country</th>
                                <th>Zoom Account</th>
                                <th>Avaibility</th>
                                <th>Sadhaks</th>
                                <th></th>
                            </tr>
                        </thead>
`                       </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id='profile_detail_card'>
        <div class="col-8">
            <div class="card">
                <!-- Card flex-->
            </div>
        </div>
    </div>
</section>
@endSection()

@section('page_js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endSection()
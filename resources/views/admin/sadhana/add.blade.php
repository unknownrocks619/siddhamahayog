@extends('layouts.admin')

@section("page_css")
    <link href="{{ asset('css/bootstrap-switch.css') }}"  rel='stylesheet' />
@endsection

@section('content')
<section id="headers">
    <div class="row">
        <div class="col-12">
            <x-alert></x-alert>
            <form method="post" action=" {{ route('users.sadhak.submit-form') }} ">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            Add New Record
                        </h4>
                    </div>
                    <div class='card-body'>

                        <p class="card-text text-right">
                            <!-- <a href='' class='btn btn-info'>Export To Excel</a> -->
                            <a href="{{ route('users.sadhak.list') }}" class='btn btn-info'>
                                <i class='fas fa-plus'></i>
                                Go Back
                            </a>
                        </p>
                        <div class='row'>
                            <div class='col-md-12'>
                                <label class='label-control'>
                                    Application Title
                                    <span class='text-danger'>*</span>
                                </label>
                                <input type="text" name='application_title' class='form-control' required value="{{ old('application_title') }}" />
                            </div>
                            
                        </div>

                        <div class='row mt-2'>
                            <div class='col-md-6'>
                                <label class='label-control'>Total Capacity</label>
                                <input type="text" value="0" name='total_capacity' class='form-control' value="{{ old('total_capacity') }}" />
                            </div>
                            <div class='col-md-6'>
                                <label class='label-control'>Sibir Active Status</label><br />
                                <input type="checkbox" @if(old("active") == "on") checked @endif name='active'  />
                            </div>
                        </div>

                        <div class='row mt-2'>
                            <div class='col-md-6'>
                                <label class='label-control'>Sibir Start From Date</label>
                                <input type='date' name='start_date' value="{{ old('start_date') }}" name='start_date' class='form-control' />
                            </div>
                            <div class='col-md-6'>
                                <label class='label-control'>Sibir End From Date</label>
                                <input type='date' name='end_date' value="{{ old('end_date') }}" name='end_date' class='form-control' />
                            </div>
                        </div>
                    </div>

                    <div class='card-body'>
                        <div class='row'>
                            <div class='col-md-6'>
                                    <label class='label-control'>Registration Type</label>
                                    <select class='form-control' name="program_type">
                                        <option value="bod">Board Meeting</option>
                                        <option value="admin">Admins</option>
                                        <option value="public" selected>Public</option>
                                        <option value="center">Center</option>
                                        <option value="open">Open</option>
                                        <option value="country">Country</option>
                                    </select>
                                </div>
                                <div class='col-md-6'>
                                    <label class='label-control'>Program Privacy</label>
                                    <select name="privacy" id="" class="form-control">
                                        <option value="private">Private</option>
                                        <option value="protected">Protected</option>
                                        <option value="public">Public</option>
                                    </select>
                                </div>
                        </div>
                    </div>

                    <div class='card-footer'>
                        <div class='row'>
                            <div class='col-md-12'>
                                <button type='submit' class='btn btn-block btn-primary'>Create Sibir</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal -->
            <!-- start modal -->
            <div class="modal fade text-left" id="display_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title" id="myModalLabel1">User Update</h3>
                  <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                  </button>
                </div>
                <div class='modal-body'>
                  <div id="modal-content-fetch">Loading Form, Please wait...</div>
                </div>
              </div>
            </div>
          </div>

        <!-- / end modal -->

      <!-- / Modal -->
</section>
@endSection()

@section('page_js')
<script src="{{asset('js/bootstrap-switch.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
   <script type="text/javascript">
        $(document).ready(function(){
            $('#display_modal').on('shown.bs.modal', function (event) {
                $.ajax({
                    method : "GET",
                    url : event.relatedTarget.href,
                    success: function (response){
                        $("#modal-content-fetch").html(response);
                    }
                });
            })

            // bootstrap switch
            $.fn.bootstrapSwitch.defaults.size = 'large';
            $.fn.bootstrapSwitch.defaults.onColor = 'success';
            $.fn.bootstrapSwitch.defaults.offColor = 'danger';
            $.fn.bootstrapSwitch.defaults.state = true;

            $("[name='active']").bootstrapSwitch();
        });


   </script>
@endSection()
@extends('layouts.admin')

@section("page_css")
    <link href="{{ asset('css/bootstrap-switch.css') }}"  rel='stylesheet' />
@endsection

@section('content')
<section id="headers">
    <div class="row">
        <div class="col-12">
            <x-alert></x-alert>
            <form method="post" action=" {{ route('users.sadhak.update_sibir_record',[$sibir->id]) }} ">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            Update Sibir Record
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
                                <input type="text" name='application_title' class='form-control' required value="{{ old('application_title',$sibir->sibir_title) }}" />
                            </div>
                            
                        </div>

                        <div class='row mt-2'>
                            <div class='col-md-6'>
                                <label class='label-control'>Total Capacity</label>
                                <input type="text" value="{{ old('total_capacity',$sibir->total_capacity) }}" name='total_capacity' class='form-control' value="{{ old('total_capacity') }}" />
                            </div>
                            <div class='col-md-6'>
                            <span>Sibir Active Status</span><br />
                                <div class="custom-control custom-switch custom-control-inline mb-1">
                                    <input type="checkbox" name='active' class="custom-control-input" @if(old('active') == "on" || $sibir->active == true) checked @endif id="customSwitch1">
                                    <label class="custom-control-label mr-1" for="customSwitch1">
                                    </label>
                                </div>                            
                            </div>
                        </div>

                        <div class='row mt-2'>
                            <div class='col-md-6'>
                                <label class='label-control'>Sibir Start From Date</label>
                                <input type='date' name='start_date' value="{{ old('start_date',$sibir->start_date) }}" name='start_date' class='form-control' />
                            </div>
                            <div class='col-md-6'>
                                <label class='label-control'>Sibir End From Date</label>
                                <input type='date' name='end_date' value="{{ old('end_date',$sibir->end_date) }}" name='end_date' class='form-control' />
                            </div>
                        </div>

                        <hr />

                        <div class='row mt-2'>
                            @php
                                $centers = \App\Models\Center::get();
                            @endphp
                            @foreach ($centers as $center)
                                @php
                                    $is_center_allowed = \App\Models\SibirBranche::where(["branch_id"=>$center->id,'sibir_record_id'=>$sibir->id])->first();
                                @endphp
                                <div class='col-md-2 m-1 pb-2 bg-dark text-white'>
                                    <label class='control-label text-white'>{{ $center->name }}</label>
                                    <input type='checkbox' class='form-control' name='branch[]' @if($is_center_allowed && $is_center_allowed->active) checked @endif value='{{ $center->id }}' />
                                    <label class='control-label text-white mt-1'>Total capacity</label>
                                    <input type='text' class='form-control' value='{{ $is_center_allowed->capacity ?? $sibir->total_capacity }}' name='branch_capacity[{{ $center->id }}][]' />
                                </div>
                            @endforeach
                        </div>

                    </div>

                    <div class='card-body mt-2'>
                        <div class='row'>
                            <div class='col-md-4'>
                                <a href='#'>
                                    <!-- ## Configure Center -->
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class='card-footer'>
                        <div class='row'>
                            <div class='col-md-12'>
                                <button type='submit' class='btn btn-block btn-primary'>Update Sibir Record Info</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endSection()

@section('page_js')
<script src="{{asset('js/bootstrap-switch.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
   <script type="text/javascript">
        $(document).ready(function(){
            // bootstrap switch
            $.fn.bootstrapSwitch.defaults.size = 'large';
            $.fn.bootstrapSwitch.defaults.offColor = 'danger';
            $.fn.bootstrapSwitch.defaults.state = false;
            $.fn.bootstrapSwitch.defaults.onColor = 'success';
            // $.fn.bootstrapSwitch.defaults.indeterminate = true;
            $.fn.bootstrapSwitch.defaults.onInit = function (event,state) {
                console.log(event);
            }
            $('[data-toggle="switch"]').bootstrapSwitch();
                
        });


   </script>
@endSection()
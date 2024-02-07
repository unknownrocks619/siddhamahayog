@extends('layouts.admin.master')

@section('main')

    <div class="row">
        @if(in_array(auth()->user()->role_id,[App\Models\Role::SUPER_ADMIN,App\Models\Role::ADMIN,App\Models\Role::ACTING_ADMIN]))
            @php
                $lives = App\Models\Live::where('live',true)->with(['program','sections','zoomAccount'])->get();
            @endphp
            <!-- Website Analytics -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="cart-title mb-1">
                            Live Program
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-border table-hover">
                                <thead>
                                    <tr>
                                        <th>Zoom Account</th>
                                        <th>Program</th>
                                        <th>Section</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($lives as $live)
                                <tr>
                                    <td>
                                        {{ $live->zoomAccount->account_name }}
                                    </td>
                                    <td>
                                        <a href="{{route('admin.program.admin_program_detail',['program' => $live->program->getKey()])}}">
                                        {{ $live->program->program_name }}
                                        </a>
                                    </td>
                                    <td>
                                        @if($live->section_id)
                                            <span class="label label-bg-success">{{$live->programSection->section_name}}</span>
                                        @else
                                            <span class="label label-bg-primary">All Sections</span>
                                        @endif
                                    </td>                                   
                                    <td>
                                        <div class="d-flex">
                                    <button type="button"
                                            data-method="get"
                                            data-title="Re-Join Zoom Session"
                                            data-confirm="Re-joining the session will not promise to join as Host, If host permission is not available you will be assigned as co-host."
                                            data-action="{{route('admin.program.live-program-as-admin',$live->id)}}"
                                            class="clickable mx-2 btn btn-sm btn-success data-confirm">Re-Join</button>
                                    <button data-title="Confirm End Live Meeting"
                                            data-confirm="You are about to terminate the live session. This will however will not terminate zoom meeting."
                                            data-method="POST"
                                            data-action="{{route('admin.program.live_program.end',$live->id)}}"
                                            type="button" class="btn btn-sm btn-danger data-confirm">End</button>
    
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center" colspan="7">
                                        <h5 class="text-center">No Live Program at the moment.</h5>
                                    </td>
                                </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                       
                    </div>
                </div>
            </div>
            <!--/ Website Analytics -->
        @endif    

        @if(in_array(auth()->user()->role_id,[App\Models\Role::DHARMASHALA,App\Models\Role::SUPER_ADMIN,App\Models\Role::ADMIN]))
            <!-- Sales Overview -->
            <div class="col-lg-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-1">Dharmasala Quick Booking</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="search" placeholder="Booking ID" name="bookingID" id="quickCheckIn" class="form-control fs-2" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-none row " id="errorDisplay">
                            <div class="col-md-12 bg-danger fs-2 text-center text-white d-flex align-items-center justify-content-center">
                                
                            </div>
                        </div>
                        <div class="row mt-4 d-none" id="booking-status">
                            <div class="col-md-12 h-75 bg-success text-center d-flex align-items-center justify-content-center">
                                <div>
                                    <h1 class="text-white" id="RoomNumber">Your Room Number: 901</h1>
                                    <div id="Floor" class="fs-2 text-white">First Floor</div>
                                    <div id="Building" class="fs-2 text-white">Ram Niketan</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Sales Overview -->
        @endif

        
        @if(in_array(auth()->user()->role_id,[App\Models\Role::SUPER_ADMIN,App\Models\Role::ADMIN,App\Models\Role::SUPPORT]))
        <!-- Support Tracker -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Support Tracker</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-4 col-md-12 col-lg-4">
                            <div class="mt-lg-4 mt-lg-2 mb-lg-4 mb-2 pt-1">
                                <h1 class="mb-0">{{\App\Models\SupportTicket::whereNull('parent_id')->count()}}</h1>
                                <p class="mb-0">Total Tickets</p>
                            </div>
                            <ul class="p-0 m-0 d-flex">
                                <li class="d-flex gap-3 align-items-center mb-lg-3 pt-2 pb-1">
                                    <div class="badge rounded bg-label-primary p-1"><i class="ti ti-ticket ti-sm"></i></div>
                                    <div>
                                        <h6 class="mb-0 text-nowrap">New Tickets</h6>
                                        <small class="text-muted">{{\App\Models\SupportTicket::totalNewTicket()}}</small>
                                    </div>
                                </li>
                                <li class="d-flex mx-3 gap-3 align-items-center mb-lg-3 pb-1">
                                    <div class="badge rounded bg-label-info p-1"><i class="ti ti-circle-check ti-sm"></i></div>
                                    <div>
                                        <h6 class="mb-0 text-nowrap">Open Tickets</h6>
                                        <small class="text-muted">{{\App\Models\SupportTicket::totalOpenTicket()}}</small>
                                    </div>
                                </li>
                                <li class="d-flex mx-3 gap-3 align-items-center mb-lg-3 pb-1">
                                    <div class="badge rounded bg-label-info p-1"><i class="ti ti-circle-check ti-sm"></i></div>
                                    <div>
                                        <h6 class="mb-0 text-nowrap">Closed Tickets</h6>
                                        <small class="text-muted">{{\App\Models\SupportTicket::totalClosedTicket()}}</small>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-sm-8 col-md-12 col-lg-8">
                            <div id="supportTracker"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Support Tracker -->
        @endif
    </div>
@endsection

@extends('layouts.admin')

@section('page_css')

@endSection()

@section('content')
<section id="headers">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        {{ $user_detail->full_name() }} 
                        <span id='pet_name_container'>
                        @if($user_detail->pet_name)
                            ( {{ $user_detail->pet_name }} )
                        @else
                            (
                            <a 
                                data-toggle="modal" 
                                data-target="#display_modal"
                                href="{{ route('modals.display',['modal'=>'user_petname_modal','user_detail_id'=>$user_detail->id]) }}">
                               Add Pet Name
                            </a>
                            )
                        @endif
                        </span>
                    </h4>
                </div>
                @include('admin.users.detail.navigation')
               
            </div>
        </div>
    </div>
    <div class="row" id='profile_detail_card'>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __("Total Visit Log") }}</h4>
                </div>
                <div class="card-body">
                @isset($bookings)
                <table class='table table-bordered table-hover'>
                    <thead>
                        <tr>
                            <th>
                                Room Detail
                            </th>
                            <th>
                                Check In Date
                            </th>
                            <th>
                                Check Out Date
                            </th>
                            <th>Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking )
                                <tr>
                                    <td>
                                        @php
                                            $room_detail = $booking->room;
                                            echo "Room Number : " . $room_detail->room_number;
                                            echo "<br />";
                                            echo "Block / Name : " .$room_detail->room_name;
                                        @endphp
                                    </td>
                                    <td>
                                        {{ date("D M, d Y", strtotime($booking->check_in_date)) }}
                                    </td>
                                    <td>
                                        @if($booking->is_occupied)
                                            Currently Occupied 
                                        @else
                                            {{ date("D M, d Y",strtotime($booking->check_out_date)) }}
                                        @endif
                                    </td>

                                    <td>
                                        @if($booking->remarks)
                                            Check In Remark : {{ $booking->remarks }}
                                        @endif

                                        @if($booking->check_out_remark && $booking->check_out_remark->remarks && $booking->remarks != $booking->check_out_remark->remarks)
                                            <br />
                                            Check Out Remark : {{ $booking->check_out_remark->remarks }}
                                        @endif
                                    </td>
                                </tr>
                        @endforeach
                    </tbody>
                </table>
                @endisset
                </div>
            </div>
        </div>
       
    </div>

</section>
@endSection()

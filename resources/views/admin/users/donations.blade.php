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
                    <h4 class="card-title">{{ __("Donation Detail") }}</h4>
                </div>
                <div class="card-body">
                <table class='table table-bordered table-hover'>
                    <thead>
                        <tr>
                            <th>
                                Donation Amount
                            </th>
                            <th>
                                Date
                            </th>
                            <th>
                                Source
                            </th>
                            <th>Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($don_transactions as $transaction)
                            <tr>
                                <td>
                                    {{ $transaction->donation_amount }}
                                </td>
                                <td>
                                    {{ date("D M d, Y" , strtotime($transaction->created_at)) }}
                                </td>
                                <td>
                                    @if($transaction->source == "Visit")
                                        Ashram Visitor
                                    @endif

                                    @if($transaction->bookings_id)
                                        <br />
                                        @php 
                                            $booking = $transaction->booking;
                                            echo "Check In Date : " . date( "D M, d Y" ,strtotime($booking->check_in_date));
                                            if($booking->is_occupied) {
                                                echo "<span class='text-success'>User In Ashram</span>";
                                            } else {
                                                echo "<br />";
                                                echo "Check Out Date : " . date("D M, d Y",strtotime($booking->check_out_date));
                                                echo "<br />";
                                            }
                                        @endphp
                                    @endif
                                </td>
                                <td>
                                    {{ $transaction->remark }}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan='3' class='text-right'>Total Donation</td>
                            <td>Nrs {{ $donation->amount ?? 0 }}</td>
                        </tr>
                    </tbody>
                </table>
                    
                </div>
            </div>
        </div>
       
    </div>

</section>
@endSection()

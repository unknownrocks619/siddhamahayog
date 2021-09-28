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
                <table class='table table-bordered table-hover'>
                    <thead>
                        <tr>
                            <th>
                                Sewa Name
                            </th>
                            <th>
                                Description
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($involved_sewas as $sewa )
                        @php 
                                $sewa_table = $sewa->usersewa;
                        @endphp
                            <tr>
                                <td>{{ $sewa_table->sewa_name }}</td>
                                <td>
                                    @if($sewa->bookings_id)
                                        <span class='text-success'>User Visited Ashram To Provide Sewa.</span>
                                        <br />
                                        <table class='table table-hover'>
                                            <tr class='bg-light text-white'>
                                                <td>Check In</td>
                                                <td>Check Out</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{ date("D M,d Y",strtotime($sewa->booking->check_in_date))  }}
                                                </td>
                                                <td>
                                                    @if ($sewa->booking->is_occupied)
                                                        User still active
                                                    @else
                                                        {{ date("D M,d Y",strtotime($sewa->booking->check_out_date)) }}
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                    
                </div>
            </div>
        </div>
       
    </div>

</section>
@endSection()

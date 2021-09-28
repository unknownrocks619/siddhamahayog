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
    <div class="row">
        @foreach ($medias as $media)
            @php
                                
            @endphp
        <div class="col-md-4">
            <div class="card">
                <img src="{{ asset ($media->image_url) }}" />
                <div class='card-footer text-center text-primary'>
                    {{ $media->created_at }}
                    <br />
                    <small>Visited Date</small>
                </div>
            </div>
        </div>
        @endforeach
       
    </div>

</section>
@endSection()

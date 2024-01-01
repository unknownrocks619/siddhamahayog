@extends('layouts.admin.master')
@push('page_title') Support > Response @endpush
@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Supports/</span> Update
    </h4>
    <div class="row mb-2">
        <div class="col-md-12 text-end">
            <a href="{{route('admin.supports.tickets.list',['type' => request()->type,'filter' => request()->filter])}}" class="btn btn-danger btn-icon">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
    </div>

    <!-- Responsive Datatable -->
    <div class="container-fluid">
        <div class="row g-0">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body app-chat card overflow-scroll">
                        <div class="col app-chat-history">
                            <div class="chat-history-wrapper">
                                <div class="chat-history-header border-bottom">
                                    <h4 class="text-primary">
                                        {{$ticket->title}}
                                    </h4>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex overflow-hidden align-items-center">
                                            <i class="ti ti-menu-2 ti-sm cursor-pointer d-lg-none d-block me-2" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-contacts"></i>
                                            @if($ticket->user->profileImage)
                                            <div class="flex-shrink-0 avatar">
                                                <img src="{{\App\Classes\Helpers\Image::getImageAsSize($ticket->user->profileImage->filepath,'xs')}}" alt="Avatar" class="rounded-circle" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-sidebar-right">
                                            </div>
                                            @endif
                                            <div class="chat-contact-info flex-grow-1 ms-2">
                                                <h6 class="m-0">{{$ticket->user->full_name}}</h6>
                                                <small class="user-status text-muted">{{$ticket->user->email}}</small>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <button data-confirm="You are about to close current ticket. User Will receive notification about the change. Do you still wish to continue." class="btn btn-danger btn-icon data-confirm" data-method="post" data-action="{{route('admin.supports.tickets.close',$ticket->id)}}" data-bs-toggle="tooltip" data-bs-original-title="Close Ticket"><i class="fas fa-close"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="chat-history-body bg-body overflow-scroll">
                                    <ul class="list-unstyled chat-history">
                                        <li class="chat-message">
                                            <div class="d-flex overflow-hidden">
                                                    @if($ticket->user->profileImage)
                                                        <div class="user-avatar flex-shrink-0 me-3">
                                                            <div class="avatar avatar-sm">
                                                                <img src="{{\App\Classes\Helpers\Image::getImageAsSize($ticket->user->profileImage->filepath,'xs')}}" alt="Avatar" class="rounded-circle">
                                                            </div>
                                                        </div>
                                                   @endif
                                                <div class="chat-message-wrapper flex-grow-1">
                                                    <div class="chat-message-text mt-2">
                                                        {!! $ticket->issue !!}
                                                        @if($ticket->media)
                                                            <img src='{{ asset($ticket->media->path) }}' class="img-fluid" />
                                                        @endif
                                                    </div>
                                                    <div class="text-muted mt-1">
                                                        <small>{{date('H:i A', strtotime($ticket->created_at))}}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        @php
                                            $allTicketResponses = App\Models\SupportTicket::where('parent_id', $ticket->id)
                                                                ->with(
                                                                        [
                                                                            'user' => function($query)
                                                                                        {
                                                                                            $query->with(['profileImage']);
                                                                                        },
                                                                            'staff' => function($query) {
                                                                                $query->with(['profileImage']);
                                                                            }])->get();
                                        @endphp

                                        @foreach($allTicketResponses as $replyTicket)

                                            @if( ! $replyTicket->replied_by)
                                                <li class="chat-message">
                                                    <div class="d-flex overflow-hidden">
                                                        @if($replyTicket->user->profileImage)
                                                            <div class="user-avatar flex-shrink-0 me-3">
                                                                <div class="avatar avatar-sm">
                                                                    <img src="{{\App\Classes\Helpers\Image::getImageAsSize($replyTicket->user->profileImage->filepath,'xs')}}" alt="Avatar" class="rounded-circle">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="chat-message-wrapper flex-grow-1">
                                                            <div class="chat-message-text mt-2">
                                                                {!! $replyTicket->issue !!}
                                                                @if($replyTicket->media)
                                                                    <img src='{{ asset($replyTicket->media->path) }}' class="img-fluid" />
                                                                @endif
                                                            </div>
                                                            <div class="text-muted mt-1">
                                                                <small>{{date('H:i A', strtotime($replyTicket->created_at))}}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @else
                                                <li class="chat-message chat-message-right">
                                                    <div class="d-flex overflow-hidden">
                                                        <div class="chat-message-wrapper flex-grow-1">
                                                            <div class="chat-message-text">
                                                                <div class="mb-0">{!! $replyTicket->issue !!}</div>
                                                            </div>
                                                            <div class="text-end text-muted mt-1">
                                                                <i class='ti ti-checks ti-xs me-1 text-success'></i>
                                                                <small>{{date('H:i A', strtotime($replyTicket->created_at))}}</small>
                                                            </div>
                                                        </div>
                                                        @if($replyTicket->staff->profileImage)
                                                            <div class="user-avatar flex-shrink-0 ms-3">
                                                                <div class="avatar avatar-sm">
                                                                    <img src="{{\App\Classes\Helpers\Image::getImageAsSize($replyTicket->staff->profileImage->filepath,'xs')}}" alt="Avatar" class="rounded-circle">
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>

                                @if($ticket->status != 'completed')
                                    <!-- Chat message form -->
                                    <div class="chat-history-footer">
                                    <form method="post" action="{{ route('admin.supports.tickets.store',$ticket->id) }}" class="form-send-message d-flex justify-content-between align-items-center ajax-form ajax-append">
                                        <div class="row d-none">
                                            <div class="col-md-12">

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <textarea name="issue" class="tiny-mce form-control message-input border-0 me-3 shadow-none" placeholder="Type your message here"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="message-actions d-flex align-items-center">
{{--                                            <label for="attach-doc" class="form-label mb-0">--}}
{{--                                                <i class="ti ti-photo ti-sm cursor-pointer mx-3"></i>--}}
{{--                                                <input type="file" id="attach-doc" hidden>--}}
{{--                                            </label>--}}
                                            <button class="btn btn-primary d-flex send-msg-btn">
                                                <i class="ti ti-send me-md-1 me-0"></i>
                                                <span class="align-middle d-md-inline-block d-none">Send</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page_css')
    <link rel="stylesheet" href="{{ asset ('themes/admin/assets/vendor/css/pages/app-chat.css')}}">
@endpush

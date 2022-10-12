@extends("layouts.portal.app")

@section("page_title")
Support Ticket
@endsection

@section("page_css")
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css" />


@endsection


@section("content")
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Support Tickets</h2>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-8">
                <div class="card">
                    <div class="header">
                        <h2><strong>Support</strong> Ticket </h2>
                        <ul class="header-dropdown">
                            <li class="dropdown">
                                <a href="{{ route('admin.suppports.tickets.list') }}" class="dropdown-toggle btn btn-danger btn-sm" role="button">
                                    <i class="zmdi zmdi-close"></i>
                                    Close
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        @if(Session::has('success'))
                        <div class="alert alert-success alert-dismissible mb-2" role="alert">
                            <button type="button" class="close text-info" data-dismiss="alert" aria-label="close">
                                x
                            </button>
                            <div class='d-flex align-items-center'>
                                <i class="bx bx-check"></i>
                                <span>{{ Session::get('success') }}</span>
                            </div>
                        </div>
                        @endif
                        @if(Session::has('error'))
                        <div class="alert alert-danger alert-dismissible mb-2" role="alert">
                            <button type="button" class="close text-info" data-dismiss="alert" aria-label="close">
                                x
                            </button>
                            <div class='d-flex align-items-center'>
                                <i class="bx bx-check"></i>
                                <span>{{ Session::get('error') }}</span>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <h4>
                                    {{ $ticket->title }}
                                </h4>
                                <div>
                                    {!! $ticket->issue !!}
                                </div>
                                @if($ticket->media)
                                <div class="mt-3">
                                    <img src='{{ asset($ticket->media->path) }}' class="img-fluid" />
                                </div>
                                @endif
                            </div>
                        </div>
                        <?php
                        $all_reply = App\Models\SupportTicket::where('parent_id', $ticket->id)->get();
                        ?>
                        @foreach ($all_reply as $reply)
                        <div class="row">
                            <div class="col-md-12">
                                <h4>{{ $reply->title }}</h4>
                                <div>
                                    {!! $reply->issue !!}
                                </div>
                                @if($reply->status == "waiting_response")
                                <a href="" class="text-danger">Delete</a>
                                @endif
                            </div>
                        </div>
                        @endforeach

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <form action="{{ route('admin.suppports.tickets.close',$ticket->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">Close Ticket</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if( $ticket->status != "completed")
            <div class="col-lg-4">
                <form action="{{ route('admin.suppports.tickets.store',$ticket->id) }}" method="post">
                    @csrf
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong>Reply</strong> Ticket
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <strong>
                                            Title
                                            <sup class="text-danger">*</sup>
                                        </strong>
                                        <input type="text" name="title" id="title" class="form-control @error('title') border border-danger @enderror" />
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="form-group">
                                        <strong>
                                            Solution / Response
                                        </strong>
                                        <textarea name="issue" id="issue" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <button type="submit" class="btn btn-primary">Reply</button>
                        </div>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection

@section("modal")
<!-- Large Size -->
<div class="modal fade" id="addBatch" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="modal_content">
            <div class="moda-body">
                <p>Please wait...loading your data</p>
            </div>
        </div>
    </div>
</div>

@endsection


@section("page_script")
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
@endsection
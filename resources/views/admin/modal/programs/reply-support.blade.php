@php
    $ticket = \App\Models\SupportTicket::where('id',request()->ticket)->first();
@endphp
<form method="post" class="ajax-form" action="{{ route('admin.supports.tickets.store',$ticket->getKey()) }}">

    <div class="modal-header">
        <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        <div class="row bg-light">
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
        @php
            $replies = App\Models\SupportTicket::where('parent_id', $ticket->getKey())->get();
        @endphp

        @foreach ($replies as $reply)
            <div class="row my-1 p-2">
                <div class="col-md-12 bg-light pt-2">
                    <div>
                        {!! $reply->issue !!}
                    </div>
                    @if($reply->status == "waiting_response")
                        <a href="" class="text-danger">Delete</a>
                    @endif
                </div>
            </div>
        @endforeach

        <div class="row border-top  mt-3">
            <h4 class="mt-3">
                Send New Reply
            </h4>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control" />
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="form-group">
                    <label for="issue">
                        Solution / Response
                    </label>
                    <textarea name="issue" id="issue" class="form-control tiny-mce"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row">
            <div class="col-md-12 text-end">
                <button class="submit btn btn-primary">
                    Reply Ticket
                </button>
            </div>
        </div>
    </div>
</form>
<script>
    window.setupTinyMce();
</script>

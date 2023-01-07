@extends("frontend.theme.portal")

@section("title")
Ticket > {{ $ticket->title }}
@endsection

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">
            <a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light">
            <a href="{{ route('supports.staff.tickets.index') }}">Support</a> /
        </span>
        {{ $ticket->title }}
    </h4>

    <div class="row mb-3">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between pb-0">
                <div class="card-header mb-0 p-0">
                    <a href="{{ route('supports.staff.tickets.index') }}" class="btn btn-success">Go Back</a>
                </div>
            </div>
            <div class="card-body">
                <div class="col-md-12 py-2 bg-light">
                    <h4 class="card-header">{{ $ticket->title }} :: {!! __("support.".$ticket->priority) !!}
                        :: {!! __("support.".$ticket->category) !!}</h4>
                    <div class="card-text ms-4">{!! $ticket->issue !!}</div>
                    @if($ticket->media && isset($ticket->media->path))
                    <div class="border p-3 ms-4">
                        <a target="_blank" href="{{ asset($ticket->media->path)  }}"> {{ $ticket->media->original_filename }}</a>
                    </div>
                    @endif
                </div>

                @forelse ($replies as $reply)
                <hr />

                <div class="row @if($reply->replied_by) bg-warning text-white py-2 @endif">
                    <div class="col-md-9">
                        <div class="card-text ms-4">{!! $reply->issue !!}</div>
                        @if($reply->media && isset($reply->media->path))
                        <div class="border p-3 ms-4">
                            <a target="_blank" href="{{ asset($reply->media->path)  }}"> {{ $reply->media->original_filename }}</a>
                        </div>
                        @endif
                    </div>
                    @if($reply->replied_by)
                    <div class="col-md-3">
                        <div class="card-text ms-4 text-muted">
                            Replied By: {{ $reply->staff->full_name }}
                        </div>
                    </div>
                    @else
                    <div class="col-md-3">
                        <div class="card-text ms-4 text-muted">
                            Owner: {{ $reply->user->full_name }}
                            <span class="text-primary">&lt;{{ $reply->user->email }}&gt;</span>
                        </div>
                    </div>
                    @endif
                </div>
                @empty
                <hr />
                @endforelse
            </div>
        </div>
    </div>
    @if($ticket->status != "completed" && $ticket->status != "rejected")

    <div class="row bg-light">
        <div class="col-md-12">
            <x-alert></x-alert>
            <div class="card mb-4">
                <form action="{{ route('supports.staff.tickets.destroy',$ticket->id) }}" method="post">
                    @method("DELETE")

                    <div class="card-header d-flex align-items-center justify-content-between pb-0">
                        <div class="card-header mb-0 p-0">
                            <h5 class="">Reply Ticket</h5>
                        </div>
                        <div class="dropdown">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                Close this Ticket
                            </button>
                        </div>
                    </div>
                </form>
                <form enctype="multipart/form-data" action="{{ route('supports.staff.tickets.update',$ticket->id) }}" method="post">
                    @csrf
                    @method("PUT")
                    <div class="card-body">
                        <div class="mt-3">
                            <label for="defaultFormControlInput" class="form-label">Message</label>
                            <textarea name="message" class="form-control @error('message') border border-danger @enderror" id="message" cols="30" rows="10">{{ old('message') }}</textarea>
                            @error("message")
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Reply</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    @endif
</div>
@endsection


@push("custom_script")
<script src="https://cdn.tiny.cloud/1/gfpdz9z1bghyqsb37fk7kk2ybi7pace2j9e7g41u4e7cnt82/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'advlist autolink lists link charmap  pagebreak',
        toolbar_mode: 'floating',
    });
</script>
@endpush
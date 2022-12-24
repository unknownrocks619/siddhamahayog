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
            <a href="{{ route('user.account.support.ticket.index') }}">Support</a> /
        </span>
        {{ $ticket->title }}
    </h4>

    <div class="row mb-3">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between pb-0">
                <div class="card-header mb-0 p-0">
                    <a href="{{ route('user.account.support.ticket.index') }}" class="btn btn-success">Go Back</a>
                </div>
            </div>
            <div class="card-body">
                <div class="col-md-4">
                    <h4 class="card-header">{{ $ticket->title }}</h4>
                    <div class="card-text ms-4">
                        {!! (strip_tags($ticket->issue,
                        "<blockquote><b><em><strong><span>
                                            <p>
                                            <div>")) !!}

                                            </div>
                                            @if($ticket->media && isset($ticket->media->path))
                                            <div class="border p-3 ms-4">
                                                <a target="_blank" href="{{ asset($ticket->media->path)  }}"> {{ $ticket->media->original_filename }}</a>
                                            </div>
                                            @endif
                    </div>

                    @forelse ($replies as $reply)
                    <hr />
                    <div class="col-md-4">
                        <!-- <h4 class="card-header">{{-- $reply->title --}}</h4> -->
                        <div class="card-text ms-4">{!! $reply->issue !!}</div>

                        @if($reply->media && isset($reply->media->path))
                        <div class="border p-3 ms-4">
                            <a target="_blank" href="{{ asset($reply->media->path)  }}"> {{ $reply->media->original_filename }}</a>
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
                    <form action="{{ route('user.account.support.ticket.close',$ticket->id) }}" method="post">
                        <div class="card-header d-flex align-items-center justify-content-between pb-0">
                            <div class="card-header mb-0 p-0">
                                <h5 class="">Open Ticket</h5>
                            </div>
                            <div class="dropdown">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    Close this Ticket
                                </button>
                            </div>
                        </div>
                    </form>
                    <form enctype="multipart/form-data" action="{{ route('user.account.support.ticket.reply',$ticket->id) }}" method="post">
                        @csrf
                        <div class="card-body">

                            <div class="mt-3">
                                <label for="defaultFormControlInput" class="form-label">Message</label>
                                <textarea name="message" class="form-control @error('message') border border-danger @enderror" id="message" cols="30" rows="10">{{ old('message') }}</textarea>
                                <div id="messageResponse" class="form-text">
                                    We typically reply within 24 hours
                                </div>
                                @error("message")
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-3">
                                <label for="Attachments" class="form-label">Attachments</label>
                                <input type="file" name="media" id="Attachments" class="form-control " accept="image/*" />
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
@extends("frontend.theme.portal")

@section("title")
Notes > Create New
@endsection

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">
            <a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light">
            <a href="{{ route('user.account.notes.notes.index') }}">Notes</a> /
        </span>
        New Note
    </h4>

    <div class="row">
        <div class="col-md-12">
            <x-alert></x-alert>
            <form action="{{ route('user.account.notes.notes.store') }}" method="post">
                @csrf
                <div class="card mb-4">
                    <div class="card-header  d-flex align-items-center justify-content-between pb-0">
                        <div class="card-title">
                            <h5>Add Your Note</h5>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-danger clickable" data-href="{{ route('user.account.notes.notes.index') }}" type="button" id="orederStatistics">
                                <i class='bx bx-block'></i>
                                Close
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <label for="defaultFormControlInput" class="form-label">Title</label>
                            <input type="text" class="form-control @error('title')border border-danger @enderror" value="{{ old('title') }}" id="defaultFormControlInput" placeholder="Note title" aria-describedby="defaultFormControlHelp" name="title">
                            @error("title")
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="defaultFormControlInput" class="form-label">Note</label>
                            <textarea name="notes" class="form-control" id="notes" cols="30" rows="10">{{ old('notes') }}</textarea>
                            <div id="defaultFormControlHelp" class="form-text">
                                We'll never share your details with anyone else.
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save Note</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection

@push("custom_script")
<script src="https://cdn.tiny.cloud/1/gfpdz9z1bghyqsb37fk7kk2ybi7pace2j9e7g41u4e7cnt82/tinymce/6/tinymce.min.js" referrerpolicy="origin"> </script>
<script type="text/javascript">
    tinymce.init({
        selector: 'textarea'
    });
</script>
@endpush
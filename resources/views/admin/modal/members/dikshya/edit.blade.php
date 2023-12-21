
@php
$dikshya = \App\Models\MemberDikshya::where('id',request()->dikshyaID)->first();
@endphp
<form method="post" class="ajax-form" action="{{ route('admin.member-dikshya.edit',['dikshya' => $dikshya,'member' => request()->member]) }}">

    <div class="modal-header border-bottom">
        <h1>
            Update user dikshya info
        </h1>
        <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body p-2 mt-4">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="dikshya_type">Select User Dikshya</label>
                    <select name="dikshya_type" id="dikshya_type" class="form-control">
                        <option value="sadhana" @if($dikshya->dikshya_type == 'sadhana') selected @endif>Sadhana</option>
                        <option value="saranagati" @if($dikshya->dikshya_type == 'saranagati') selected @endif>Saranagati</option>
                        <option value="tarak" @if($dikshya->dikshya_type == 'tarak') selected @endif>Tarak</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="dikshya_date">Dikshya Date</label>
                    <input type="date" name="dikshya_date" value="{{$dikshya->ceromony_date}}" id="dikshya_date" class="form-control">
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="location">Dikshya Location</label>
                    <input type="text" name="location" value="{{$dikshya->ceromony_location}}" id="location" class="form-control" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="verified">Dikshya Name</label>
                    <input type="text" name="dikshya_name" value="{{$dikshya->guru_name}}" id="dikshya_name" class="form-control">
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <div class="row">
            <div class="col-md-12 text-end">
                <button class="submit btn btn-primary">
                    Update Information
                </button>
            </div>
        </div>
    </div>
</form>

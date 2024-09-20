
@php
$sadhanaLevel = \App\Models\UserSadhanaLevel::where('id_usl',request()->sadhanaID)->first();
@endphp
<form method="post" class="ajax-form" action="{{ route('admin.member-sadhana.edit',['sadhana' => $sadhanaLevel,'member' => request()->member]) }}">

    <div class="modal-header border-bottom">
        <h1>
            Update user Sadhana Level
        </h1>
        <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body p-2 mt-4">
<div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="charan">Charan</label>
                        <input type="number" value="{{$sadhanaLevel->charan_usl}}" class="form-control" name="charan" id="charan" max="6" min='0' />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="charan">Upacharan</label>
                        <input type="number" value="{{$sadhanaLevel->upacharan_usl}}" class="form-control" name="upacharan" id="charan" min='1' max=6 />
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Charan Data</label>
                        <input type="date" value="{{$sadhanaLevel->charan_date_usl}}" name="charan_date" class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Upacharan Data</label>
                        <input type="date" value="{{$sadhanaLevel->upacharan_date_usl}}" name="upacharan_date" class="form-control">
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

<div class="card card-action">
    <form method="post" action="{{route('admin.member-sadhana.add',['member' => $member])}}" class="ajax-form">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="charan">Charan</label>
                        <input type="number" class="form-control" name="charan" id="charan" max="6" min='0' />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="charan">Upacharan</label>
                        <input type="number" class="form-control" name="upacharan" id="charan" min='1' max=6 />
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Charan Data</label>
                        <input type="date" name="charan_date" class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Upacharan Data</label>
                        <input type="date" name="upacharan_date" class="form-control">
                    </div>
                </div>

            </div>

        </div>

        <div class="card-footer">
            <div class="row mt-2">
                <div class="col-md-12 text-end">
                    <button type='submit' class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>



<h3 class="mt-3">Available Sadhana Level</h3>
    

@foreach (App\Models\UserSadhanaLevel::get() as $sadhanaLevel)
<div class="row bg-white py-2 mb-2 align-items-center">
    <div class="col-md-5">
        <span class="fs-3">Charan: {{$sadhanaLevel->charan_usl}}</span>
        @if($sadhanaLevel->charan_date_usl)
            <br />
            <span class="fs-3">{{$sadhanaLevel->charan_date_usl}}</span>
        @endif
    </div>
    <div class="col-md-5">
        <span class="fs-4">Sub Charan: {{$sadhanaLevel->upacharan_usl}}</span>
        @if($sadhanaLevel->upacharan_date_usl)
        <br />
        <span class="fs-4">{{$sadhanaLevel->upacharan_date_usl}}</span>
        @endif
    </div>
    <div class="col-md-2 text-end">
        <a href="" class="btn btn-icon btn-primary ajax-modal" data-action="{{route('admin.modal.display',['view' => 'members.sadhana.edit','member'=>$sadhanaLevel->user_ud,'sadhanaID' => $sadhanaLevel->getKey()])}}" data-bs-target="#sadhanaInfoPopUp" data-bs-toggle="modal">
            <i class="ti ti-edit"></i>
        </a>
        <a href="#" class="btn btn-icon btn-danger data-confirm" data-action="{{route('admin.member-sadhana.delete',['sadhana'=>$sadhanaLevel,'member' => $sadhanaLevel->user_id])}}" data-method="post">
            <i class="ti ti-trash"></i>
        </a>
        
    </div>
</div>
@endforeach
<x-modal modal="sadhanaInfoPopUp"></x-modal>


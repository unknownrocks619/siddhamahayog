@php
    /** @var  \App\Models\Member $member */
   $dikshyaInfos = \App\Models\MemberDikshya::where('member_id',$member->getKey())->get();
@endphp

<!-- Project table -->
<div class="card mb-4">
    <h5 class="card-header">Member Dikshya Information</h5>
    <div class="row p-4">
        <div class="col-md-12 text-end">
            <a href="#dikshyaInformation" role="button" class="btn btn-primary" data-bs-toggle="collapse">
                <i class="fas fa-plus"></i>
                Add Dikshya Info
            </a>
        </div>
        <div class="collapse" id="dikshyaInformation">
            <form method="post" action="{{route('admin.member-dikshya.add',['member' => $member])}}" class="ajax-form">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dikshya_type">Select User Dikshya</label>
                            <select name="dikshya_type" id="dikshya_type" class="form-control">
                                <option value="sadhana">Sadhana</option>
                                <option value="saranagati">Saranagati</option>
                                <option value="tarak">Tarak</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dikshya_date">Dikshya Date</label>
                            <input type="date" name="dikshya_date" value="" id="dikshya_date" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="location">Dikshya Location</label>
                            <input type="text" name="location" value="" id="location" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="verified">Dikshya Name</label>
                            <input type="text" name="dikshya_name" value="" id="dikshya_name" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                        Add Diksya Category
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>

    <div class="table-responsive mb-3">
        <table class="table datatable-project border-top">
            <thead>
            <tr>
                <th>Dikshya Type</th>
                <th class="text-nowrap">Dikshya Name</th>
                <th>Location</th>
                <th>Date</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
                @foreach ($dikshyaInfos as $dikshya_info)
                    <tr>
                        <td>
                            {{ucwords($dikshya_info->dikshya_type)}}
                        </td>
                        <td>
                            {{$dikshya_info->guru_name}}
                        </td>
                        <td>
                            {{ $dikshya_info->ceromony_location }}
                        </td>
                        <td>
                            {{$dikshya_info->ceromony_date}}
                        </td>
                        <th>
                            <a href="" class="btn btn-icon btn-primary ajax-modal" data-action="{{route('admin.modal.display',['view' => 'members.dikshya.edit','member'=>$dikshya_info->member_id,'dikshyaID' => $dikshya_info->getKey()])}}" data-bs-target="#dikshyaInfoPopUp" data-bs-toggle="modal">
                                <i class="ti ti-edit"></i>
                            </a>
                            <a href="#" class="btn btn-icon btn-danger data-confirm" data-action="{{route('admin.member-dikshya.delete',['dikshya'=>$dikshya_info,'member' => $dikshya_info->member_id])}}" data-method="post">
                                <i class="ti ti-trash"></i>
                            </a>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<x-modal modal="dikshyaInfoPopUp"></x-modal>

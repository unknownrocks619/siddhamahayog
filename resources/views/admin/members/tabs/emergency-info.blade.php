@php
    /** @var  \App\Models\Member $member */
    $emergencyContacts = \App\Models\MemberEmergencyMeta::where('member_id',$member->getKey())->get();
@endphp

    <!-- Project table -->
<div class="card mb-4">
    <div class="row p-4">
        <div class="col-md-12 text-end">
            <a href="#contactInfo" role="button" class="btn btn-primary" data-bs-toggle="collapse">
                <i class="fas fa-plus"></i>
                Add Emergency Contact
            </a>
        </div>
        <div class="collapse" id="contactInfo">
            <form method="post" action="{{route('admin.member.emergency.add',['member' => $member])}}" class="ajax-form">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact_type">Contact Type</label>
                            <select name="contact_type" id="contact_type" class="form-control">
                                <option value="emergency">Emergency</option>
                                <option value="family">Family</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" name="phone_number" value="" id="phone_number" class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" name="full_name" value="" id="full_name" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="relation">Relation</label>
                            <input type="text" name="relation" value="" id="relation" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            Save Contact
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
                <th>Full Name</th>
                <th class="text-nowrap">Relation</th>
                <th>Phone</th>
                <th>Contact Type</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            @foreach ($emergencyContacts as $emergencyContact)
                <tr>
                    <td>
                        {{ucwords($emergencyContact->contact_person)}}
                    </td>
                    <td>
                        {{$emergencyContact->relation}}
                    </td>
                    <td>
                        {{ $emergencyContact->phone_number }}
                    </td>
                    <td>
                        {{ucwords($emergencyContact->contact_type)}}
                    </td>
                    <th>
                        <a href="#" class="btn btn-icon btn-danger data-confirm" data-action="{{route('admin.member.emergency.delete',['emergencyMeta'=>$emergencyContact,])}}" data-method="post">
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

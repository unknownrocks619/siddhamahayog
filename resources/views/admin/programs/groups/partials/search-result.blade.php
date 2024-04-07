@forelse ($members as $member)
    @php
    $familyMembers = \App\Models\MemberEmergencyMeta::where('member_id' , $member->user_id)
                                                        ->where('contact_type','family')
                                                        ->get();
    @endphp
        <div class="row @if($loop->even) bg-light @endif mt-2 px-2 py-2">
            <form id="assignMember" action="{{route('admin.program.admin_add_member_to_group',['program' => $program,'group' => $group])}}" class="ajax-component-form" method="post">
                <input type="hidden" name="memberID" value="{{$member->user_id}}">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-5">
                            <h3 class="my-0 py-0 border-bottom text-info">
                                {{ str($member->first_name)->lower()->ucfirst()->value() }}
                                {{ str($member->last_name)->lower()->ucfirst()->value() }}
                            </h3>
                            <p class="py-0 my-0">
                                Email : {{ $member->email }}
                            </p>
                            <p>
                                Phone: {{ $member->phone_number }}
                            </p>
                        </div>
                        
                    </div>
                </div>

            @if($familyMembers->count())
                <div class="col-md-12 my-3 border p-1 bg-info text-white">
                    <div class="row">
                        @foreach ($familyMembers as $familyMember)
                            <div class="col-md-6">
                                <h3 class="text-danger">
                                    {{$familyMember->contact_person}}
                                </h3>
                                <p>
                                    <strong>Relation: </strong> {{$familyMember->relation}}
                                </p>
                                <p>
                                    <strong>Phone Number: </strong> {{$familyMember->phone_number}}
                                </p>
                                <p>
                                    <label class="list-group-item">
                                        <input class="form-check-input me-1" @if($familyMember->verified_family) checked @endif name="families[]" type="checkbox" value="{{$familyMember->getKey()}}">
                                            Include Family
                                    </label>
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <div class="response_message"></div>
            <div class="col-md-12 my-2 p-2 text-end">
                <button class="btn btn-primary" type="submit">Select User</button>
            </div>
        </form>
    </div>
@empty
    <div class="row mt-2">
        <div class="col-md-12">
            <h4 class="text-danger">
                Member record not found.
            </h4>
        </div>
    </div>
@endforelse

@if($members)

    <script type="text/javascript">
        $("form#assignMember").submit(function(event) {
            event.preventDefault();
            var form_message = $(this);
            $.ajax({
                type : "POST",
                data : $(this).serializeArray(),
                url : $(this).attr('action'),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {

                    if (response.success == true ) {
                        console.log(response.message);
                        $(form_message).first().find("div.response_message").addClass("alert alert-success").html(response.message);
                    } else {
                        $(form_message).first().find("div.response_message").addClass("alert alert-danger").html(response.message);

                    }
                },
                error : function (response) {
                    console.log(response);
                }
            });
        })
    </script>
@endif

@forelse ($members as $member)
    <div class="row @if($loop->even) bg-light @endif mt-2 px-2 py-2">
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
                <div class="col-md-7">
                    <form id="assignMember" method="post" action="{{ route('admin.members.admin_store_assign_member_to_program',['program' => $program->getKey()]) }}">
                        <div class="response_message"></div>
                        @csrf
                        <input type="hidden" name="student" class="form-control " value="{{$member->user_id}}">
                        <input type="hidden" name="section" value="{{$member->section_id}}" class="form-control">
                        <input type="hidden" name="batch" value="{{$programBatch->getKey()}}" class="form-control">
                        <div class="row mt-2">
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-round btn-primary btn-outline">Assign </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
                    console.log("hello");
                    console.log(response);
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

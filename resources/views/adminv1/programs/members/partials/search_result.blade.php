@forelse ($members as $member)
    <div class="row bg-grey mt-2 px-2 py-2">
        <div class="col-md-12">
            <div class="card">
                <div class="body">
                    <div class="row">
                        <div class="col-md-5">
                            <h3 class="my-0 py-0 border-bottom text-info">
                                {{ $member->full_name }}
                            </h3>
                            <p class="py-0 my-0">
                            Email : {{ $member->email }} 
                            </p>
                            <p>
                                Phone: {{ $member->phone_number }}
                            </p>
                            <hr />
                            <p>
                                <strong>Current Program Detail</strong>
                                @if (! $member->member_detail)
                                    <span class="text-danger">Program Not Found</span>
                                @endif
                                
                                @if($member->member_detail)
                                    @foreach ( $member->member_detail as $member_detail)
                                        @if( $member_detail->program )
                                            <br /><strong>Program Name: </strong> {{ $member_detail->program->program_name }}
                                        @endif
                                    @endforeach
                                @endif
                            </p>
                        </div>
                        <div class="col-md-7">
                            <form id="assignMember" method="post" action="{{ route('admin.members.admin_store_assign_member_to_program',$program->id) }}">
                                <div class="response_message"></div>
                                @csrf
                                <input type="hidden" name="student" class="form-control " value="{{$member->id}}">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <strong>
                                                Program
                                            </strong>
                                            <input readonly value="{{ old('program',$program->program_name) }}" type="text" name="program" id="program" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>
                                                Batch
                                            </strong>
                                            <select name="batch" id="batch" class="form-control">
                                                @foreach ($batches as $batch)
                                                    <option value='{{$batch->batch->id}}'>{{$batch->batch->batch_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>
                                                Section
                                            </strong>
                                            <select name="section" id="batch" class="form-control">
                                                @foreach ($sections as $section)
                                                    <option value="{{$section->id}}">{{$section->section_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-round btn-primary btn-outline">Assign </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
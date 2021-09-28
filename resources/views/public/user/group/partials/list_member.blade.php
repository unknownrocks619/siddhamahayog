<div class='row'>
    <div class='col-md-12'>
        <div id="error"></div>
    </div>
    <table class="table table-border table-hover">
        <thead>
            <tr>
                @if(request()->record_type == "my-group")
                    <th>MemberName</th>
                    <th>Login ID</th>
                    <th>Status</th>
                    <th>Relation</th>
                    <th>Approved</th>
                    <th>Action</th>
                @endif
                @if(request()->record_type == "other-group")
                    <th>Group Leader</th>
                    <th>Status</th>
                    <th>Relation</th>
                    <th>Approved</th>
                    <th>Action</th>

                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $member)
                @if(request()->record_type == "my-group")
                    <tr>
                        <td> {{ $member->member_detail->full_name() }} </td>

                        <td>
                            @if($member->link_type)
                                {{ $member->member_detail->userlogin->email }}
                            @else
                                {{ $member->member_detail->phone_number }}
                            @endif
                        </td>
                        <td>
                            @if($member->status)
                                <span class='bg-success-light px-2'>Active</span>
                            @else
                                <span class='bg-danger-light px-2'>Inactive</span>
                            @endif
                        </td>
                        <td>
                            {{ ucwords($member->relation) }}
                        </td>
                        <th class='text-center'>
                            @if($member->approved)
                                <span class='bg-success-light px-2'><i class='fas fa-check'></i></span>
                            @else
                                <span class='bg-danger-light px-2'><i class='fas fa-times'></i></span>
                            @endif

                        </th>
                        <td>
                            <a 
                                data-target="#page-modal" 
                                data-toggle='modal' 
                                href="{{ route('modals.public_modal_display',['modal'=>'group-leader-update-member','reference'=>'group_member', 'reference_id'=>encrypt($member->id)]) }}">Edit</a> | 
                            <a href="{{ route('public.family.public_remove_user_member_from_group',encrypt($member->id)) }}" class='text-danger remove-member'><i class='fas fa-trash'></i></a>
                        </td>
                    </tr>
                @elseif (request()->record_type == "other-group")
                    <tr>
                        <td> {{ $member->leader_detail->full_name() }} </td>
                        <td>
                            @if($member->status)
                                <span class='bg-success-light px-2'>Active</span>
                            @else
                                <span class='bg-danger-light px-2'>Inactive</span>
                            @endif
                        </td>
                        <td>
                            {{ ucwords($member->relation) }}
                        </td>
                        <th class=''>
                            @if($member->approved)
                                <span class='bg-success-light px-2'><i class='fas fa-check'></i></span>
                            @else
                                <span class='bg-danger-light px-2'><i class='fas fa-times'></i></span>
                            @endif

                        </th>
                        <td>
                            <a href="{{ route('public.family.public_remove_user_yourself_from_group',encrypt($member->id)) }}" class='text-danger remove-member'><i class='fas fa-trash'></i></a>
                        </td>
                    </tr>
                @endif 
            @endforeach
        </tbody>
    </table>
</div>

@if(request()->record_type == "my-group")
    <script type="text/javascript">
        $(".remove-member").click(function(event) {
            $("#error").removeAttr('class');
            $("#error").empty();
            event.preventDefault();
            let parent_reference = this;
            $.ajax({
                type : "POST",
                url : $(this).attr("href"),
                data : "requested=true",
                headers : {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                success : function (response) {
                    if (response.success === true) {
                        $("#error").fadeIn("medium",function(){
                            $("#error").attr('class','alert alert-success');
                            $(this).html(response.message);
                        })
                    } else {
                        $("#error").fadeIn("medium", function() {
                            $("#error").attr("class",'alert alert-danger');
                            $(this).html(response.message);
                        })
                    }

                    $(parent_reference).closest('tr').fadeOut('medium');
                }
            })
        })
    </script>

    <script type="text/javascript">
		$('#page-modal').on('shown.bs.modal', function (event) {
			$('body').removeAttr('class');
			$.ajax({
				method : "GET",
				url : event.relatedTarget.href,
				success: function (response){
					$("#modal_content").html(response);
				}
			});
		})
	</script>
@endif

@if(request()->record_type == "other-group")
    <script type="text/javascript">
        $(".remove-member").click(function(event) {
            $("#error").removeAttr('class');
            $("#error").empty();
            event.preventDefault();
            let parent_reference = this;
            $.ajax({
                type : "POST",
                url : $(this).attr("href"),
                data : "requested=true",
                headers : {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                success : function (response) {
                    if (response.success === true) {
                        $("#error").fadeIn("medium",function(){
                            $("#error").attr('class','alert alert-success');
                            $(this).html(response.message);
                        })
                    } else {
                        $("#error").fadeIn("medium", function() {
                            $("#error").attr("class",'alert alert-danger');
                            $(this).html(response.message);
                        })
                    }

                    $(parent_reference).closest('tr').fadeOut('medium');
                }
            })
        })
    </script>
@endif
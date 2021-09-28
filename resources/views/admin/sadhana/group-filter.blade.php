<div class='row'>
    <div class='col-md-12'>
        <div id="message_filter"></div>
        <table class='table table-hover table-bordered'>
            <thead>
                <tr>
                    <td>Requested By</td>
                    <td>Total Member</td>
                    <td>Member List</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($groups->groupBy('leader_id') as $leader_id => $member_list)
                    <tr>
                        <td> 
                            @php
                                $leader = \App\Models\userDetail::findOrFail($leader_id);
                                echo $leader->full_name();
                            @endphp
                        </td>
                        <td>
                            {{ $member_list->count() }}
                        </td>
                        <td>
                            <ul>
                                @foreach ($member_list as $member)
                                    <li>
                                        {{ $member->member_detail->full_name() }}
                                        &nbsp;
                                        @if( ! $member->approved)
                                        <a href="{{ route('users.sadhak.admin_remove_user_from_group',[$member->id]) }}" class='remove'>
                                            <i class='cursor-pointer bx bx-trash mb-1 mr-50 text-danger'></i>
                                        </a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            @if( ! request()->filter)
                                <a href="{{ route('users.sadhak.admin_change_group_request_status',['approved',request()->sibir,$leader_id]) }}" class='btn btn-success approve'>
                                    <i class='cursor-pointer bx bx-check text-white'></i>
                                </a>
                                <a href="{{ route('users.sadhak.admin_change_group_request_status',['reject',request()->sibir,$leader_id]) }}" class='btn btn-warning approve'>
                                    <i class='cursor-pointer bx bx-block text-white'></i>
                                </a>
                                <a href="{{ route('users.sadhak.admin_change_group_request_status',['remove',request()->sibir,$leader_id]) }}" class='btn btn-danger approve'>
                                    <i class='cursor-pointer bx bx-trash text-white'></i>
                                </a>
                            @else
                            <a href="{{ route('users.sadhak.admin_change_group_request_status',['reject',request()->sibir,$leader_id]) }}" class='btn btn-warning approve'>
                                <i class='cursor-pointer bx bx-block text-white'></i>
                            </a>
                            <a href="{{ route('users.sadhak.admin_change_group_request_status',['remove',request()->sibir,$leader_id]) }}" class='btn btn-danger approve'>
                                <i class='cursor-pointer bx bx-trash text-white'></i>
                            </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(".approve").click( function ( event) {
        event.preventDefault();
        $("#message_filter").fadeOut('fast',function() {
            $(this).removeAttr("class");
            $(this).empty();
        });
        let parent = this
        $.ajax({
            type : "POST",
            url : $(this).attr('href'),
            data : 'action=required',
            headers : {
                    'X-CSRF-TOKEN' : "{{ csrf_token() }}"
                },
            success : function (response) {
                if (response.success == true) {
                    $("#message_filter").attr("class",'alert alert-success')
                    $(parent).closest('tr').fadeOut('medium');
                } else{
                    $("#message_filter").attr("class",'alert alert-danger')
                }
                $("#message_filter").fadeIn("medium",function() {
                    $(this).html(response.message);
                })
            }
        })
    })
</script>
<script>
    $(".remove").click( function ( event) {
        alert("prevented_dea");
        event.preventDefault();
        $("#message_filter").fadeOut('fast',function() {
            $(this).removeAttr("class");
            $(this).empty();
        });
        let parent = this
        $.ajax({
            type : "POST",
            url : "{{ route('users.sadhak.admin_remove_user_from_group',5) }}",
            data : 'action=required',
            headers : {
                    'X-CSRF-TOKEN' : "{{ csrf_token() }}"
                },
            success : function (response) {
                if (response.success == true) {
                    $("#message_filter").attr("class",'alert alert-success')
                    $(parent).closest('li').fadeOut('medium');
                } else{
                    $("#message_filter").attr("class",'alert alert-danger')
                }
                $("#message_filter").fadeIn("medium",function() {
                    $(this).html(response.message);
                })
            }
        })
    })
</script>
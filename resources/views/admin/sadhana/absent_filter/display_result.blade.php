@if( ! $absent_list->count() )
    <h5 class='text-info'>No Absent Requestion Form Available.</h5>
@else
    <!-- <div class='row'>
        <div class='col-md-12'> -->
            <div id="absent_filter_result_error"></div>
            <table class='table table-hover'>
                <thead>
                    <tr>
                        <th>Full name</th>
                        <th>From Date</th>
                        <th>Till Date</th>
                        <th>No. of days</th>
                        <th>Reason</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($absent_list as $absent)
                        <tr>
                            <td>
                                {{ $absent->user_detail->full_name() }}
                            </td>
                            <td>
                                {{ date("M D, Y",strtotime($absent->absent_from)) }}
                            </td>
                            <td>
                                {{ date("M D, Y", strtotime($absent->absent_till)) }}
                            </td>
                            <td>
                                {{ $absent->nod }}
                            </td>
                            <td>
                                {!! strip_tags($absent->reason,["p",'strong','em']) !!}
                            </td>
                            <td>
                                @if( ! $absent->status )
                                    <a href="{{ route('users.sadhak.admin_change_absent_status',['absent'=>$absent->id,'status'=>1]) }}" class='text-primary status'>Approve</a>
                                     | 
                                    <a href="{{ route('users.sadhak.admin_change_absent_status',['absent'=>$absent->id,'status'=>2]) }}" class='text-danger status'>Decline</a>
                                @elseif($absent->status == 1)
                                    <a href="{{ route('users.sadhak.admin_change_absent_status',['absent'=>$absent->id,'status'=>0]) }}" class='text-danger status'>Revoke</a>
                                @endif
                            </td>
                        </tr> 
                    @endforeach
                </tbody>
            </table>

            <script type="text/javascript">
                $(".status").click(function (event) {
                    event.preventDefault();
                    let parent_instance = this;
                    $.ajax({
                        type: 'get',
                        url : $(this).attr('href'),
                        success: function( response ) {
                            if (response.success == true ) {
                                $("#absent_filter_result_error").attr("class",'alert alert-success')
                                $(parent_instance).closest('tr').fadeOut('slow',function(){
                                    $(this).attr('class','bg-success');
                                })
                            } else {
                                $("#absent_filter_result_error").attr('class','alert alert-danger')
                            }
                            $("#absent_filter_result_error").fadeIn("fast",function() {
                                $(this).html(response.message);
                            });
                        }
                    })
                })
            </script>
        <!-- </div>
    </div> -->
@endif
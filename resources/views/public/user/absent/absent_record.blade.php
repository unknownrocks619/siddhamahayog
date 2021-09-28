@if( ! $user_event )
    <div class='row'>
        <div class='col-md-12'>
            <p class='text-info'>Permission Denied. You are not authorized to perform this action.</p>
        </div>
    </div>
@else


    @php
        $absent_record = \App\Models\EventAbsentRecord::where('sibir_record_id',$user_event->sibir_record_id)
                            ->where('user_detail_id',auth()->user()->user_detail_id)
                            ->get();
    @endphp

    @if (! $absent_record->count() )
        <p class='text-danger'>Record Not Found.</p>
    @else
        <div id="record_error"></div>
        <table class='table table-bordered table-hover mt-3'>
            <thead>
                <tr>
                    <th>Start Date</th>
                    <th>No of Days</th>
                    <th>Status</th>
                    <th>Reason</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($absent_record as $record)
                    <tr>
                        <td>
                           {{ date("M D, Y" ,strtotime($record->absent_from)) }}
                        </td>
                        <td>
                            {{ $record->nod }}
                        </td>
                        <td>
                            @if( ! $record->status ) 
                                <span class='bg-warning px-2 text-white'>Pending</span>
                            @elseif ($record->status == 1) 
                                <span class='bg-success px-2 text-white'>Approved</span>
                            @elseif( $record->status == 2)
                                <span class='bg-primary px-2 text-white'>Cancelled</span>
                            @endif
                        </td>
                        <td>
                           {!! strip_tags($record->reason,["strong","em",'br']) !!}
                        </td>
                        <td>
                            @if( ! $record->status ) 
                                <form method="post" id="cancel_absent_form" action="{{ route('public.event.public_request_absent_cancel_form') }}">
                                    @csrf
                                    <input name='_tk' type="hidden" class='form-control d-none' value="{{ encrypt($record->id) }}" />
                                    <button type="submit" class='btn btn-sm btn-danger'>Cancel Form</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <script type="text/javascript">
            $("form#cancel_absent_form").submit( function( event ) {
                $("#record_error").fadeOut('fast',function(){
                    $(this).removeAttr('class')
                    $(this).empty();
                })
                let parentInstance = this;
                event.preventDefault();
                $.ajax({
                    type : $(this).attr('method'),
                    url : $(this).attr('action'),
                    data : $(this).serializeArray(),
                    success : function ( response ) {
                        if (response.success == true ) {
                            $("#record_error").attr('class','alert alert-success')
                            $(parentInstance).closest('tr').fadeOut('slow',function(){
                                $(this).attr('class','bg-warning');
                            });
                        } else {
                            $("#record_error").attr('class','alert alert-danger')
                        }
                        $("#record_error").fadeIn('medium',function(){
                            $(this).html(response.message);
                        })
                    }
                })
            })
        </script>
    @endif
    
@endif
@extends('layouts.admin')

@section('content')
<section id="headers">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <x-alert></x-alert>
                <div class='card-body'>
                    <p class='text-warning'>Note: This is merge is only for this session only. Merge is not permanent.</p>
                    @if(  ! $current_live_session->count() ) 
                        <div class='alert alert-info'>No live sesssion to merge.</div>
                    @else
                    
                    <table class='table table-bordered table-hover'> 
              
                        <tbody>
                        
                            @foreach ($current_live_session as $live_session)
                                    <tr>
                                        <td>
                                            <form id="submit_{{ $loop->index+1 }}" method="post" action="{{ route('events.admin_merge_session') }}">
                                                <table class='table table-striped table-hover'>
                                                    <tr>
                                                        <td> {{ $loop->index+1 }} </td>
                                                        <td> {{ address($live_session->country_id,"country") }} </td>
                                                        <td>
                                                            @csrf
                                                            <input type="hidden" name="merge_to" value="{{ $live_session->id }}" />
                                                                <select class="form-control" name="merge_country">
                                                                    @foreach ($merge_zone as $key => $zones)
                                                                        @if($live_session->country_id != $key)
                                                                            <option value="{{$key}}">{{$zones}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                        </td>
                                                        <td>
                                                            <button type="submit"  class="btn btn-primary">Merge Session</button>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </form>
                                        </td>
                                    </tr>
                                    
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row" id='profile_detail_card'>
        <div class="col-8">
            <div class="card">
                <!-- Card flex-->
            </div>
        </div>
    </div>
</section>
@endSection()

@section('page_js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

   <script type="text/javascript">
        $(document).ready(function(){
            $('#display_modal').on('shown.bs.modal', function (event) {
                $.ajax({
                    method : "GET",
                    url : event.relatedTarget.href,
                    success: function (response){
                        $("#modal-content-fetch").html(response);
                    }
                });
            })
        });

        $("a.registration").click(function(event) {
            event.preventDefault();
            var current_url = $(this).attr('href');
            $("#progress").fadeIn("fast");
            $.ajax({
                type : "get",
                url : $(this).attr("href"),
                data : "register_all=true",
                async : true,
                success : function (response ) {
                    $("#progress").fadeOut('slow',function(){
                        if (response.success == true){
                            $("#alert_message").attr("class",'alert alert-success')
                        } else {
                            $("#alert_message").attr("class",'alert alert-danger')
                        }
                    });
                    $("#alert_message").html(response.message);
                    $("#alert_message").fadeIn('medium');
                    window.location.href;

                }                
            });
            return false;
        });
   </script>
@endSection()
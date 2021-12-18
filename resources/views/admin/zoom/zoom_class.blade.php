@extends('layouts.admin')

@section('content')
<section id="headers">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table-border table-hover">
                        <thead>
                            <tr>
                                <th>Sibir Name</th>
                                <th>Total Capacity</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($other_meetings as $meeting)
                                <tr>
                                    <td>{{ $meeting->sibir_title }}</td>
                                    <td>
                                        @if($meeting->total_capacity)
                                            {{ $meeting->total_capacity }}
                                        @else
                                            OPEN
                                        @endif
                                    </td>
                                    <td>
                                        @if
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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

        $("form#search_and_add").submit(function(event) {
            event.preventDefault();
            $.ajax({
                method : $(this).attr("method"),
                url : $(this).attr('action'),
                data: $(this).serializeArray(),
                success: function (response) {
                    if (response.success == true){
                            $("#alert_message").attr("class",'alert alert-success')
                        } else {
                            $("#alert_message").attr("class",'alert alert-danger')
                        }
                    $("#alert_message").html(response.message);
                    $("#alert_message").fadeIn('medium');
                }
            })
        })
   </script>
@endSection()
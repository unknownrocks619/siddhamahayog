@extends('layouts.admin')


@section('content')
<section id="headers">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        All Sibir Records
                    </h4>
                </div>
                <div class='card-body'>
                    <p class="card-text text-right">
                        <!-- <a href='' class='btn btn-info'>Export To Excel</a> -->
                        <a href="{{ route('users.sadhak.add') }}" class='btn btn-info'>
                            <i class='fas fa-plus'></i>
                            New Sibir
                        </a>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered complex-headers" id="user_table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Active Date</th>
                                    <th>Status</th>
                                    <th>Sadhak Entry</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($programs as $program)
                                    <tr>
                                        <td>
                                            {{ $program->sibir_title }}
                                            <br />
                                            <a href="{{ route('users.sadhak.sadhak-report',[$program->id]) }}" class=''>view detail</a>
                                        </td>
                                        <td>
                                            @if($program->start_date)
                                                {{ date("D d,M Y",strtotime($program->start_date)) }}
                                            @else
                                                {{ date("D d,M Y",strtotime($program->created_at)) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($program->active)
                                                <span class='badge bg-success'>Active</span> 
                                            @else
                                                <span class='badge bg-danger'>Closed</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $program->total_registrations->count() ?? 0 }}
                                        </td>

                                        <td>
                                            @if($program->active)
                                                <a href='' class='text-danger'>Close</a> | 
                                            @endif
                                                <a href="{{ route('users.sadhak.edit',$program->id) }}">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
            <!-- start modal -->
            <div class="modal fade text-left" id="display_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title" id="myModalLabel1">User Update</h3>
                  <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                  </button>
                </div>
                <div class='modal-body'>
                  <div id="modal-content-fetch">Loading Form, Please wait...</div>
                </div>
              </div>
            </div>
          </div>

        <!-- / end modal -->

      <!-- / Modal -->
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
   </script>
@endSection()
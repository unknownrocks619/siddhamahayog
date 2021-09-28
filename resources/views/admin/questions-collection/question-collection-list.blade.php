@extends('layouts.admin')


@section('content')
<section id="headers">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        All Question Paper
                    </h4>
                </div>
                <div class='card-body'>
                    <p class="card-text text-right">
                        <!-- <a href='' class='btn btn-info'>Export To Excel</a> -->
                        <a href="{{ route('questions.admin_add_question_collection') }}" class='btn btn-info'>
                            <i class='fas fa-plus'></i>
                            Add Question Paper
                        </a>
                    </p>
                    <x-alert></x-alert>
                    <div class="table-responsive">
                        <table class='table table-hover'>
                            <thead>
                                <tr>
                                    <th>Questions</th>
                                    <th>Question Term</th>
                                    <th>Exam Schedule</th>
                                    <th>No of Question</th>
                                    <th>Objective</th>
                                    <th>Subjective</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $collections as $q_col)
                                    <tr>
                                        @if($q_col->sibir_record_id)
                                            <td> 
                                                {{ $q_col->sibir->sibir_title }} 
                                            </td>
                                        @endif
                                        <td> {{ $q_col->question_term }}
                                            <br />
                                            <a href="#">Add Questions</a>
                                        </td>
                                        <td> 
                                            Starts : {{ date("Y-m-d",strtotime($q_col->exam_start_date)) }} - {{ $q_col->start_time }} 
                                            Ends : {{ date("Y-m-d",strtotime($q_col->exam_end_date)) }} - {{ $q_col->end_time }} 
                                            TimeZome: {{ config('app.timezone') }}
                                        </td>
                                        <td>
                                            @if($q_col->questions)
                                                {{ $q_col->questions->count() }}
                                            @else
                                                Add Questions
                                            @endif
                                        </td>

                                        <td>
                                            @if($q_col->questions)
                                                {{ $q_col->questions->where('objective',true)->count() }}
                                            @else
                                                0
                                            @endif
                                        </td>
                                        <td>
                                            @if($q_col->questions)
                                                {{ $q_col->questions->where('objective',null)->count() }}
                                            @else
                                                0
                                            @endif
                                        </td>
                                        <td>
                                          
                                            <form method="post" action="{{ route('questions.admin_remove_collection',$q_col->id) }}">
                                                @csrf
                                                @method("delete")
                                                <a href="{{ route('questions.admin_edit_question_collection',$q_col->id) }}">Edit</a> 
                                            |
                                                <button type='submit' class='btn btn-link text-danger px-0 py-0'>Delete</button>
                                            </form>
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
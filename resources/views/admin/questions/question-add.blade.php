@extends('layouts.admin')


@section('content')
<section id="headers">
    <div class="row">
        <div class="col-12">
            <form method="post" enctype="multipart/form-data" action="{{ route('questions.admin_save_questions_store') }}">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            All Questions
                        </h4>
                    </div>
                    <div class='card-body'>
                        <x-alert></x-alert>
                    </div>
                    <div class='card-body'>
                        <div class='card'>
                            <div class='card-header bg-light py-1'>
                                <h4 class='card-title'>Search Questions</h4>
                            </div>
                            <div class='card-body mt-2'>
                                <div class='form-row'>
                                    <div class='col-md-4'>
                                        <label class='label-control'> Sibir / Class</label>
                                        <select name='sibir' placeholder="Choose..." class='form-control'>
                                            <option>Select Class</option>
                                            @foreach ($sibir_record as $record)
                                                <option value='{{ $record->id }}'> {{ $record->sibir_title }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class='col-md-4'>
                                        <label class='label-control'>Select Year</label>
                                        <select name='year' class='form-control'>
                                            <option value="2078">2078</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class='label-control'>Questions Paper</label>
                                        <select name="question_collection" id="question_collection" class='form-control'>

                                        </select>
                                    </div>
                                </div>

                                <div class='form-row mt-2'>
                                    <div class='col-md-6'>
                                        <label class='label-control'>Type</label>
                                        <select name='question_type' class='form-control'>
                                            <option value="subjective">Subjective</option>
                                            <option value="objective">Objective</option>
                                        </select>
                                    </div>
                                    <div class='col-md-6'>
                                        <label class='label-control'>Points</label>
                                        <input type='text' name='points' value="{{ old('points',0) }}" class='form-control' />
                                    </div>
                                </div>
                                <div class='form-row mt-2'>
                                    <div class='col-md-12'>
                                        <label class='label-control'>Questions</label>
                                        <textarea  name='question' class='form-control' id="questions">{{old('question')}}</textarea>
                                    </div>
                                </div>
                                <div class="form-row mt-2">
                                    <div class='col-md-6'>
                                        <label class='label-control'>Question Type</label>
                                        <select name='question_display_type' class="form-control">
                                            <option value="text">Text</option>
                                            <option value="image">Image</option>
                                            <option value="audio">Audio</option>
                                        </select>
                                    </div>
                                    <div class='col-md-6 d-none' id="question_display_result">
                                        <label class='label-control'>Upload File</label>
                                        <input type="file" name="question_display_file" class='form-control d-none' />
                                    </div>
                                </div>
                            </div>

                            <div class='card-body d-none' id='objective_answer'>
                                <h5>Answers</h5>
                                <div class='form-row'>
                                    <div class='col-md-6'>
                                        <label class='label-control'>Write Answer</label>
                                        <input type='text' class="form-control" id="answer_text_one" name='answer_text_one' />
                                        <input type='file' class="form-control d-none" id="answer_file_one" name='answer_file_one' />
                                    </div>
                                    <div class="col-md-3">
                                        <label class='label-control text-bold'>Type</label>
                                        <select class='form-control' name='type_one'>
                                            <option value='text'>Text</option>
                                            <option value='image'>Image</option>
                                            <option value='audio'>Audio</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class='label-control text-bold'>Righ Answer</label>
                                        <select class='form-control' name='corrent_answer_one'>
                                            <option value='yes'>yes</option>
                                            <option value='no' selected>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class='form-row'>
                                    <div class='col-md-6'>
                                        <label class='label-control'>Write Answer</label>
                                        <input type='text' class="form-control" id="answer_text_two" name='answer_text_two' />
                                        <input type='file' class="form-control d-none" id="answer_file_two" name='answer_file_two' />
                                    </div>
                                    <div class="col-md-3">
                                        <label class='label-control text-bold'>Type</label>
                                        <select class='form-control' name='type_two'>
                                            <option value='text'>Text</option>
                                            <option value='image'>Image</option>
                                            <option value='audio'>Audio</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class='label-control text-bold'>Righ Answer</label>
                                        <select class='form-control' name='corrent_answer_two'>
                                            <option value='yes'>yes</option>
                                            <option value='no' selected>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class='form-row'>
                                    <div class='col-md-6'>
                                        <label class='label-control'>Write Answer</label>
                                        <input type='text' class="form-control" id="answer_text_three" name='answer_text_three' />
                                        <input type='file' class="form-control d-none" id="answer_file_three" name='answer_file_three' />
                                    </div>
                                    <div class="col-md-3">
                                        <label class='label-control text-bold'>Type</label>
                                        <select class='form-control' name='type_three'>
                                            <option value='text'>Text</option>
                                            <option value='image'>Image</option>
                                            <option value='audio'>Audio</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class='label-control text-bold'>Righ Answer</label>
                                        <select class='form-control' name='corrent_answer_three'>
                                            <option value='yes'>yes</option>
                                            <option value='no' selected>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class='form-row'>
                                    <div class='col-md-6'>
                                        <label class='label-control'>Write Answer</label>
                                        <input type='text' class="form-control" name='answer_text_four' />
                                        <input type='file' class="form-control d-none" id="answer_file_four" name='answer_file_four' />
                                    </div>
                                    <div class="col-md-3">
                                        <label class='label-control text-bold'>Type</label>
                                        <select class='form-control' name='type_four'>
                                            <option value='text'>Text</option>
                                            <option value='image'>Image</option>
                                            <option value='audio'>Audio</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class='label-control text-bold'>Righ Answer</label>
                                        <select class='form-control' name='corrent_answer_four'>
                                            <option value='yes'>yes</option>
                                            <option value='no' selected>No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class='card-footer bg-light'>
                                <button type="submit" class='btn btn-info'>Add Questions</button>
                            </div>
                        </div>
                    </div>
                    <div class='card-body' id='question-content'></div>
                </div>
            </form>
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
<script src="https://cdn.tiny.cloud/1/gfpdz9z1bghyqsb37fk7kk2ybi7pace2j9e7g41u4e7cnt82/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
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

        $("select[name='sibir']").change( function(){
            if (parseInt(this.value)) {
                $.ajax({
                type: "get",
                url : "{{ route('api-response-question-collection') }}",
                data : "sibir="+this.value,
                success: function (response) {
                    $("#question_collection").html(response);
                }
            });

            }
        });

        $("#question_collection").change(function() {
            $.ajax({
                type :"get",
                url : "{{ route('api_list_questions_for_collection') }}",
                data : $('form').serializeArray(),
                success: function (response) {
                    $("#question-content").html(response);
                }
            })
        });

        $("select[name='question_type']").change(function() {
            console.log(this.value);
            if (this.value == "objective") {
                $("#objective_answer").fadeIn('medium',function(){
                    $(this).removeClass('d-none');
                });
            } else {
                $("#objective_answer").fadeOut('fast',function() {
                    $(this).addClass('d-none');
                });
            }
        })
   </script>
   <script>
       $("select[name='type_one']").change(function() {
           console.log(this.value);
           if (this.value == "image") {
               $("input[name='answer_text_one']").fadeOut('fast',function(){
                   $(this).addClass('d-none');
                   $("input[name='answer_file_one']")
                        .removeAttr('accept')
                        .attr('accept','image/*')
                        .removeClass('d-none')
                        .show()
               });
           } else if(this.value == "audio") {
            $("input[name='answer_text_one']").fadeOut('fast',function(){
                   $(this).addClass('d-none');
                   $("input[name='answer_file_one']")
                        .removeAttr('accept')
                        .attr('accept','audio/*')
                        .removeClass('d-none')
                        .show()
               });
           } else if (this.value == 'text' ) {
               $("input[name='answer_file_one']").fadeOut('fast',function(){
                   $(this).addClass('d-none');
                   $("input[name='answer_text_one']")
                    .removeClass('d-none')
                    .show()
               })
           }
       })
   </script>

    <script>
        $("select[name='type_two']").change(function() {
           console.log(this.value);
           if (this.value == "image") {
               $("input[name='answer_text_two']").fadeOut('fast',function(){
                   $(this).addClass('d-none');
                   $("input[name='answer_file_two']")
                        .removeAttr('accept')
                        .attr('accept','image/*')
                        .removeClass('d-none')
                        .show()
               });
           } else if(this.value == "audio") {
            $("input[name='answer_text_two']").fadeOut('fast',function(){
                   $(this).addClass('d-none');
                   $("input[name='answer_file_two']")
                        .removeAttr('accept')
                        .attr('accept','audio/*')
                        .removeClass('d-none')
                        .show()
               });
           } else if (this.value == 'text' ) {
               $("input[name='answer_file_two']").fadeOut('fast',function(){
                   $(this).addClass('d-none');
                   $("input[name='answer_text_two']")
                    .removeClass('d-none')
                    .show()
               })
           }
       })
    </script>

    <script>
       $("select[name='type_three']").change(function() {
           console.log(this.value);
           if (this.value == "image") {
               $("input[name='answer_text_three']").fadeOut('fast',function(){
                   $(this).addClass('d-none');
                   $("input[name='answer_file_three']")
                        .removeAttr('accept')
                        .attr('accept','image/*')
                        .removeClass('d-none')
                        .show()
               });
           } else if(this.value == "audio") {
            $("input[name='answer_text_three']").fadeOut('fast',function(){
                   $(this).addClass('d-none');
                   $("input[name='answer_file_three']")
                        .removeAttr('accept')
                        .attr('accept','audio/*')
                        .removeClass('d-none')
                        .show()
               });
           } else if (this.value == 'text' ) {
               $("input[name='answer_file_three']").fadeOut('fast',function(){
                   $(this).addClass('d-none');
                   $("input[name='answer_text_three']")
                    .removeClass('d-none')
                    .show()
               })
           }
       })
   </script>
    <script>
       $("select[name='type_four']").change(function() {
           console.log(this.value);
           if (this.value == "image") {
               $("input[name='answer_text_four']").fadeOut('fast',function(){
                   $(this).addClass('d-none');
                   $("input[name='answer_file_four']")
                        .removeAttr('accept')
                        .attr('accept','image/*')
                        .removeClass('d-none')
                        .show()
               });
           } else if(this.value == "audio") {
            $("input[name='answer_text_four']").fadeOut('fast',function(){
                   $(this).addClass('d-none');
                   $("input[name='answer_file_four']")
                        .removeAttr('accept')
                        .attr('accept','audio/*')
                        .removeClass('d-none')
                        .show()
               });
           } else if (this.value == 'text' ) {
               $("input[name='answer_file_four']").fadeOut('fast',function(){
                   $(this).addClass('d-none');
                   $("input[name='answer_text_four']")
                    .removeClass('d-none')
                    .show()
               })
           }
       })
   </script>
   <script>
        tinymce.init({
        selector: 'textarea',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
    });
  </script>
  
    <script type="text/javascript">
        $("select[name='question_display_type']").change(function() {
           console.log(this.value);
           if (this.value == "image") {
               $("#question_display_result").fadeIn('fast',function(){
                   $(this).removeClass('d-none');
                   $("input[name='question_display_file']")
                        .removeAttr('accept')
                        .attr('accept','image/*')
                        .removeClass('d-none')
                        // .show()
               });
           } else if(this.value == "audio") {
            $("#question_display_result").fadeIn('fast',function(){
                   $(this).removeClass('d-none');
                   $("input[name='question_display_file']")
                        .removeAttr('accept')
                        .attr('accept','audio/*')
                        .removeClass('d-none')
                        // .show()
               });
           } else if (this.value == 'text' ) {
               $("#question_display_result").fadeOut('fast',function(){
                   $(this).addClass('d-none');
                   $("input[name='question_display_file']")
                    .addClass('d-none')
                    // .show()
               })
           }
       })
    </script>
@endSection()
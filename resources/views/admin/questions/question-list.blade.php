@extends('layouts.admin')

@section("page_css")
    <style type="text/css">
        
        .container {
            background-color: #555;
            color: #ddd;
            border-radius: 10px;
            padding: 20px;
            font-family: 'Montserrat', sans-serif;
            max-width: 700px
        }

        .container>p {
            font-size: 32px
        }

        .question {
            width: 75%
        }

        .options {
            position: relative;
            padding-left: 40px
        }

        #options label {
            display: block;
            margin-bottom: 15px;
            font-size: 14px;
            cursor: pointer
        }

        .options input {
            opacity: 0
        }

        .checkmark {
            position: absolute;
            top: -1px;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #555;
            border: 1px solid #ddd;
            border-radius: 50%
        }

        .options input:checked~.checkmark:after {
            display: block
        }

        .options .checkmark:after {
            content: "";
            width: 10px;
            height: 10px;
            display: block;
            background: white;
            position: absolute;
            top: 50%;
            left: 50%;
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
            transition: 300ms ease-in-out 0s
        }

        .options input[type="radio"]:checked~.checkmark {
            background: #21bf73;
            transition: 300ms ease-in-out 0s
        }

        .options input[type="radio"]:checked~.checkmark:after {
            transform: translate(-50%, -50%) scale(1)
        }

        .btn-primary {
            background-color: #555;
            color: #ddd;
            border: 1px solid #ddd
        }

        .btn-primary:hover {
            background-color: #21bf73;
            border: 1px solid #21bf73
        }

        .btn-success {
            padding: 5px 25px;
            background-color: #21bf73
        }

        @media(max-width:576px) {
            .question {
                width: 100%;
                word-spacing: 2px
            }
        }
    </style>
@endsection
@section('content')
    <section id="headers">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            All Questions
                        </h4>
                    </div>
                    <div class='card-body'>
                        <div class='card'>
                            <div class='card-header bg-light py-1'>
                                <h4 class='card-title'>Search Questions</h4>
                            </div>
                            <div class='card-body mt-2'>
                                <form method="get" id="question_list">
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
                                </form>
                            </div>
                            <div class='card-footer bg-light'>
                                <a href="{{ route('questions.admin_add_questions') }}" class='btn btn-info'>Add Questions</a>
                            </div>
                        </div>
                    </div>
                    <x-alert></x-alert>
                    <div class='card-body' id='question-content'></div>
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

    <!--Modal-->
    <div class="modal fade text-left" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl">
              <div class="modal-content" id="modal-content">
                <div class='modal-body'>
                  <div id="delete-modal-content">Loading Form, Please wait...</div>
                </div>
              </div>
            </div>
          </div>
    <!-- /Modal -->
@endSection()
@section('page_js')
<script src="https://cdn.tiny.cloud/1/gfpdz9z1bghyqsb37fk7kk2ybi7pace2j9e7g41u4e7cnt82/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
   <script type="text/javascript">
        $(document).ready(function(){
            $('#edit-modal').on('shown.bs.modal', function (event) {
                $.ajax({
                    method : "GET",
                    url : event.relatedTarget.href,
                    success: function (response){
                        $("#modal-content").html(response);
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
                data : $('form#question_list').serializeArray(),
                success: function (response) {
                    $("#question-content").html(response);
                }
            })
        });
   </script>
   
@endSection()
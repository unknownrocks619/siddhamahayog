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
                            Evaluate Answer
                        </h4>
                    </div>
                    <div class='card-body'>
                        <div class='card'>
                            <div class='card-body mt-2'>
                                <table class='table table-bordered table-hover'>
                                    <thead>
                                        <tr>
                                            <th>Sadhak / User Name</th>
                                            <th>Program</th>
                                            <th>Objective Obtained</th>
                                            <th>Subjective Obtained</th>
                                            <th>Total</th>
                                            <!-- <th>Percentage</th> -->
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $all_user = \App\Models\UserSadhakRegistration::where('sibir_record_id',$collection->sibir_record_id)->get();
                                        @endphp

                                        @foreach ($all_user as $user)
                                            <tr>
                                                <td> {{ $user->userDetail->full_name() }} </td>
                                                <td> {{ $collection->sibir->sibir_title }} </td>
                                                <td>
                                                    @php
                                                        $ans_coll = \App\Models\UserAnswer::where('question_collection_id',$collection->id)
                                                                                                ->where('user_detail_id',$user->userDetail->id)
                                                                                                ->first();
                                                        
                                                        if ($ans_coll) {
                                                            // calculate subjective marks
                                                            echo $ans_coll->objective_answer->sum('obtained_marks');
                                                        } else {
                                                            echo "<span class='text-danger'>Not Attempted</span>";
                                                        }
                                                    @endphp
                                                </td>
                                                <td>
                                                    @if($ans_coll)
                                                        {{ $ans_coll->subjective_answer->sum('obtained_marks') }}
                                                    @else
                                                        0
                                                    @endif
                                                </td>
                                                <td> 
                                                    {{ $ans_coll->marks_obtained ?? 0 }}
                                                </td>
                                                <td>
                                                    @if($ans_coll)
                                                        <a href="{{ route('modals.display',['modal'=>'objective-answer','reference'=>'answer','reference_id'=>$ans_coll->id]) }}" data-toggle='modal' data-target='#page-modal'>
                                                            Objective Result
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($ans_coll)
                                                        <a href="{{ route('modals.display',['modal'=>'subjective-answer','reference'=>'answer','reference_id'=>$ans_coll->id]) }}" data-toggle="modal" data-target="#page-modal">
                                                            Subjective Answer
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class='card-footer'>
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
    <div class="modal fade text-left" id="page-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
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
            $('#page-modal').on('shown.bs.modal', function (event) {
                $.ajax({
                    method : "GET",
                    url : event.relatedTarget.href,
                    success: function (response){
                        $("#modal-content").html(response);
                    }
                });
            })
        });
   </script>
   
@endSection()
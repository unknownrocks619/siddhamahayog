@extends('layouts.admin')

@section('page_css')

@endSection()

@section('content')
<section id="headers">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        {{ $user_detail->full_name() }} 
                        <span id='pet_name_container'>
                        @if($user_detail->pet_name)
                            ( {{ $user_detail->pet_name }} )
                        @else
                            (
                            <a 
                                data-toggle="modal" 
                                data-target="#display_modal"
                                href="{{ route('modals.display',['modal'=>'user_petname_modal','user_detail_id'=>$user_detail->id]) }}">
                               Add Pet Name
                            </a>
                            )
                        @endif
                        </span>
                    </h4>
                </div>
                <div class='card-body'>
                    @include ('admin.users.detail.navigation')
                </div>
            </div>
        </div>
    </div>
    <div class="row" id='profile_detail_card'>
        <div class="col-md-12">
            <div class="card" id='user_verification_update'>
                @php
                    $file_detail = ($verifications) ? json_decode($verifications->document_file_detail) : [];
                @endphp
                <div class="card-header">
                    <h4 class="card-title">
                        @if($file_detail && $verifications->verified && $verifications->parent_name)
                            <span class='text-success'>Verified User</span>
                        @else
                            <a 
                                data-toggle="modal"
                                data-target="#display_modal"
                            href="{{ route('modals.display',['modal'=>'user_verification_modal','user_detail_id'=>$user_detail->id]) }}" class=' btn btn-primary'>Verify User</a>
                        @endif
                    </h4>
                </div>
                <div class="card-body">
                <table class='table table-bordered table-hover'>
                    <thead>
                        <tr>
                            <th>
                                Parent / Gaurdian Name
                            </th>
                            <th>
                                Parent / Gaurdian Contact
                            </th>
                            <th>
                                Document Type
                            </th>
                            <th>Preview</th>
                            <th>                                
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                @if($verifications && $verifications->parent_id)
                                    <a  data-toggle="modal"
                                data-target="#display_modal"
                                href="{{ route('modals.display',['modal'=>'user_maritial_modal','user_detail_id'=>$user_detail->id]) }}">
                                        {{ $verifications->parent_name ?? "Info Not Available" }}
                                    </a>
                                @else
                                    {{ $verifications->parent_name ?? "Info Not Available" }}
                                @endif
                            </td>
                            <td>{{ $verifications->parent_phone ?? "Info Not Available" }}</td>
                            <td>
                                {{ $verifications->verification_type ?? "Info Not Available" }}
                            </td>
                            <td>
                                @if($file_detail)
                                    <img src='{{ asset($file_detail->path) }}' class='img-thumbnail img-circle' style="width:75px;border-radius:20px" />
                                @else
                                    Info Not Available
                                @endif
                            </td>
                            <td>
                                @if($file_detail)
                                    <a href='{{ asset($file_detail->path) }}' target="_blank">
                                        [download]
                                    </a>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
                    
                </div>
            </div>
        </div>
       
    </div>


    <!-- start modal -->
    <div class="modal fade text-left" id="display_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
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

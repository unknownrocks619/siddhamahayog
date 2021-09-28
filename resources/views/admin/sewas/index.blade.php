@extends('layouts.admin')

@section('page_css')

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/css/core/menu/menu-types/vertical-menu.min.css') }}">

@endSection()

@section('content')
<!-- Complex headers table -->
<section id="headers">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Available Sewa</h4>
        </div>
        <div class="card-body card-dashboard">
          <p class="card-text text-right">
            <!-- <a href='' class='btn btn-info'>Export To Excel</a> -->
            <!-- <a href='#' id="onshown" class='btn btn-primary' data-toggle='modal' data-target="#default">Create New Sewa</a> -->
            <a href='#' id="onshowbtn" class='btn btn-primary' data-toggle="modal" data-target="#default">
              <span class='ficon  bx bx-plus-medical'>
              Create New Sewa
              </span>
            </a>           
          </p>
          <div class="table-responsive" id='sewa_data'>
            <table class="table table-striped table-bordered complex-headers">
              <thead>
                <tr>
                  <th rowspan="2" class="align-center">Sewa Name</th>
                  <th rowspan='2' class="text-center">Sewa Description</th>
                  <th colspan="2" class='text-center  bg-dark text-white'>Engagement</th>
                  <th rowspan="2" class=''>Action</th>
                </tr>
                <tr class=''>
                  <th>People</th>
                  <th>People Siged</th>
                </tr>
              </thead>
              <tbody>
                @foreach($sewas as $sewa)
                    <tr>
                        <td>
                            {{ $sewa->sewa_name }}
                        </td>
                        <td>
                            {{ $sewa->description }}
                        </td>
                        <td>
                            total people 0
                        </td>
                        <td>
                            Total People 0
                        </td>
                        <td>
                          <a href='#' data-option="{{ $sewa->id }}" data-toggle="modal" data-target="#default">
                            Edit
                          </a>
                          &nbsp; | &nbsp;
                          <a href='#' class='text-danger' data-option="{{ encrypt($sewa->id) }}" data-toggle="modal" data-target="#delete">
                            Delete
                          </a>

                        </td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
            {{ $sewas->onEachSide(5)->links() }}
        <!-- start modal -->
        <div class="modal fade text-left" id="default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title" id="myModalLabel1">Create new Sewa</h3>
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

        <!-- Delete Modal -->
          <div class="modal fade text-left" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header ">
                  <h3 class="modal-title" id="myModalLabel1">Confirm Delete</h3>
                  <button type="button" class="close rounded-pill bg-success text-white" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                  </button>
                </div>
                <div class='modal-body bg-danger'>
                  <div id="delete-modal-content">Loading Form, Please wait...</div>
                </div>
              </div>
            </div>
          </div>
        <!-- / Delete Modal -->
      </div>
    </div>
  </div>
  
</section>
<!--/ Complex headers table -->
@endSection()

@section('page_js')
    <!-- BEGIN: Page JS-->
    <script>
      $(document).ready(function(){
        $('#default').on('shown.bs.modal', function (event) {
          var option=$(event.relatedTarget).attr('data-option');
          var url = '{{ url("admin/services/sewas/form") }}';
          var data = "";
          if (option !== undefined) {
            url = url + "?sewa_id="+option; 
            data = 'sewa_id='+option;
          }
          $.ajax({
              method : "GET",
              data : data,
              url : url,
              success: function (response){
                $("#modal-content-fetch").html(response);
              }
          });

        })

        $('#default').on('hidden.bs.modal', function () {
          $("#sewa_data").text('loading...');
          $("#sewa_data").load('{{ url("admin/services/sewas/index #sewa_data") }}')
          // $('#myInput').trigger('focus')
          // $.ajax({

          // });
        });


        //delete modal
        $('#delete').on('shown.bs.modal', function (event) {
          var option=$(event.relatedTarget).attr('data-option');
          var url = '{{ url("admin/services/sewas/delete-form") }}';
          var data = "";
          if (option !== undefined) {
            url = url + "?sewa_id="+option; 
            data = 'sewa_id='+option;
          }
          $.ajax({
              method : "GET",
              data : data,
              url : url,
              success: function (response){
                $("#delete-modal-content").html(response);
              }
          });

        })
        
      });

    </script>
@endSection()
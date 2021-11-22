@extends('layouts.admin')

@section('page_css')
  <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/css/core/menu/menu-types/vertical-menu.min.css') }}">
  <link ref='stylesheet' href='{{ asset("admin/app-assets/css/jquery.fancybox.min.css") }}' />
@endSection()

@section('content')
<!-- Complex headers table -->
<section id="headers">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Chapters</h4>
        </div>
        <div class="card-body card-dashboard">
          <p class="card-text text-right">
            <!-- <a href='' class='btn btn-info'>Export To Excel</a> -->
            <a href='{{ route("chapters.admin_add_new_chapters") }}' class='btn btn-info'>Add New Chapter</a>
          </p>
          <div class="table-responsive">
            <table class="table table-striped table-bordered complex-headers">
                <thead>
                    <tr>
                        <th  class="align-center">Sibir / Event</th>
                        <th  class="text-center bg-dark text-white">Chapter Name</th>
                        <th  class='text-center  bg-dark text-white'>Total Lession</th>
                        <th rowspan="2" class='bg-success'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $chapters as $chapter)
                        <tr>
                            <td>
                              {{ $chapter->sibir_record->sibir_title }}
                            </td>
                            <td>
                              {{ $chapter->chapter_name }}
                            </td>
                            <td>
                              {{ $chapter->total_lessions }}
                            </td>
                            <td>

                              <a href="{{ route('chapters.admin_edit_chapter_detail',$chapter->id) }}">Edit</a> | 
                              <a class='text-info' href="{{ route('chapters.lession.admin_course_videos',$chapter->id) }}">View Chapters</a> | <a href="" class='text-danger'> Delete</a>

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
          </div>
      </div>
    </div>
  </div>
  
</section>
<!--/ Complex headers table -->
@endSection()

@section('page_js')
<script src="{{ asset ('admin/app-assets/js/scripts/modal/components-modal.min.js') }}"></script>
<script src="{{ asset ('admin/app-assets/js/scripts/jquery.fancybox.min.js') }}"></script>
<script>
  $(document).on('keydown.fb', function (e) {

var keycode = e.keyCode || e.which;

if (keycode === 27) {

  e.preventDefault();

  parent.jQuery.fancybox.getInstance().close();

  return;
}

});
  </script>
@endSection()
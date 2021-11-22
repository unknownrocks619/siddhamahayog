@extends('layouts.admin')


@section('content')
<section class="users-edit">
    <div class="card">
        <div class='card-header px-2 py-2 bg-dark text-white'>
            <div class="row">
                <div class="col-md-9">
                    <h4 class='card-title text-white'>Create New Chapters</h4>
                </div>
                <div class="col-md-3">
                    <a href="#">Go Back</a>
                </div>
            </div>
        </div>
        <x-alert></x-alert>
        <form method="POST" action="{{ route('chapters.admin_store_chapter') }}">
        @csrf
            <div class='card-body mt-2'>
                <div class='row'>
                    <div class='col-md-6 col-sm-12'>
                        <!-- <h5>Center Information</h5> -->
                        <div class='form-group'>
                            <label class='control-label'>Select Sibir</label>
                            <select class='form-control' name='sibir_record_id'>
                                @foreach ($sibir_records as $sibir )
                                    <option value='{{ $sibir->id }}' @if(old("sibi_record_id") == $sibir->id) selected @endif> {{ $sibir->sibir_title }} </option> 
                                @endforeach
                            </select>
                        </div>
                        <div class='form-group'>
                            <label class='control-label'>Chapter Name</label>
                            <input type="text" name='chapter_name' class='form-control' value="{{ old('chapter_name') }}" />
                        </div>
                        <div class='form-group'>
                            <label class='control-label'>Short Description About Chapter</label>
                            <textarea name='description' class='form-control'>{{ old('description') }}</textarea>
                        </div>
                       
                    </div>
                    <div class='col-md-6 col-sm-12'>
                        <div class='form-group'>
                            <label class='control-label'>Chapter Status</label>
                            <select name="chapter_status" class='form-control'>
                                <option value="yes" @if(old('chapter_status') == "yes") selected @endif >Active</option>
                                <option value="no" @if(old('chapter_status') == "no") selected @endif>Inactive</option>
                            </select>
                        </div>
                        <div class='form-group'>
                            <label class='control-label'>Locked</label>
                            <select name="chapter_locked" class='form-control'>
                                <option value="yes" @if(old('chapter_locked') == "yes") selected @endif>Yes</option>
                                <option value="no" @if(old('chapter_locked') == "no") selected @endif>No</option>
                            </select>
                        </div>

                    </div>

                </div>

                <div class='row'>
                    <button type='submit' class='btn btn-primary btn-block'>Add Chapter</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endSection()

@section('page_js')
<!-- <script src="{{ asset ('admin/app-assets/js/scripts/pages/dashboard-analytics.min.js') }}"></script> -->
@endSection()
@extends('layouts.admin')


@section('content')
<section id="headers">
    <div class="row">
        <div class="col-12">
            <x-alert></x-alert>
            <form method="post" action="{{ route('questions.admin_save_question_collection') }}">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            All Question Paper
                        </h4>
                    </div>
                    <div class='card-body'>
                        <p class="card-text text-right">
                            <!-- <a href='' class='btn btn-info'>Export To Excel</a> -->
                            <a href="{{ route('questions.admin_question_collection_list') }}" class='btn btn-info'>
                                <i class='fas fas-arrow-left'></i>
                                Go Back
                            </a>
                        </p>
                        <div class='row'>
                            <div class='col-md-6'>
                                <label class='label-control'>
                                    Select Sibir / Class
                                </label>
                                <select class="form-control" name='sibir'>
                                    @php
                                        $sibirs = \App\Models\SibirRecord::get();
                                        foreach ($sibirs as $sibir){
                                            echo "<option value='{$sibir->id}'";
                                                if (old('sibir') == $sibir->id) {
                                                    echo "selected";
                                                }
                                            echo ">";
                                                echo $sibir->sibir_title;
                                            echo "</option>";
                                        }
                                    @endphp
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="label-control">
                                    Question Display
                                </label>
                                <select name='sortable' class='form-control'>
                                    <option value='1'>Sort Question in Random Order</option>
                                    <option value='0'>Do not short question</option>
                                </select>
                            </div>
                        </div>
                        <div class='row mt-3'>
                            <div class='col-md-6'>
                                <label class='label-control'>Exam Title</label>
                                <input type="text" value="{{ old('exam_title') }}" name="exam_title" class='form-control' />
                                @error("exam_title")
                                <div class='text-danger'> {{ $message }} </div>
                                @enderror
                            </div>

                            <div class='col-md-3'>
                                <label class='label-control'>
                                    Start Date
                                </label>
                                <input type="date" value="" class='form-control' name="exam_start_date" />
                                @error("exam_start_date")
                                <div class='text-danger'> {{ $message }} </div>
                                @enderror
                            </div>
                            <div class='col-md-3'>
                                <label class='label-control'>
                                    Start Time
                                </label>
                                <input type="time" class='form-control' name="exam_start_time" />
                                @error("exam_start_time")
                                <div class='text-danger'> {{ $message }} </div>
                                @enderror
                            </div>
                        </div>

                        <div class='row mt-3'>
                            <div class='col-md-6'>
                                <label class='label-control'>Exam Time (In minutes)</label>
                                <input type="text" value="{{ old('exam_in_minute') }}" class='form-control' name="exam_in_minute" />
                                @error("exam_in_minute")
                                <div class='text-danger'> {{ $message }} </div>
                                @enderror
                            </div>

                            <div class='col-md-3'>
                                <label class="label-control">End Date</label>
                                <input type="date" class='form-control' name="exam_end_date" />
                                @error("exam_end_date")
                                <div class='text-danger'> {{ $message }} </div>
                                @enderror
                            </div>
                            <div class='col-md-3'>
                                <label class="label-control">End Time</label>
                                <input type="time" class='form-control' name="exam_end_time" />
                                @error("exam_end_time")
                                <div class='text-danger'> {{ $message }} </div>
                                @enderror
                            </div>
                        </div>

                        <div class='row mt-3'>
                            <div class='col-md-12'>
                                <label class='label-control'>Description</label>
                                <textarea class='form-control' name='description'>{{ old('exam_detail') }}</textarea>
                                @error("description")
                                <div class='text-danger'> {{ $message }} </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class='card-footer'>
                        <div class='row'>
                            <div class='col-md-12'>
                                <button type="submit" class="btn btn-primary btn-block btn-lg">
                                    Add Question paper
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endSection()
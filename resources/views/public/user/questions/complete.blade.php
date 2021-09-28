@extends("layouts.clients")

@section("breadcrumb")
	<!-- Breadcrumb -->
	<div class="breadcrumb-bar">
			<div class="container-fluid">
				<div class="row align-items-center">
					<div class="col-md-12 col-12">
						<nav aria-label="breadcrumb" class="page-breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="{{route('public_user_dashboard')}}">Home</a></li>
								<li class="breadcrumb-item"><a href="{{ route('public.exam.public_examination_list') }}">Exam / Evaulation</a></li>
								<li class="breadcrumb-item active" aria-current="page">{{ $question->question_term }}</li>
							</ol>
						</nav>
						<h2 class="breadcrumb-title">{{ $question->question_term }}</h2>
					</div>
				</div>
			</div>
		</div>
	<!-- /Breadcrumb -->
@endsection

@section("content")
<div class="container-fluid text-center">
    <div class='row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-sm-offset-2 col-md-offset-3'>
            <h2 style="color: rgb(24, 157, 14);">
            <i aria-hidden="true" class="fa fa-whatsapp"></i>
                Congratulation !! Exam Completed.
            </h2>
        </div>
    </div>
    <div class='row d-flex justify-content-center'>
        <div class='col-md-4 bg-white d-flex justify-content-center py-3 px-4'>
            <p>
                You have successfully submited your answer based. For all Objective question all answer is already evaulated but for subjective answer please wait until you are marked.
            </p>
        </div>
    </div>

    <div class="row d-flex justify-content-center">
        <div class='col-md-4 bg-white d-flex justify-content-center py-3 px-4'>
            <a href="{{ route('public.exam.public_examination_list') }}" class='btn btn-primary btn-bg btn-block'>Submit All Paper</a>
        </div>
    </div>
</div>
@endsection
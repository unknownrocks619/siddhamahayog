@if(notices()->count())
@foreach (\App\Models\Notices::where('active',true)->get() as $notice)
@include("frontend.user.notices.type.".$notice->notice_type,compact("notice"))
@endforeach
@endif
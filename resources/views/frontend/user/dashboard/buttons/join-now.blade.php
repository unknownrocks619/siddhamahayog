
<form id="joinSessionForm" action="{{ route('user.account.event.live',[$program->id,$live->id]) }}" method="post">
    @csrf
    <button type="submit" class="join_button fw-semibold btn btn-sm btn-success">
        Join Now
    </button>
</form>
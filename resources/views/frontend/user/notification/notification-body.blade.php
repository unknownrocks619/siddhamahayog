<div class="row">
    <div class="col-md-12 bg-secondary ps-3">
        <h4 class="pb-3 pt-3  text-white">
            {{ $notification->title }}
        </h4>
    </div>
    <div class="col-md-12 border pt-3 ps-3">
        <p class="fs-4">{!! strip_tags($notification->body,"<p>,<b>,<div>,<span>") !!}</p>
    </div>
</div>

<script>
    $(document).ready(function() {
        $.ajax({
            type: 'post',
            url: "{{ route('user.account.notification-update',$notification->id) }}",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            global: false,
        })
    })
</script>

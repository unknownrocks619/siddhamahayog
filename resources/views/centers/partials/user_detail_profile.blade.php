<div class='card-body text-center'>
    @if($user_detail->user_profile)
        <img id='parent_image_id' src="{{ asset ($user_detail->user_profile->image_url) }}" class="card-img-top" style="width:12rem" />
    @else
        <img id="parent_image_id" src="{{ asset ('thumbs/blank.png') }}" class='card-img-top' style="width:12rem" />
    @endif
    <p ><button type='button' onclick='newCapture()' class='btn btn-link'>[Capture New Image]</button></p>
    <h5 class="card-title text-center">{{ $user_detail->full_name() }}</h5>
    <p class='card-text text-left' id="text">
        Phone Number : {{ $user_detail->phone_number }}
        <br />
        Address : {{ $user_detail->address() }}
        <br />
        User Type : {{ $user_detail->user_type }}
    </p>    
</div>
<script>
var newCapture = function () {
    window.open("{{ route('modals.display') }}?modal=user_webcam_display&user_detail_id={{ $user_detail->id }}",'Visitors Photo','width=800,height=450,resizable=no');    
}

newCapture.onunload = function(){ console.log('Child window closed'); };


        // webCampWindow = window.open("{{ route('modals.display') }}?modal=user_webcam_display&user_detail_id={{ $user_detail->id }}",'Visitors Photo','width=800,height=450,resizable=no');
</script>
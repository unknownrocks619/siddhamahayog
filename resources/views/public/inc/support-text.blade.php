<p class='text-danger'>
    If case of  any problem in the system. Please Contact Our IT Support with following Detail: <br /> Ticket No:
    @php
//						$user_detail = \App\Models\userDetail::find(auth()->user()->user_detail_id);
        echo auth()->user()->user_detail_id . "-".time();
    @endphp
</p>
@php
$live = \App\Models\Live::where('id',request()->live)->first();
$ramdas = \App\Models\Ramdas::where('meeting_id', $live->meeting_id)->get();
@endphp
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel1">Ram Das List</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
    <div class="row">
        <div class="col-md-12 table">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>
                            Staff / Member Name
                        </th>
                        <th>
                            Joined Time
                        </th>
                        <th>
                            Zoom Name
                        </th>
                        <th>
                            Reference Number
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ramdas as $ramdas_list)
                        <tr>
                            <td>
                                {{$ramdas_list->full_name}}
                            </td>
                            <td>
                                {{$ramdas_list->created_at}}
                            </td>
                            <td>
                                Ram Das ({{$ramdas_list->reference_number}})
                            </td>
                            <td>
                                {{$ramdas_list->reference_number}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
</div>

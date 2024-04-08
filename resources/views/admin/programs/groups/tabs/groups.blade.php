<div class="row">
    <div class="col-md-12 d-flex justify-content-between">
        <div></div>
        <div>
            <button class="btn btn-danger data-confirm btn-icon" data-confirm="This will remove all the people from the group. This action cannot be undone ? do you wish to continue." data-method="post" data-action="{{route('admin.program.admin_program_group_delete',['group' => $group,'program' => $program,'type' => 'people'])}}">
                <i class="fas fa-refresh"></i>
            </button>
            <button class="btn btn-success btn-icon" data-bs-toggle='modal' data-bs-target='#addMember'>
                <i class="fas fa-add"></i>
            </button>
            <a href="{{route('admin.program.admin_program_group_edit',['group' => $group,'tab' => 'groups','program' => $program])}}?view=table" class="btn btn-success btn-icon @if($view == 'table') disabled @endif"  @if($view == 'table') disabled @endif  data-bs-title='Table View' title="Table View">
                <i class="fas fa-table"></i>
            </a>
            <a href="{{route('admin.program.admin_program_group_edit',['group' => $group,'tab' => 'groups','program' => $program])}}" class="btn btn-success btn-icon  @if($view == 'card') disabled @endif"  @if($view == 'card') disabled @endif data-bs-title="Card View" title='Card View' data-bs-original-title='Card View'>
                <i class="fas fa-box"></i>
            </a>

        </div>
    </div>
</div>

@if ($view == 'card')
    @php 
        $groups->chunk(3, function($groupsAll){
            echo '<div class="row my-3">';
                foreach($groupsAll as $people):
                    echo view('admin.programs.groups.tabs.people-card',['people' => $people])->render();
                endforeach;
            echo '</div>';
        })
    @endphp
@endif

@if($view == 'table')
    <div class='row'>
        <div class='col-md-12 table-responsive'>
            <table class='table table-hover table-bordered'>
                <thead>
                    <tr>
                        <th></th>
                        <th>Full Name</th>
                        <th>Family</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groups->paginate(250) as $people)
                        {!! view('admin.programs.groups.tabs.people-table',['people' => $people])->render() !!}
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
<x-modal modal='selectMember'></x-modal>
<x-modal modal='newFamily'></x-modal>
<x-modal modal='roomConfirmation'></x-modal>
<x-modal modal="addMember">
    @include('admin.modal.programs.groups.select-user',['program' => $program,'group' => $group])
</x-modal>
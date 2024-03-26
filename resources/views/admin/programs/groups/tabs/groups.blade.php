<div class="row">
    <div class="col-md-12 d-flex justify-content-between">
        <div></div>
        <div>
            <button class="btn btn-success btn-icon">
                <i class="fas fa-play"></i>
            </button>
            <button class="btn btn-success btn-icon">
                <i class="fas fa-card"></i>
            </button>

        </div>
    </div>
</div>

@php 
    $groups->chunk(3, function($groupsAll){
        echo '<div class="row my-3">';
            foreach($groupsAll as $people):
                echo view('admin.programs.groups.tabs.people-card',['people' => $people])->render();
            endforeach;
        echo '</div>';
    })
@endphp
<x-modal modal='selectMember'></x-modal>
<x-modal modal='newFamily'></x-modal>
<x-modal modal='roomConfirmation'></x-modal>
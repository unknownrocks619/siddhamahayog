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
    <div class="row">
        <div class="col-md-12 my-2">
            <div class="form-group">
                <input type="search" class="searchCardView form-control py-2">
            </div>
        </div>
        <div class="col-md-12" id="groups_people_list_card"></div>
    </div>
    
@endif

@if($view == 'table')
    <div class='row'>
        <div class='col-md-12 table-responsive'>
            <table class='table table-hover table-bordered' id="groups_people_list_table">
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
@if($view =='card')
    @push('page_script')
        <script>
            $(document).ready(function() {
                $.ajax({
                    type : "get",
                    url : "{{route('admin.program.admin_program_group_edit_view',['group' => $group,'program' => $program,'view' => 'card'])}}",
                    success: function(response) {
                        $('#groups_people_list_card').html(response.params.view);
                    }
                })
            })
            $('.serachCardView').on('change',function(event) {
                if ($(this).val() == '' ) {
                    $(this).trigger('keypress');
                }
            })
            $('.searchCardView').keypress(function(event) {
                let _this = this;
                if ($(this).val() == '') {
                    console.log('hello woere');
                    let _page = $(document).find('.page-item.active').attr('data-current-page');
                    $.ajax({
                    type : "get",
                    url : "{{route('admin.program.admin_program_group_edit_view',['group' => $group,'program' => $program,'view' => 'card'])}}?page="+_page,
                        success: function(response) {
                            $('#groups_people_list_card').html(response.params.view);
                        }
                    })

                    return;
                }
                $.ajax({
                    type : "get",
                    url : "{{route('admin.program.admin_program_group_edit_view',['group' => $group,'program' => $program,'view' => 'card'])}}?search="+ $(_this).val(),
                        success: function(response) {
                            $('#groups_people_list_card').html(response.params.view);
                        }
                    })

            })


            $(document).on('click','[data-current-page]', function(event) {
                event.preventDefault();
                let _this = this;
                $.ajax({
                    type : "get",
                    url : "{{route('admin.program.admin_program_group_edit_view',['group' => $group,'program' => $program,'view' => 'card'])}}?page="+$(_this).attr('data-current-page'),
                    success: function(response) {
                        $('#groups_people_list_card').html(response.params.view);
                    }
                })
            })
        </script>
    @endpush
@endif
@if($view == 'table')
    @push('page_script')
    <script>
        $('#groups_people_list_table').DataTable({
            processing: true,
            serverSide: true,
            fixedHeader: true,
            orderCellsTop: true,
            pageLength: 150,
            aaSorting: [],
            ajax: "{{route('admin.program.admin_program_group_edit_view',['group' => $group,'program' => $program,'view' => 'table'])}}",
            columns: [
                {
                    data: "input",
                    name: "input"
                },
                {
                    data: "full_name",
                    name: "full_name"
                },
                {
                    data: "family",
                    name: "famili"
                },
                {
                  data : 'remarks',
                  name: 'remarks'
                },
                {
                    data: "action",
                    name: "action"
                }
            ]
        });

        // $(function(){
        //     var e=document.getElementById("quickUserView")
        //     e.addEventListener("show.bs.modal",function(e){var t=document.querySelector("#wizard-create-app");if(null!==t){var n=[].slice.call(t.querySelectorAll(".btn-next")),c=[].slice.call(t.querySelectorAll(".btn-prev")),r=t.querySelector(".btn-submit");const a=new Stepper(t,{linear:!1});n&&n.forEach(e=>{e.addEventListener("click",e=>{a.next(),l()})}),c&&c.forEach(e=>{e.addEventListener("click",e=>{a.previous(),l()})}),r&&r.addEventListener("click",e=>{alert("Submitted..!!")})}})
        // })
    </script>

    @endpush
@endif
@push('page_script')
    <script src="{{ asset ('themes/admin/assets/vendor/libs/bs-stepper/bs-stepper.js')}}"></script>

    <script>
        $('#program-table').DataTable({
            processing: true,   
            serverSide: true,
            fixedHeader: true,
            orderCellsTop: true,
            aaSorting: [],
            ajax: "{{route('admin.program.admin_program_list')}}",
            columns: [
                {
                    data: 'program_name',
                    name: 'program_name'
                },
                {
                    data: "total_student",
                    name: "total_student"
                },
                {
                    data: "promote",
                    name: "promote"
                },
                {
                    data: "batch",
                    name: "batch"
                },
                {
                  data : 'sections',
                  name: 'sections'
                },
                {
                    data: "action",
                    name: "action"
                }
            ]
        });

        $(function(){
            var e=document.getElementById("quickUserView")
            e.addEventListener("show.bs.modal",function(e){var t=document.querySelector("#wizard-create-app");if(null!==t){var n=[].slice.call(t.querySelectorAll(".btn-next")),c=[].slice.call(t.querySelectorAll(".btn-prev")),r=t.querySelector(".btn-submit");const a=new Stepper(t,{linear:!1});n&&n.forEach(e=>{e.addEventListener("click",e=>{a.next(),l()})}),c&&c.forEach(e=>{e.addEventListener("click",e=>{a.previous(),l()})}),r&&r.addEventListener("click",e=>{alert("Submitted..!!")})}})
        })
    </script>
@endpush

@push('vendor_css')
    <link rel="stylesheet" href="{{ asset ('themes/admin/assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />

@endpush

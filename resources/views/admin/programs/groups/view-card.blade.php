<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ID Card</title>
    <style>
        @media print {
            .container {
                position: relative;
                width: 210mm; /* A4 width */
                height: 297mm; /* A4 height */

            }
            .section {
                width: 105mm; /* A6 width */
                height: 148mm; /* A6 height */
                position: absolute; /* Position elements absolutely */
                overflow: hidden
            }
            
            .top-left {
                top: 0;
                left: 0;
            }
            
            .top-right {
                top: 0;
                right: 0;
            }
            
            .bottom-left {
                bottom: 0;
                left: 0;
            }
            
            .bottom-right {
                bottom: 0;
                right: 0;
            }

            .section:nth-child(4n) {
                page-break-after: always !important; /* Start new page after every 4th section */
            }
            .container:not(:first-child) {
                page-break-before: always; /* Start new page before every container except the first one */
            }
            .no-print-area {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div style="width: 100%;margin: 10px" class="no-print-area">
        <form action="{{route('admin.program.amdmin_group_card_view',['group' => $group,'program' => $program])}}" method="get">
            <input type="text" name="bulkPrint" placeholder="Please Enter Registration Code: 123,123,433,353" style="font-size:30px;width:100%" />
            <button type="submit" style="font-size: 34px; background-color:gold">Display Card</button>
            <a href="{{route('admin.program.admin_program_group_edit',['program' => $program,'group' => $group,'tab' => 'groups'])}}">Go back</a>
        </form>

    </div>
    @foreach ($printCards as $cards)
        <div class="container">

            @php $loopKey = ['top-left','top-right','bottom-left','bottom-right']; @endphp

            @foreach ($cards as $key => $card)
                <div class="section {{$loopKey[$key]}}">
                    <img src={{$card}} />
                </div>
            @endforeach
        </div>
    @endforeach
</body>
</html>
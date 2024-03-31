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
                border: 1px solid black; /* Optional: Add a border for visualization */
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
        }
    </style>
</head>
<body>
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
    <div class="container">
        <div class="section top-left">
            
        </div>
        <div class="section top-right">
            <p>Section 2</p>
        </div>
        <div class="section bottom-left">
            <p>Section 3</p>
        </div>
        <div class="section bottom-right">
            <p>Section 4</p>
        </div>
    </div>
    <div class="container">
        <div class="section top-left">
            <p>Section 5</p>
        </div>
        <div class="section top-right">
            <p>Section 6</p>
        </div>
        <div class="section bottom-left">
            <p>Section 7</p>
        </div>
        <div class="section bottom-right">
            <p>Section 8</p>
        </div>
    </div>
</body>
</html>
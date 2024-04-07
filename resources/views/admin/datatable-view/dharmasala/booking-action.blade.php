@php
    /** @var DharmasalaBooking  $booking*/
    use App\Models\Dharmasala\DharmasalaBooking;
    use Illuminate\Support\Carbon;

    $action = [];
    $today = Carbon::today();
@endphp
@if( $booking->status == DharmasalaBooking::PROCESSING)
    @php
        $action[] = [
                    'tag' => 'a',
                    'route' => '',
                    'label' => 'Confirm Booking',
                    'class' => 'btn btn-primary',
                    'attribute' => [
                        'href'   => route('admin.dharmasala.booking.confirmation',['booking' => $booking])
                    ]
                ];

    @endphp

@else
    @php
        if (strlen($booking->check_in) > 10 ) {

            $checkInDate = Carbon::createFromFormat('Y-m-d H:i:s', $booking->check_in);
        } else {
            $checkInDate = Carbon::createFromFormat('Y-m-d', $booking->check_in);
        }

    if (($today->greaterThanOrEqualTo($checkInDate) || $checkInDate->isToday()) && ! in_array($booking->status,[DharmasalaBooking::CHECKED_IN,DharmasalaBooking::CANCELLED,DharmasalaBooking::CHECKED_OUT])) {
        $action[] = [
                        'tag' => 'button',
                        'route' => '',
                        'label' => 'Check In',
                        'class' => 'btn btn-primary data-confirm',
                        'attribute' => [
                            'data-confirm' => 'Confirm Check In User. ',
                            'data-method'   => 'POST',
                            'data-action'   => route('admin.dharmasala.update-booking-status',['booking' => $booking->getKey(),'type'=>'check-in','action' => 'datatable'])
                        ]
                    ];

        $action[] = [
                        'tag' => 'button',
                        'route'   => '',
                        'label'   => 'Cancel ' . DharmasalaBooking::STATUS[$booking->status],
                        'class' => 'btn btn-danger data-confirm',
                        'attribute' => [
                            'data-confirm'  => 'You are about to cancel active booking.',
                            'data-method'   => 'POST',
                            'data-action'   => route('admin.dharmasala.update-booking-status',['booking' => $booking->getKey(),'type' => 'cancel','action' => 'datatable']),
                        ]
                    ];
    }

    if ($booking->status == DharmasalaBooking::CHECKED_IN) {
        $action[] = [
                    'tag' => 'button',
                    'route' => '',
                    'label' => 'Check Out',
                    'class' => 'btn btn-success ajax-modal' ,
                    'attribute' => [
                        'data-bs-target'    => '#checkOut',
                        'data-bs-toggle'    => 'modal',
                        'data-action'   => route('admin.modal.display',['view' => 'dharmasala.booking.check-out','booking' => $booking->getKey(),'action' => 'datatable']),
                        'data-method'   => 'get'
                    ]
                ];
    }

    if ( ! $checkInDate->isToday() && $today->lessThan($checkInDate) &&  ! in_array( $booking->status,[DharmasalaBooking::CANCELLED, DharmasalaBooking::CHECKED_IN, DharmasalaBooking::CHECKED_OUT]) ) {
        $action[] = [
                        'tag' => 'button',
                        'route' => '',
                        'class' => 'btn btn-danger data-confirm',
                        'label' => 'Cancel '. DharmasalaBooking::STATUS[$booking->status],
                        'attribute' => [
                            'data-confirm' => 'You are about to cancel a expired booking. Proceed with your action ?',
                            'data-action'   => route('admin.dharmasala.update-booking-status',['booking' => $booking->getKey(),'type' => 'cancel','action' => 'datatable']),
                            'data-method'   => 'POST'
                        ]
                    ];
    }
    @endphp
@endif

@foreach($action as $value)
    <{{$value['tag']}} class='me-1 {{$value['class']}}'
        @foreach ($value['attribute'] as $attributeKey => $attributeValue)
            {{$attributeKey}}="{{$attributeValue}}"
        @endforeach
    >
        {{$value['label']}}
    </{{$value['tag']}}>

@endforeach

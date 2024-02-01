<?php

namespace App\Http\Controllers\Admin\Dharmasala;
use App\Classes\Helpers\Image;
use App\Http\Controllers\Controller;
use App\Models\Dharmasala\DharmasalaBooking;
use App\Models\Dharmasala\DharmasalaBuilding;
use App\Models\Dharmasala\DharmasalaBuildingFloor;
use App\Models\Dharmasala\DharmasalaBuildingRoom;
use App\Models\Donation;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use DataTables;

class BookingController extends  Controller
{
    public function index(Request $request, $filter=0) {
        $params = ['filter' => $filter,'sort' => []];

        if ( $request->user ) {
            $params['sort']['user'] =  $request->user;
        }

        if ( $request->check_in) {
            $params['sort']['check_in'] = $request->check_in;
        }

        if ( $request->filter_room ) {
            $params['sort']['filter_room'] = $request->filter_room;
        }

        if ( $request->check_out) {
            $params['sort']['check_out'] = $request->check_out;
        }

        if ($request->ajax() && $request->wantsJson()) {

            $searchTerm = isset($request->get('search')['value']) ? $request->get('search')['value'] : '';
            $bookingsModel = DharmasalaBooking::select("*");

            if ( $filter ) {
                $bookingsModel->where('status',(int) $filter);
            }

            if ($searchTerm ) {
                $bookingsModel->where(function($query) use ($searchTerm){

                $query->where('full_name','LIKE','%'.$searchTerm.'%')
                                ->OrWhere('floor_name','LIKE','%'.$searchTerm.'%')
                                ->OrWhere('building_name','LIKE','%'.$searchTerm.'%')
                                ->OrWhere('room_number','LIKE','%'.$searchTerm.'%')
                                ->OrWhere('email','LIKE','%'.$searchTerm.'%')
                                ->OrWhere('check_in','LIKE','%'.$searchTerm.'%')
                                ->OrWhere('check_out','LIKE','%'.$searchTerm.'%');
                });
            }

            if ( $request->user ) {
                $bookingsModel->where('email',$request->user);
                $params['sort']['user'] =  $request->user;
            }

            if ( $request->check_in) {
                $bookingsModel->where('check_in',$request->check_in);
                $params['sort']['check_in'] = $request->check_in;
            }

            if ( $request->filter_room) {
                $bookingsModel->where('room_number',$request->filter_room);
                $params['sort']['filter_room'] = $request->filter_room;
            }

            if ( $request->check_out) {
                $bookingsModel->where('check_out',$request->check_out);
                $params['sort']['check_out'] = $request->check_out;
            }

            $datatable = DataTables::of($bookingsModel->get())
                ->addIndexColumn()
                ->addColumn('full_name',function($row){
                    $action = "<a href='".route('admin.dharmasala.booking.list',['user' => $row->email])."'>";
                        $action .= $row->full_name;
                    $action .= "</a>";
                    return $action;
                })
                ->addColumn('floor_name', fn($row) => $row->floor_name)
                ->addColumn('room_number', function($row){
                    $action = "<a href='".route('admin.dharmasala.booking.list',['filter_room' => $row->room_number])."'>";
                        $action .= $row->room_number;
                    $action .= "</a>";
                    return $action;
                })
                ->addColumn('email' , fn($row) => $row->email)
                ->addColumn('check_in', function($row) use ($request) {
                    $action = "<a href='".route('admin.dharmasala.booking.list',['check_in' => $row->check_in])."'>";
                        $action .= $row->check_in;
                    $action .= "</a>";
                    return $action;
                })
                ->addColumn('check_out' ,function($row) {
                    $action = "<a href='".route('admin.dharmasala.booking.list',['check_out' => $row->check_out])."'>";
                        $action .= $row->check_out;
                    $action .= "</a>";
                    return $action;
                })
                ->addColumn('status', function($row) {
                    return DharmasalaBooking::STATUS[$row->status];
                })
                ->addColumn('qr' , fn($row) => QrCode::generate($row->uuid))
                ->addColumn('action', function ($row) {
                    $action = [];

                    $today = Carbon::today();
                    $checkInDate = Carbon::createFromFormat('Y-m-d', $row->check_in);

                    if (($today->greaterThanOrEqualTo($checkInDate) || $checkInDate->isToday()) && ! in_array($row->status,[DharmasalaBooking::CHECKED_IN,DharmasalaBooking::CANCELLED,DharmasalaBooking::CHECKED_OUT])) {
                        $action[] = [
                            'route' => '',
                            'label' => 'Check In',
                            'class' => 'btn btn-primary data-confirm',
                            'attribute' => [
                                'data-confirm' => 'Confirm Check In User. ',
                                'data-method'   => 'POST',
                                'data-action'   => route('admin.dharmasala.booking-check-in-reservation',['booking' => $row->getKey()])
                            ]
                        ];

                        $action[] = [
                            'route'   => '',
                            'label'   => 'Cancel ' . DharmasalaBooking::STATUS[$row->status],
                            'class' => 'btn btn-danger data-confirm',
                            'attribute' => [
                                'data-confirm'  => 'You are about to cancel active booking.',
                                'data-method'   => 'POST',
                                'data-action'   => route('admin.dharmasala.booking-cancel-reservation',['booking' => $row->getKey()]),
                            ]
                        ];
                    }

                    if ($row->status == DharmasalaBooking::CHECKED_IN) {
                        $action[] = [
                            'route' => '',
                            'label' => 'Check Out',
                            'class' => 'btn btn-success ajax-modal' ,
                            'attribute' => [
                                'data-bs-target'    => '#checkOut',
                                'data-bs-toggle'    => 'modal',
                                'data-action'   => route('admin.modal.display',['view' => 'dharmasala.booking.check-out','booking' => $row->getKey()]),
                                'data-method'   => 'get'
                            ]
                        ];
                    }

                    if ( ! $checkInDate->isToday() && $today->lessThan($checkInDate) &&  ! in_array( $row->status,[DharmasalaBooking::CANCELLED, DharmasalaBooking::CHECKED_IN, DharmasalaBooking::CHECKED_OUT]) ) {
                        $action[] = [
                                'route' => '',
                                'class' => 'btn btn-danger data-confirm',
                                'label' => 'Cancel '. DharmasalaBooking::STATUS[$row->status],
                                'attribute' => [
                                    'data-confirm' => 'You are about to cancel a expired booking. Proceed with your action ?',
                                    'data-action'   => route('admin.dharmasala.booking-cancel-reservation',['booking' => $row->getKey()]),
                                    'data-method'   => 'POST'
                                ]
                            ];
                    }

                    $actionButton = "";

                    foreach ($action as $value) {
                        $actionButton .= "<button class=' me-1 {$value['class']}'";

                        foreach ($value['attribute'] as $attributeKey => $attributeValue) {
                            $actionButton .= " " . $attributeKey .'="'.$attributeValue .'"';
                        }

                        $actionButton .= ">";
                        $actionButton .= $value['label'];
                        $actionButton .= "</butotn>";
                    }
                    return $actionButton;
                })
                ->rawColumns(["action",'status','qr','full_name','check_in','check_out','room_number'])
                ->make(true);
            return $datatable;
        }
        return view('admin.dharmasala.booking.list',$params);
    }
    
    public function confirmation(Request $request , DharmasalaBooking $booking) {
        $booking->load('getChildBookings');

        return view('admin.dharmasala.booking.confirmation',['booking' => $booking]);
    }

    public function create(Request $request, DharmasalaBuildingRoom $room = null, DharmasalaBuildingFloor $floor=null, DharmasalaBuilding $building=null) {
//        $request->validate([
//           'member.*' => 'required'
//        ]);

        if ( ! $room ) {

            $request->validate([
               'room_number'   => 'required'
            ]);
            $room = DharmasalaBuildingRoom::where('id', $request->post('room_number'))->first();
        }

        if ( ! $floor ) {
            $floor = DharmasalaBuildingFloor::where('id',$room->floor_id)->first();
        }

        if (! $building ) {
            $building = DharmasalaBuilding::where('id',$room->building)->first();
        }

        $memberRecord = Member::whereIn('id',$request->post('members'))
                                ->with('profileImage','memberIDMedia')
                                ->get();

        $error = [];
        foreach ($request->post('members') as $key => $value) {

            $member = $memberRecord->where('id',$value)->first();

            if ( ! $member) {
                continue;
            }


            $innerArray = [
                'room_number'   => $room->room_number,
                'building_id'   => $building?->getKey(),
                'floor_id'      => $floor?->getKey(),
                'room_id'       => $room->getKey(),
                'building_name' => $building?->building_name,
                'floor_name'    => $floor?->floor_name,
                'member_id'     => $member->getKey(),
                'full_name'     => $member->full_name,
                'email'         => $member->email,
                'phone_number'  => $member->phone_number,
                'check_in'      => isset($request->post('check_in')[$key]) ? $request->post('check_in')[$key] : null,
                'check_out'     => isset($request->post('check_out')[$key]) ? $request->post('check_in')[$key]  : null,
                'profile'       => $member->profileImage?->filepath ? Image::getImageAsSize($member->profileImage?->filepath) :  null,
                'id_card'       => $member->memberIDMedia?->filepath ? Image::getImageAsSize($member->memberIDMedia?->filepath) :  null,
                'status'         => 1,
                'uuid'          => Str::uuid()
            ];

            $dharmasalaBooking = new DharmasalaBooking();
            try {
                $dharmasalaBooking->fill($innerArray)->save();
            } catch (\Error $error) {
                $error[] = [$error->getMessage()];
                continue;
            }

        }

        if ( count($error ) ) {
            return $this->json(false,'Some information contains error. Re-check your booking table for missing info.');
        }

        return $this->json(true,' New booking confirmed.','reload');

    }

    public function selectUsers(Request $request) {
        // search member and display result.
        $members = Member::where('email', $request->member)
                            ->orWhere('phone_number', 'like', '%' . $request->member . '%')
                            ->orWhere('first_name','LIKE','%'.$request->member.'%')
                            ->orWhere('last_name','LIKE','%'.$request->member.'%')
                            ->orWhere('full_name','LIKE','%'.$request->member.'%')
                            ->limit(30)
                            ->get();

        return view('admin.dharmasala.booking.partials.search-result', compact('members'));
    }

    public function cancelReservation(DharmasalaBooking $booking) {

        $booking->status = DharmasalaBooking::CANCELLED;

        if ( ! $booking->save() ){
            return $this->json(false,'Unable to can booking. Please try again.');
        }

        // track booking information.
        return $this->json(true,'Booking Cancelled.','reload');
    }

    public function checkIn(DharmasalaBooking $booking) {
        $booking->status = DharmasalaBooking::CHECKED_IN;
        $today = Carbon::today();
        $booking->check_in_time = $today->format('H:i A');

        $checkInCarbon = Carbon::createFromFormat('Y-m-d',$booking->check_in);

        if ( ! $checkInCarbon->isToday() ) {
            $booking->check_in = $today->format('Y-m-d');
        }

        if (! $booking->save() ) {
            return $this->json(false,'Unable to check in user.');
        }

        return $this->json(true,'Check In success.','reload');
    }

    public function checkOut(Request $request,DharmasalaBooking $booking) {
        $booking->status = DharmasalaBooking::CHECKED_OUT;
        $today = Carbon::today();
        $booking->check_out_time = $today->format('H:i A');

        if ( ! $booking->save() ) {
            return $this->json(false,'Unable to Check out user.');
        }

        // check if donation is provided.
        if ($request->post('donation') && $request->post('donation') > 0 ) {
            $type = 'Dharmasala - Cash';
            if ($request->post('esewa') ) {
                    $type = "Dharmasala - Esewa";
            }

            if ( $request->post('fonepay') ) {
                $type = "Dharmasala - FonePay";
            }

            if ( $request->post('bank_transfer') ) {
                $type = 'Dharmasala - Bank Transfer';
            }

            $donation = new Donation();

            $donation->fill([
                'member_id' => $booking->member_id,
                'amount'    => $request->post('donation'),
                'type'  => $type,
                'verified'  => true,
                'remarks'   => ['remarks' => $request->post('remark'),'refId' => $request->post('refId'),'amt' => $request->post('donation')]
            ]);

            $donation->save();
        }

        return $this->json(true,'Check Out Success','reload');
    }

    public function updateRoom(DharmasalaBooking $booking) {

    }

    public function createNewUserBooking(Request $request,Member $member=null) {
        $request->validate([
//            'check_in' => 'required',
            'id_card'   => 'required',
            'live_webcam_image' => 'required',
        ]);


        // First save main member detail.
        $booking = new DharmasalaBooking();

        $booking->fill([
            'room_id'   => $request->post('room_number') ?? 0,
            'member_id' =>$member?->getKey() ?? $request->post('member'),
            'room_number'   => 0,
            'full_name' => $member?->full_name() ?? $request->post('first_name') . ' ' . $request->post('last_name'),
            'email' => $member->email,
            'phone_number'  => $member->phone_number,
            'profile'   => $member?->profileImage()->first()?->getKey(),
            'id_card'   => $member?->memberIDMedia()->first()?->getKey(),
            'status'    => DharmasalaBooking::PROCESSING,
            'uuid'      => Str::uuid(),
        ]);

        // If Image is captured through camera
        if ($request->post('live_webcam_image') ) {

            $isUrl = str($request->post('live_webcam_image'))->contains('http');

            if ($isUrl) {
                $mediaImage = $request->post('live_webcam_image');
            } else {
                $mediaImage = $this->uploadMemberMedia($request,$request->post('live_webcam_image'),'path');
            }

             $booking->profile = (Image::urlToImage($mediaImage))?->getKey();
        }


        if ($request->file('id_card') ) {

            $idImageCard = (Image::uploadOnly($request->file('id_card')));

            if (  isset ($idImageCard[0]) ) {
                $booking->id_card = $idImageCard[0]->getKey();
            }

        } elseif (! $request->file('id_card') && $request->post('id_card_image') ) {

            $isUrl = str($request->post('id_card_image'))->contains('http');

            if ( ! $isUrl) {
                $idMediaImage = $request->post('id_card_image');
            } else {
                $idMediaImage = $this->uploadMemberMedia($request,$request->post('id_card_image'),'path');
            }

            $booking->id_card = (Image::urlToImage($idMediaImage))?->getKey();
        }

        if ($request->post('room_number') ) {
            $room = DharmasalaBuildingRoom::with(['building','floor'])->find($request->post('room-number'));

            if ( $room ) {

                $booking->room_number = $room->room_number;
                $booking->room_id = $room->getKey();
                $booking->building_id = $room->building_id;
                $booking->floor_id = $room->floor_id;
                $booking->building_name = $room->building?->building_name;
                $booking->floor_name = $room->floor?->floor_name;
            }
        }

        $booking->save();
        

        if ($request->post('connectorFullName') && is_array($request->post('connectorFullName')) ) {

            $bulkInsert = [];
        
            foreach ($request->post('connectorFullName') as $key => $relationFullName) {

                $innerArray = [
                    'full_name' => $relationFullName,
                    'relation_with_parent'  => $request->post('relation')[$key],
                    'phone_number'   => $request->post('relationPhoneNumber')[$key],
                    'created_at' => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                    'id_parent' => $booking->getKey(),
                    'room_id'   => 0,
                    'room_number'   => 0,
                    'status'    => DharmasalaBooking::PROCESSING
                ];

                // now save image for this relation.
                $imageRelationURL = $request->post('relationImage')[$key];
                $checkImage = str($imageRelationURL)->contains('http');

                if (  ! $checkImage ) {
                    $imageRelationURL = $this->uploadMemberMedia($imageRelationURL);
                }

                $innerArray['profile'] = (Image::urlToImage($imageRelationURL))?->getKey();

                if ($innerArray['profile']) {
                    $innerArray['check_in'] = Carbon::now()->format('Y-m-d');
                    $innerArray['check_in_time'] = Carbon::now()->format("H:i:s");
                }

                $bulkInsert[] = $innerArray;
            }

            DharmasalaBooking::insert($bulkInsert);
            
        }

        return $this->json(true,'Booking Created. Please Confirm Your','redirect',['location' => route('admin.dharmasala.booking.confirmation',['booking' => $booking])]);

    }

    public function uploadMemberMedia(Request $request, $base64Path=null,$return=null) {
        if (! $base64Path ) {
            $request->validate([
                'image' => 'required'
            ]);
        }

        $imageData = $base64Path ?? $request->post('image');
        $base64Image = substr($imageData, strpos($imageData, ',') + 1);
        // Decode base64 image data
        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
        $filename = time().uniqid() . '.png';

        Storage::disk('local')->put('dharmasala-processing/' . $filename, $image);

        if ( ! $return ) {
            return $this->json(true,'Image Captured',null,['path' => asset('dharmasala-processing/'.$filename)]);
        } else {
            return asset('dharmasala-processing/'.$filename);
        }
    }

    public function update(Request $request , DharmasalaBooking $booking) {

        if ($request->post('room_number') ) {

            $room = DharmasalaBuildingRoom::with(['building','floor'])->findOrFail($request->post('room_number'));
            $booking->room_number = $room->room_number;
            $booking->room_id = $room->getKey();
            $booking->building_id = $room->building?->getKey();
            $booking->building_name = $room->building?->building_name;
            $booking->floor_id = $room->floor?->getKey();
            $booking->floor_name = $room->floor?->floor_name;
        }
        
        if ( $request->post('id_card_media') )  {

        }

        if ($request->post('live_media') ) {

        }

        if ($request->post('check_in')) {
            $carbonTime = Carbon::createFromFormat();
        }

        if ( $request->post('check_out')) {

        }

        if ($request->post('full_name') ) {

        }

        if ($request->post('phone_number') ) {
            
        }

        if ($request->post('removeRelation') ) {

        }

        if ( $request->post('addRelation') ) {

        }

        if ( ! $booking->save() ) {
            return $this->json(false,'Error: unable to update record.');
        }

        $jsCallback = $request->callback ?? null;
        $params = $request->params ?? [];

        return $his->json(true,'Information Updated.',$jsCallback,$params);
    }
}

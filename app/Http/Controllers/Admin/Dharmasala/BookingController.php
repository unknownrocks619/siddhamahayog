<?php

namespace App\Http\Controllers\Admin\Dharmasala;
use App\Classes\Helpers\Image;
use App\Http\Controllers\Admin\Datatables\ProgramDataTablesController;
use App\Http\Controllers\Controller;
use App\Models\Dharmasala\DharmasalaBooking;
use App\Models\Dharmasala\DharmasalaBuilding;
use App\Models\Dharmasala\DharmasalaBuildingFloor;
use App\Models\Dharmasala\DharmasalaBuildingRoom;
use App\Models\Donation;
use App\Models\Member;
use Illuminate\Database\Eloquent\Builder;
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
            return (new ProgramDataTablesController())->dharmasalaBookingList($request,$filter,$searchTerm);
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

    /**
     * Update Booking update status.
     * @param Request $request
     * @param DharmasalaBooking $booking
     * @param $type
     * @return \Illuminate\Http\Response
     */
    public function bookingConfirmation(Request $request, DharmasalaBooking $booking, $type = 'confirmation') {

        $message = "Booking Successfully Confirmed.";
        $jsCallback = request()->post('callback');
        $params = request()->post('params') ?? [];

        if ($type == 'confirmation') {

            if (! $booking->room_number ) {
                return $this->json(false,"Please assign room to user.");
            }

            if (! $booking->profile) {
                return $this->json(false,'Please click live image of the user.');
            }

            if (! $booking->id_card) {
                return $this->json(false, 'Please provide valid Id Card.');
            }

            if (!$booking->uuid) {
                $booking->uuid = Str::uuid();
            }

            $booking->status = DharmasalaBooking::CHECKED_IN;
            $today = Carbon::now();

            if (! $booking->check_in) {
                $booking->check_in = $today->format('Y-m-d');
                $booking->check_in_time = $today->format('H:i:s');
            }

            if ($request->post('update-children') ) {

                $existsEmpty =  $booking->getChildBookings()->where(function(Builder $query){
                    $query->whereNull('check_in')
                            ->orWhereNull('profile');
                })->exists();

                if ( $existsEmpty ) {
                    return $this->json(false,'One of family & Friends is missing information.',['error' => 'Please check in all details. Unable to confirm booking.']);
                }

                foreach ($booking->getChildBookings()->get() as $children) {

                    if (! $children->check_in ) {

                        $children->check_in = $today->format('Y-m-d');
                        $children->check_in_time = $today->format('H:i:s');
                    }

                    if ( ! $children->room_number) {

                        $children->room_id = $booking->room_id;
                        $children->room_number = $booking->room_number;
                        $children->floor_id = $booking->floor_id;
                        $children->floor_name = $booking->floor_name;
                        $children->building_id = $booking->building_id;
                        $children->building_name = $booking->building_name;
                    }
                    $children->status = DharmasalaBooking::CHECKED_IN;
                    $children->save();

                }
            }

        }

        if ($type == 'check-out') {

            $booking->status = DharmasalaBooking::CHECKED_OUT;
            $today = Carbon::today();
            $booking->check_out_time = $today->format('H:i A');

            // check if donation is provided.
            if ($request->post('donation') && $request->post('donation') > 0) {
                $type = 'Dharmasala - Cash';

                if ($request->post('esewa')) {
                    $type = "Dharmasala - Esewa";
                }

                if ($request->post('fonepay')) {
                    $type = "Dharmasala - FonePay";
                }

                if ($request->post('bank_transfer')) {
                    $type = 'Dharmasala - Bank Transfer';
                }

                $donation = new Donation();

                $donation->fill([
                    'member_id' => $booking->member_id,
                    'amount' => $request->post('donation'),
                    'type' => $type,
                    'verified' => true,
                    'remarks' => ['remarks' => $request->post('remark'), 'refId' => $request->post('refId'), 'amt' => $request->post('donation')]
                ]);

                $donation->save();
            }

            if ($request->post('group') ) {

                $booking->getChildBookings()
                                    ->where('status',DharmasalaBooking::CHECKED_IN)
                                    ->update(['status' => DharmasalaBooking::CHECKED_OUT]);

            }

            $message = $request->post('group') ? 'Group' : ' ';
            $message .= " Checkout success.";

            if (  request()->action ) {
                $jsCallback = 'ajaxDataTableReload';
                $params['sourceID'] = 'bookingTable';
            }

            if (! $jsCallback ) {
                $jsCallback = 'reload';
            }
        }

        if ($type == 'check-in') {

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

            if (  request()->action ) {
                $jsCallback = 'ajaxDataTableReload';
                $params['sourceID'] = 'bookingTable';
            }

            if ( ! $jsCallback )  {
                $jsCallback = 'reload';
            }

        }

        if ($type == 'cancel') {

            $booking->status = DharmasalaBooking::CANCELLED;

            if ($request->post('cancel-all') ) {
                $booking->getChildBookings()->update(['status' => DharmasalaBooking::CANCELLED]);
            }
            if (  request()->action ) {
                $jsCallback = 'ajaxDataTableReload';
                $params['sourceID'] = 'bookingTable';
            }

            if ( ! $jsCallback){
                $jsCallback = 'reload';
            }
        }

        if ( $booking->isDirty() ) {
            $booking->save();
        }

        return $this->json(true,$message,$jsCallback,$params);
    }
    public function createNewUserBooking(Request $request,Member $member=null) {
        $request->validate([
//            'check_in' => 'required',
//            'id_card'   => 'required',
            'live_webcam_image' => 'required',
        ]);

        if (! $member->memberIDMedia ) {
            if (! $request->post('id_card_image') ) {

                $request->validate(['id_card' => 'required']);
            }

            if (! $request->file('id_card') ) {

                $request->validate(['id_card_image' => 'required']);
            }
        }

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

        $booking->id_card = $member->memberIDMedia?->getKey();

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

        if ( $request->post('captured_id_card') )  {

            $isUrl = str($request->post('captured_id_card'))->contains('http');

            if ($isUrl) {
                $mediaImage = $request->post('captured_id_card');
            } else {
                $mediaImage = $this->uploadMemberMedia($request,$request->post('captured_id_card'),'path');
            }

            $booking->id_card = (Image::urlToImage($mediaImage))?->getKey();
        }

        if ($request->post('live_media') ) {
            $idImageCard = (Image::uploadOnly($request->file('uploadIDCard')));

            if (  isset ($idImageCard[0]) ) {
                $booking->profile = $idImageCard[0]->getKey();
            }
        }

        if ($request->post('check_in')) {
            $carbonTime = Carbon::createFromFormat('Y-m-d\TH:i',$request->post('check_in'));
            $booking->check_in = $carbonTime->format('Y-m-d');
            $booking->check_in_time = $carbonTime->format('H:i:s');
        }

        if ( $request->post('check_out')) {
            $carbonTime = Carbon::createFromFormat('Y-m-d\TH:i',$request->post('check_out'));
            $booking->check_out = $carbonTime->format('Y-m-d');
            $booking->check_out_time = $carbonTime->format('H:i:s');

        }

        if ($request->post('full_name') ) {
            $booking->full_name = $request->post('full_name');
        }

        if ($request->post('phone_number') ) {
            $booking->phone_number = $request->post('phone_number');
        }

        if ($request->post('removeRelation') ) {
            $booking->getChildBookings()->where('id',$request->post('removeRelation'))->delete();
        }

        if ($request->file('uploadIDCard') ) {
            $idImageCard = (Image::uploadOnly($request->file('uploadIDCard')));

            if (  isset ($idImageCard[0]) ) {
                $booking->id_card = $idImageCard[0]->getKey();
            }
        }

        if ( ! $booking->save() ) {
            return $this->json(false,'Error: unable to update record.');
        }

        $jsCallback = $request->callback ?? null;
        $params = $request->params ?? [];

        if ($request->post('primaryInfo')) {
            $booking = DharmasalaBooking::find($request->post('primaryInfo'));
        }

        $params =[
            'targetDIV' => $request->post('targetDIV') ?? '#confirmationDetail',
            'view'  => view('admin.dharmasala.booking.partials.confirmation-detail',['booking' => $booking])->render()
        ];

        return $this->json(true,'Information Updated.',$jsCallback,$params);
    }

    public function addFamilyToBooking(Request $request, DharmasalaBooking $booking) {

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

    public function bookingQuickEditAjax(Request $request, DharmasalaBooking $booking) {

        if ($request->ajax() ) {
            return $this->json(true,'','',['view' => view('admin.dharmasala.booking.partials.confirmation',['booking' => $booking])->render()]);
        }

        abort(404);
    }

    public function quickBookingCheckIn(Request $request) {

        $profileImage=false;
        $profileID = false;

        if ($request->post() && $request->ajax() ) {
            
            if (! $request->post('bookingID') ) {
                return $this->json(false,'Please Scan your booking ID.');
            }

            // check if user needs to captuer image.

            $booking = DharmasalaBooking::select(['room_number','building_name','floor_name','profile','id_card','status'])->where('uuid',$request->post('bookingID'))->first();

            if ( ! $booking) {   
                return $this->json(false,'Invalid Booking ID',['class' => 'bg-danger text-white','text' => 'Invalid Booking ID','records' => []]);
            }

            if (!  in_array($booking->status, [DharmasalaBooking::RESERVED,DharmasalaBooking::BOOKING,DharmasalaBooking::CHECKED_IN]) ) {
                return $this->json(false,'Booking Already Expired.');
            }

            if (in_array($booking->status,[DharmasalaBooking::RESERVED,DharmasalaBooking::BOOKING])) {
                $today = Carbon::today();
                $booking->status = DharmasalaBooking::CHECKED_IN;
                $booking->check_in = $today->format('Y-m-d');
                $booking->check_in_time = $today->format('H:i:s');
                $booking->save();
            }
            


            return $this->json(true,'ID Match',null,
                            [
                                'class' => 'bg-success text-white',
                                'text' => 'Your Room Information.',
                                'records' => [
                                        'room_number' => $booking->room_number,
                                        'building_name' => $booking->building_name,
                                        'floor_name' => $booking->floor_name]
                            ]);
            
        }
        return view('admin.dharmasala.booking.quick-booking-check-in');
    }
}

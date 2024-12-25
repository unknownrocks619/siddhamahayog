<?php

namespace App\Http\Controllers\API\V1\Member;

use App\Classes\Helpers\Image;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Jobs\EmailVerfication;
use App\Models\Member;
use App\Models\MemberUnderLink;
use App\Models\MemberVerification;
use App\Models\Program;
use App\Models\Role;
use App\Models\UserTrainingCourse;
use DB;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    /**
     * @param LoginRequest $request
     * @return Application|ResponseFactory|Response
     * @throws ValidationException
     */
    public function authenticate(LoginRequest $request): Application|ResponseFactory|Response
    {
        $request->authenticate();

        if (! $request->post('device')) {
            return response(['message' => 'Failed to retreive device information', 'errors' => ['device' => 'Device information missing']], 401);
        }
        $user = user();

        $user['profile'] = user()->profileImage ?  Image::getImageAsSize(user()->profileImage, 'm') : ((isset(user()->profileUrl->avatar) && user()->profileUrl?->avatar) ? user()->profileUrl->avatar : null);
        $user['country'] = user()->countries?->code ?? 'NP';

        return response([
            'errors' => [],
            'message' => "Login Successful !",
            'data' => [
                'Bearer' => user()->createToken($user->getKey() . '_p_token')->plainTextToken,
                'user' => $user,
                'sadhana_level' => [
                    'primary_level' => 0,
                    'secondary_level' => 0,
                ],
                'profile' => user()->profileImage ?  Image::getImageAsSize(user()->profileImage, 'm') : ((isset(user()->profileUrl->avatar) && user()->profileUrl?->avatar) ? user()->profileUrl->avatar : null)
            ]
        ]);
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function userDetail(Request $request): Application|ResponseFactory|Response
    {
        if (! $request->user()) {
            return response([
                'error' => ['Authetication failed.'],
                'message'   => 'Authetication failed',
                'data' => []
            ], 422);
        }
        /** @var Member */
        $user = $request->user();

        return response([
            'errors' => [],
            'message' => "Login Successful !",
            'data' => [
                'Bearer' => str($request->header('Authorization'))->replace('Bearer ', '')->value(),
                'user' => $user,
                'sadhana_level' => [
                    'primary_level' => 0,
                    'secondary_level' => 0,
                ],
                'profile' => user()->profileImage ?  Image::getImageAsSize(user()->profileImage, 'm') : ((isset(user()->profileUrl->avatar) && user()->profileUrl?->avatar) ? user()->profileUrl->avatar : null)
            ]
        ]);
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function register(Request $request): Application|ResponseFactory|Response
    {
        $request->validate([
            'password' => 'required',
            'confirm_password'  => 'required',
            'type'  => 'required|in:phone,email',
            'phoneNumber'   => 'required_if:type,phone',
            'email'         => 'required_if:type,email|email',
            'source'        => 'required'
        ]);

        $memberRegistration  = new Member();
        $memberRegistration->fill([
            'first_name'    => ' ',
            'last_name'     => ' ',
            'full_name'     => ' ',
            'source'    =>  $request->post('source'),
            'external_source_id'    => $request->post('device'),
            'password'      => Hash::make($request->post('password')),
            'role_id'       => 7,
            'country'       => $request->post('country')
        ]);

        if ($request->post('type') == 'phone') {
            $memberRegistration->setAttribute('email', 'random_email_' . uniqid());
            $memberRegistration->allow_username_login = Member::LOGIN_TYPE_PASSWORDLESS;
        } else {

            // check if email already exists.
            if (Member::where('email', $request->post('email'))->exists()) {
                return response(['error' => ['email' => 'Invalid Email.'], 'message' => "Invalid email. Please choose different email.", 'data' => []], 400);
            }

            $memberRegistration->setAttribute('email', $request->post('email'));
            $memberRegistration->allow_username_login = Member::LOGIN_TYPE_EMAIL;
            $memberRegistration->save();
        }

        $memberRegistration['profile'] = $memberRegistration->profileImage ?  Image::getImageAsSize(user()->profileImage, 'm') : ((isset(user()->profileUrl->avatar) && $memberRegistration->profileUrl?->avatar) ? $memberRegistration->profileUrl->avatar : null);
        return response([
            'errors' => [],
            'message' => "Login Successful !",
            'data' => [
                'Bearer' => $memberRegistration->createToken($memberRegistration->getKey() . '_p_token')->plainTextToken,
                'user' => $memberRegistration,
                'sadhana_level' => [
                    'primary_level' => 0,
                    'secondary_level' => 0,
                ],
                'profile' => $memberRegistration->profileImage ?  Image::getImageAsSize($memberRegistration->profileImage, 'm') : ((isset($memberRegistration->profileUrl->avatar) && $memberRegistration->profileUrl?->avatar) ? $memberRegistration->profileUrl->avatar : null)
            ]
        ]);
    }

    /**
     * Generate Registration token
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|ResponseFactory|Response
     */
    public function registrationToken(Request $request): \Illuminate\Contracts\Foundation\Application|Response
    {
        $request->validate([
            'country' => 'required',
            'phone' => 'required_if:country,153',
            'email' => 'required_unless:country,153|email:rfc,dns'
        ]);

        // check if user already exists.
        if ($request->post('country') == 153 && strlen($request->post('phone')) != 10) {
            return $this->generateValidationError('phone', 'Invalid Phone number.');
        }

        if ($request->post('email') && $request->post('country') != '153' && Member::where('email', $request->post('email'))->exists()) {
            return $this->generateValidationError('email', 'Invalid email address.');
        }


        $validationTokenArray =  [
            'country' => $request->post('country'),
            'phone' => $request->post('phone'),
            'email' => $request->post('email'),
            'created_at' => now()
        ];

        if (auth()->guard('web')->check()) {
            $validationTokenArray['under'] = auth()->guard('web')->id();
        }

        if ($request->post('teacher')) {
            $validationTokenArray['under'] = $request->post('teacher');
        }

        if ($request->header('X-MEMBERSHIP-TOKEN')) {

            try {
                $userMemberID = decrypt($request->header('X-MEMBERSHIP-TOKEN'));
                $validationTokenArray['under'] = $userMemberID;
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

        // get site settings.
        $validationToken = [
            'validationToken' => $validationTokenArray,
            'validation' => 'process',
            'verificationType' => ''
        ];

        if (! site_settings('account_verification')) {
            return $this->json(true, 'Information validation success.', '', $validationToken);
        }
        $validationToken['validation'] = 'verification';

        if ($request->post('country') != '153') {

            $validationTokenArray['verificationType'] = 'email';
            $validationTokenArray['verificationValue'] = $request->post('email');

            $validationToken['verificationType'] = 'email';
            $validationToken['verificationValue'] = $request->post('email');
            EmailVerfication::dispatchSync(null, $request->post('email'));
        } else {

            if ($request->post('email_option')) {

                $validationToken['verificationType'] = 'email';
                $validationToken['verificationValue'] = $request->post('email');
                $validationTokenArray['verificationType'] = 'email';
                $validationTokenArray['verificationValue'] = $request->post('email');

                EmailVerfication::dispatchSync(null, $request->post('email'));
            } else {

                // send sms..
                $validationToken['verificationType'] = 'phone';
                $validationToken['verificationValue'] = $request->post('phone');

                $validationTokenArray['verificationType'] = 'phone';
                $validationTokenArray['verificationValue'] = $request->post('phone');
            }
        }

        if ($request->get('source') == 'web') {
            $validationToken['view'] = view('generic.otp', ['type' => $validationToken['verificationType']])->render();
        }

        $validationToken['verificationURL'] = route('user.verify-otp');
        $validationToken['validationToken'] = encrypt(json_encode($validationTokenArray));

        return $this->json(true, 'Please verify your account.', '', $validationToken);
    }

    /**
     *  Register New User
     */
    public function registerAccount(Request $request, String $process)
    {
        if (! $request->header('X-REGISTRATION-TOKEN')) {
            return $this->json(false, 'Invalid Registration code', '', [], 419);
        }

        if ($process == 'personal') {

            $request->validate([
                'first_name' => 'required',
                'last_name'  => 'required',
                'password'   => 'required|confirmed',
                'address'    => '',
                'gender'    => 'required|in:male,female,other',
                'date_of_birth'  => 'required|date_format:Y-m-d'
            ]);
        }

        try {
            $registration = decrypt($request->header('X-REGISTRATION-TOKEN'));
            $registration = json_decode($registration, true);
        } catch (\Throwable $th) {
            return $this->json(false, 'Invalid Token');
        }

        /**
         * Check if any field was modified afte verification.
         */

        if (($registration['verificationType'] != $request->post('verificationType'))) {
            return $this->json(false, 'Invalid Token');
        }

        /** Prevent User from changing phone number */

        if ($registration['verificationType'] == 'phone' && $request->post('phone') != $registration['phone']) {

            return $this->json(false, 'Invalid Token');
        }

        if ($registration['verificationType'] == 'email' && $request->post('email') != $registration['email']) {
            return $this->json(false, 'Invalid Token');
        }


        // check if user already exists.
        $member = Member::where('email', $request->post('email'))
            ->orWhere('phone_number', 'LIKE', '%' . $request->post('phone') . '%')
            ->first();

        // if member exists and is already exists, show registration error.

        // if ($member) {
        //     return $this->json(false, 'Failed to register user. Please check your information again.');
        // }

        if (! $member) {
            $member = new Member();
            $member->fill([
                'first_name' => $request->post('first_name'),
                'last_name' => $request->post('last_name'),
                'email' => $registration['email'],
                'password'  => Hash::make($request->post('password')),
                'phone_number'  => $request->post('phone'),
                'city'  => $request->post('city'),
                'address'    => ['street_address' => $request->post('street_address')],
                'date_of_birth'     => $request->post('date_of_birth'),
                'source'    => $request->post('source'),
                'gender'    => $request->post('gender'),
                'role_id'   => $request->post('role') ?? Role::MEMBER,

            ]);
        }

        if ($request->post('validation') == 'validated') {

            if ($registration['verificationType'] == 'phone') {
                $member->is_phone_verified = true;
            }

            if ($registration['verificationType'] == 'email') {
                $member->is_email_verified = true;
            }
        }

        if (! $member->email) {
            $member->email = 'random_email_' . \Illuminate\Support\Str::random(8) . '@siddhamahayog.org';
        }

        $member->save();

        if (isset($registration['under']) && $member?->getKey()) {

            $teacher = Member::find($registration['under']);
            /**
             * Since we are doing registration for program conducted by teacher.
             * Make sure we have program available.
             */

            $currentTrainingSession = null;
            if (isset($registration['training']) || $request->post('training')) {
                $currentTrainingSession = UserTrainingCourse::where('id', $registration['training'] ?? $request->post('training'))->first();
            }

            /**
             * Not training session was provided get last active session to enroll.
             */
            if (! $currentTrainingSession) {
                $currentTrainingSession = UserTrainingCourse::where('id_user', $registration['under'])
                    ->where('course_status', 1)
                    ->latest()
                    ->first();

                if (! $currentTrainingSession) {
                    $currentTrainingSession = new UserTrainingCourse();
                    $currentTrainingSession->fill([
                        'id_user' => $registration['under'],
                        'event_id'  => Program::where('program_type', 'sadhana')->where('status', 'active')->latest()->first()?->getKey(),
                        'course_group_name' => 'Sadhana Session ' . (int) UserTrainingCourse::where('id_user', $registration['under'])->max('id') + 1,
                        'course_description'    => 'Sadhana Session started',
                        'course_duration' => '-',
                        'course_status' => 1,
                        'training_location' => $teacher->address?->street_address . ' ' . $teacher->city
                    ]);
                    $currentTrainingSession->save();
                }
            }

            $memberUnderLink = MemberUnderLink::where('teacher_id', $registration['under'])
                ->where('student_id', $member->getKey())
                ->where('teacher_training_id', $currentTrainingSession->getKey())
                ->first();

            if (! $memberUnderLink) {
                $memberUnderLink = new MemberUnderLink();
            }
            $memberUnderLink->fill([
                'teacher_id' => $registration['under'],
                'student_id'    => $member->getKey(),
                'teacher_training_id' => $currentTrainingSession->getKey()
            ]);

            $memberUnderLink->save();
        }

        if (! $member?->getKey()) {
            return $this->json(false, 'Failed to register member.');
        }
        $message = 'Registration was successfull. Please wait while we refresh your page.';

        return $this->json(true, $message, 'reload', ['validation' => 'completed']);
    }

    /**
     *  Resend OTP
     */

    public function resendOTP(Request $request)
    {
        $request->validate([
            'verificationType'  => 'required|in:email,phone',
            'verificationValue' => 'required',
            'source'    => 'required',
        ]);

        // okay based on the value, check previous registration code.
        $oldRegistrationCode = MemberVerification::where('validation_name', $request->post('verificationValue'))
            ->where('type', $request->post('verificationType'))
            ->first();


        if (! $oldRegistrationCode) {
            return $this->json(false, 'Invalid request', null, [], 403);
        }

        if ($oldRegistrationCode->created_at->addMinutes(2)->greaterThan(now())) {
            return $this->json(false, 'Please wait 2 minute before you can send another otp.', null, [], 403);
        }

        $oldRegistrationCode->delete();

        if ($oldRegistrationCode->type == 'email') {
            EmailVerfication::dispatchSync(null, $oldRegistrationCode->validation_name);
        } else {
            // end Mobile OTP
        }
        return $this->json(true, 'New Code was sent.');
    }

    /**
     * Verify OTP
     */
    public function verifyOTP(Request $request)
    {
        // $request->validate([
        //     'otp'   => 'required',
        //     'verificationType' => 'required',
        //     'verificationValue' => 'required'
        // ]);

        // $registrationCode = MemberVerification::where('validation_name', $request->post('verificationValue'))
        //     ->where('type', $request->post('verificationType'))
        //     ->first();

        // if (! $registrationCode) {
        //     return $this->json(false, 'Invalid OTP Code.');
        // }

        // $otpMatch = false;
        // if ($registrationCode->data_type == 'hashed') {

        //     if (Hash::check($request->post('otp'), $registrationCode->otp)) {
        //         $otpMatch = true;
        //     }
        // } else {
        //     if ($request->post('otp') === $registrationCode->otp) {
        //         $otpMatch = true;
        //     }
        // }

        // if (! $otpMatch) {
        //     return $this->json(false, 'Invalid OTP Code.');
        // }

        $returnData = [
            'verificationURL' => route('user.registration-process', ['process' => 'personal']),
            'validation'    => 'validated',
            'verificationType' => $request->post('verificationType'),
        ];


        // # now return 
        if (strtolower($request->post('source')) == 'web') {
            $returnData['view'] = view('generic.registration-personal-info')->render();
        }

        return $this->json(true, 'OTP Verified,', null, $returnData);
    }
}

<?php

namespace App\Classes\Import;

use App\Classes\Helpers\NepaliDate;
use App\Classes\Helpers\Str;
use App\Models\Country;
use App\Models\Member;
use App\Models\MemberInfo;
use App\Models\Program;
use App\Models\ProgramStudent;
use App\Models\User;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Carbon\Carbon;
use Error;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class EventRegistration
{

    protected array $formattedHeadersArray = [];
    protected array $rawHeadersArray = [];
    protected $headerRowNumber;

    protected string $filepath;
    protected $user = null;

    public function __construct(string $filename, $user = null)
    {
        $this->filepath = $filename;
        $this->headerRowNumber = 1;
        $this->user  = $user;
    }

    public function convertRole()
    {

        // otherwise manually convert user role.
        return 7;
    }

    public function processFile()
    {
        if (!Storage::disk('local')->exists('excel/' . $this->filepath)) {
            throw new \Exception("Fiile Not Found", 1);
        }
        $filepath = Storage::disk('local')->path('excel/' . $this->filepath);

        $reader = ReaderEntityFactory::createReaderFromFile($this->filepath);
        $reader->open($filepath);

        $importedContact = [];
        $skippedContact = [];
        $existingMember = [];
        $country = Country::get();

        foreach ($reader->getSheetIterator() as $sheet) {
            $spoutHeader = $this->getFormattedHeader($sheet);

            foreach ($sheet->getRowIterator() as $key => $dataRow) {
                if ($key <= $this->headerRowNumber) {
                    continue;
                }

                $recordRow = $this->rowWithFormattedHeaders($dataRow->toArray());

                // Member Exist using email.
                $member = Member::where('email', $recordRow['email'])->first();

                if ($member) {
                    $existingMember[] = $member;
                    continue;
                }

                $member = Member::where('phone_number', 'LIKE', '%' . $recordRow['phone'])->first();

                if ($member) {
                    $existingMember[] = $member;
                    continue;
                }
                $userCountry = $country->where('name', 'like', 'Nepal')->first();
                $useremail =  trim($recordRow['email']);
                $phoneNumber = preg_replace('/^\+977-?/', '', str_replace('-', '', trim($recordRow['phone'])));

                $skip = false;
                $skipEmail = false;
                $skipPhone = false;
                if (Validator::make(['email' => $useremail], ['email' => 'required|email'])->fails()) {
                    $skipEmail = true;
                    $useremail = uniqid('random_email_') . '@siddhamahayog.org';
                }

                if (strlen($phoneNumber) !=  10) {
                    $skipPhone = true;
                    $phoneNumber = '';
                }

                if ($skipPhone && $skipEmail) {

                    $skippedContact[] = $recordRow;
                    continue;
                }
                $password  = '';
                if (! $skipEmail) {
                    $explodeEmail = explode('@', $useremail);
                    $password = $explodeEmail[0];
                }

                $seperateName = explode(" ", $recordRow['name']);
                $firstname = $seperateName[0];
                unset($seperateName[0]);
                $last_name = implode(' ', $seperateName);

                if (is_string($recordRow['date_from'])) {
                    $explodeCreateAt = explode('/', $recordRow['date_from']);
                    if (count($explodeCreateAt) != 3) {
                        $createAt = now()->format('Y-m-d H:i:s');
                    } else {
                        $createAt = $explodeCreateAt[0] . '-' . $explodeCreateAt[1] . $explodeCreateAt[2] . '00:00:00';
                    }
                } else {
                    $createAt = $recordRow['date_from']->format('Y-m-d H:i:s');
                }
                $member = [
                    'full_name' => $recordRow['name'],
                    'first_name' => $firstname,
                    'last_name' => $last_name,
                    'email'     => $useremail,
                    'phone_number'  => $phoneNumber,
                    'country'   => $userCountry->getKey(),
                    'role_id' => $this->convertRole(),
                    'password'  => (! $skipPhone) ? Hash::make($phoneNumber) : (! $skipEmail ? Hash::make($password) : Hash::make(\Illuminate\Support\Str::random(12))),
                    'username'  => ($skipEmail) ? $phoneNumber : \Illuminate\Support\Str::random(8),
                    'allow_username_login'  => true,
                    'invite_token'  => strtoupper(\Illuminate\Support\Str::random(12)),
                    'current_step'  => 'complete',
                    'status'    => 'active',
                    'terms'     => true,
                    'created_at'    => $createAt,
                    'updated_at'    => Carbon::now(),
                    'source'        => 'chatursmas_program_import',
                    'member_uuid' => Str::uuid()
                ];

                try {
                    // convert date of birth to english.
                    if (! is_string($recordRow['dob'])) {
                        $dateOfBirth = (new NepaliDate())->nep_to_eng($recordRow['dob']->format('Y'), $recordRow['dob']->format('m'), $recordRow['dob']->format('d'));
                        if (isset($dateOfBirth['year']) && isset($dateOfBirth['month']) && isset($dateOfBirth['day'])) {
                            $member['date_of_birth'] = $dateOfBirth['year'] . '-' . $dateOfBirth['month'] . '-' . $dateOfBirth['date'];
                        }
                    } else {
                        $explodeDate = explode('/', $recordRow['dob']);

                        if (count($explodeDate) == 3) {
                            $dateOfBirth = (new NepaliDate())->nep_to_eng($explodeDate[0], $explodeDate[1], $explodeDate[2]);
                            if (isset($dateOfBirth['year']) && isset($dateOfBirth['month']) && isset($dateOfBirth['day'])) {
                                $member['date_of_birth'] = $dateOfBirth['year'] . '-' . $dateOfBirth['month'] . '-' . $dateOfBirth['date'];
                            }
                        }
                    }
                } catch (\Exception $e) {
                }



                try {
                    DB::transaction(function () use ($member, $recordRow, &$importedContact) {
                        $memberModel = new Member();
                        $memberModel->fill($member);
                        $memberModel->save();

                        $memberInfo = new MemberInfo();
                        $memberInfo->fill([
                            'education' => [
                                'education' => $recordRow['education'] ?? '',
                                'education_major' => '',
                                'profession' => $recordRow['occupation'] ?? ''
                            ],
                            'personal' => [
                                'place_of_birth' => '',
                                'date_of_birth' => '',
                                'street_address' => '',
                                'gender' => '',
                                'state' => ''
                            ],
                            'history' => [
                                'medicine_history'  => 'no',
                                'mental_health_history' => 'no',
                                'regular_medicine_history_detail' => '',
                                'mental_health_detail_problem' => '',
                                'practiced_info' => '',
                                'support_in_need' => '',
                                'terms_and_condition' => '',
                                'sadhak'    => ''
                            ],
                            'member_id' => $memberModel->getKey()
                        ]);

                        $memberInfo->save();
                        $importedContact[] = $memberModel->getKey();
                    });
                } catch (\Exception $e) {
                }
                // 
            }
        }

        foreach ($importedContact as $assignUserToProgram) {
            if (ProgramStudent::where('program_id', 9)->where('student_id', $assignUserToProgram)->first()) {
                continue;
            }

            $programStudent = new ProgramStudent;
            $programStudent->fill([
                'program_id' => 9,
                'program_section_id' => 10,
                'student_id'    => $assignUserToProgram,
                'batch_id'  => 7,
                'active'    => 1,
            ]);

            $programStudent->save();
        }

        foreach ($existingMember as $member) {
            if (ProgramStudent::where('program_id', 9)->where('student_id', $member->getKey())->first()) {
                continue;
            }

            $programStudent = new ProgramStudent;
            $programStudent->fill([
                'program_id' => 9,
                'program_section_id' => 10,
                'student_id'    => $member->getKey(),
                'batch_id'  => 7,
                'active'    => 1,
            ]);

            $programStudent->save();
        }
    }

    public function getFormattedHeader($sheet): array
    {

        if (empty($this->formattedHeadersArray)) {
            $this->formattedHeadersArray = $this->getRawHeader($sheet);

            $headerValue = [];

            foreach ($this->formattedHeadersArray as $key => $value) {

                if (is_a($value, 'DateTime')) {
                    $this->formattedHeadersArray[$key] = $value->format('Y-m-d');
                } else {
                    $value = strtolower(str_replace('.', '', str_replace(' ', '_', trim($value))));
                    $value = strtolower(str_replace('.', '', str_replace('-', '_', trim($value))));
                    $value = strtolower(str_replace('.', '', str_replace('(', '_', trim($value))));
                    $value = strtolower(str_replace('.', '', str_replace(')', '', trim($value))));

                    $finalValue = strtolower(trim($value));

                    $this->formattedHeadersArray[$key] = $finalValue;
                    $headerValue[] = $finalValue;
                }
            }
        }
        return $this->formattedHeadersArray;
    }

    public function getRawHeader($sheet): array
    {
        if (empty($this->rawHeadersArray)) {
            foreach ($sheet->getRowIterator() as $key => $row) {

                if ($key == $this->headerRowNumber) {
                    $this->rawHeadersArray = $row->toArray();
                    break;
                }
            }
        }
        return $this->rawHeadersArray;
    }

    public function rowWithFormattedHeaders(array $rowArray): array
    {
        return $this->returnRowWithHeadersAsKey($this->formattedHeadersArray, $rowArray);
    }

    public function returnRowWithHeadersAsKey($headers, $rowArray): array
    {
        $headerColCount = count($headers);
        $rowColCount = count($rowArray);
        $colCountDiff = $headerColCount - $rowColCount;
        if ($colCountDiff > 0) {
            $rowArray = array_pad($rowArray, $headerColCount, '');
        }
        try {
            return array_combine($headers, $rowArray);
        } catch (Error $e) {

            if (count($rowArray) > count($headers)) {
                array_splice($rowArray, count($headers));
                return array_combine($headers, $rowArray);
            }
        }
    }
}

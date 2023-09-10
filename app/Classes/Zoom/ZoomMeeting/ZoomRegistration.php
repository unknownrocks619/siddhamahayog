<?php

namespace App\Classes\Zoom\ZoomMeeting;
use App\Classes\Zoom\ZoomConfiguration;
use App\Classes\Zoom\ZoomController;

class ZoomRegistration extends ZoomController
{
    private ?ZoomConfiguration $zoom_configuration=null;
    private ?int $meetingID=null;
    private array $registrationSettings = [];

    public function __construct() {
        $this->zoom_configuration = new ZoomConfiguration();
        $this->zoom_configuration->generateToken();
    }

    public function register_participants() {
        $configs = [
            'headers' => [
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer' . $this->zoom_configuration->token('access_token')
                ],
            'json' => $this->registrationSettings
        ];
        return $this->zoom_configuration->setURI($this->participantsBaseURI())
                    ->zoomClientRequest($configs,'POST');
    }

    public function meeting() {
        $configs = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '. $this->zoom_configuration->token('access_token')
            ]
        ];
        return $this->zoom_configuration->setURI($this->baseURI())->zoomClientRequest($configs,'GET');
    }

    public function setMeeting(int $meetingID) {
        $this->meetingID = $meetingID;
        return $this;
    }

    public function getMeeting() {
        return $this->meetingID;
    }

    public function configuration() {

    }

    public function baseURI(): string {
        $base_url = $this->meeting_base_uri.'meetings/';
        $base_url .= $this->getMeeting();
        return $base_url;
    }

    public function participantsBaseURI(): string {
        $base_url = $this->meeting_base_uri . 'meetings/';
        $base_url .= $this->getMeeting().'/registrants';
        return $base_url;
    }

    public function setRegistrationConfigs(array $settings) {
        $this->registrationSettings = array_merge_recursive($this->registrationSettings, $settings);
        return $this;
    }

}

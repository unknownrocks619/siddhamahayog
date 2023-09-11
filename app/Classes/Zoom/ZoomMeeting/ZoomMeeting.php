<?php

namespace App\Classes\Zoom\ZoomMeeting;

use App\Classes\Zoom\ZoomConfiguration;
use App\Classes\Zoom\ZoomController;

class ZoomMeeting extends ZoomController
{
    protected ?ZoomConfiguration $zoom_configuration;
    protected string $meeting_name='';
    protected string $account_name='';
    public function __construct($meeting_name = null) {
        $this->zoom_configuration = new ZoomConfiguration();

        if ( $meeting_name ) {
            $this->setname($meeting_name);
        }
    }

    public function create(){

        if (! $this->zoom_configuration->token() ){
            $this->zoom_configuration->generateToken();
        }

        $configs = [
            'headers'   => ['Authorization' => "Bearer ".$this->zoom_configuration->token('access_token'),
                            'Content-Type' => 'application/json'],
            'json'   => $this->configuration()
        ];

        $meeting_detail = $this->zoom_configuration->setURI($this->baseURI())
                                ->zoomClientRequest($configs,'POST');
        return $meeting_detail;
    }
    public function setname(string $name) {
        $this->meeting_name = $name;
        return $this;
    }

    public function set_account(string $account_name) {
        $this->account_name = $account_name;
        return $this;
    }
    public function getName(){
        return $this->meeting_name;
    }

    public function configuration(): array {
        return [
            "type" => 2,
            "topic" => $this->getName(),
            "start_time" => date("Y-m-dT15:30:00"),
            "timezone" => "Asia/Kathmandu",
            "duration" => 300,
            'pre_schedule'  => false,
            "settings" => [
                "approval_type" => 1,
                "allow_multiple_devices" => 0,
                "show_share_button" => 0,
                "registrants_confirmation_email" => false,
                "auto_recording" => "cloud",
                "mute_upon_entry" => true,
                "participant_video" => true,
                "private_meeting" => true,
                "registration_type" => 2,
                "watermark" => true,
                "authentication_name" => "Signed-in users in my account",
                "focus_mode" => true,
                'authentication_domains' => 'siddhamahayog.org'
            ],
            "language_interpretation" => [
                "show_share_button" => 0,
                "allow_multiple_devices" => 0,
            ]
        ];
    }

    public function baseURI() {
        $base_url = $this->meeting_base_uri.'users/';
        $base_url .= $this->account_name;
        $base_url .='/meetings';

        return $base_url;
    }
}

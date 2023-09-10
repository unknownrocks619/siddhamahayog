<?php

namespace App\Classes\Zoom;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ZoomConfiguration
{
    private array $token=[];
    private string $client_secret='';
    private string $client_id='';
    private string $account_id='';

    protected string $baseURI='';
    protected array $config = [];

    public function  __construct()
    {
        $this->set_configuration();
    }

    public function zoomClientRequest($configs=[],$verb='GET') {
        $client  = new Client();
        try {
            $response = $client->request($verb, $this->baseURI,$configs);
        }catch ( \Exception $e) {
            dd($e->getMessage());
            Log::log('ERROR','ZOOM Token fetch Error. '. $e->getMessage());
            abort(500);
        }
        return json_decode($response->getBody(),true);
    }
    protected function set_configuration() {
        $this->client_secret = config('zoom')['client_secret'];
        $this->client_id    = config('zoom')['client_public'];
        $this->account_id = config('zoom')['account_id'];
    }
    public function generateToken() {

        $params = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization'  =>  'Basic ' . base64_encode("$this->client_id:$this->client_secret")
            ],
        ];
        $query = [
            'grant_type' =>'account_credentials',
            'account_id'    => $this->accountID()
        ];
        $this->baseURI = 'https://zoom.us/oauth/token?' . http_build_query($query);
        $this->token = $this->zoomClientRequest($params,"POST") ?? [];
        return $this;
    }

    protected function check_session_expire() {
        return false;
    }

    public function setURI(string $uri) {
        $this->baseURI = $uri;
        return $this;
    }
    public function clientSecret(){
        return $this->client_secret;
    }

    public function clientID() {
        return $this->client_id;
    }

    public function accountID() {
        return $this->account_id;
    }
    public function token(string $key = ''): array|string {
        if (! $key ) {
            return $this->token;
        }
        return $this->token[$key];
    }
}

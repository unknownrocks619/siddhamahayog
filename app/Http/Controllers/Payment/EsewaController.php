<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use function PHPUnit\Framework\throwException;

class EsewaController extends Controller
{
    //
    private $mode = null;
    private $merchant_key;
    private $payment_configs = [];
    private $verification_url;
    public function __construct()
    {
        $this->mode = env("ESEWA_MODE", 'test');
        $this->merchant_key = env("ESEWA_MERCHANT", "EPAYTEST");
        $this->set_verification_url("https://esewa.com.np/epay/transrec");
            if ($this->mode == "test") {
            $this->set_verification_url("https://uat.esewa.com.np/epay/transrec");
        }
    }


    public function set_verification_url($url) {
        $this->verification_url = $url;
    }

    public function verification_url () {
        return $this->verification_url;
    }
    /**
     * Change Mode of payment submission
     * @param string $mode ['test','live']
     * @return null; 
     */

    protected function live($mode = 'test')
    {
        if (!in_array($mode, ["test", "live"])) {
            throw new Exception("Invalid mode");
        }
        $this->mode = strtolower($mode);
    }

    /**
     * Set Configuration data.
     * @param array $configs;
     */
    public function set_config(array $configs)
    {
        $this->payment_configs = Arr::has($configs, ["tAmt", "amt", "txAmt", "psc", "pdc", "pid"]);

        $this->payment_configs = $configs;
        if (!isset($this->scd)) {
            $this->payment_configs["scd"] = $this->merchant_key;
        }
        $this->payment_configs["su"] = route('esewa.payment.success', ["q" => 'su']);
        $this->payment_configs["fu"] = route('esewa.payment.failure', ["q" => 'fu']);
    }

    public function get_configs()
    {
        return $this->payment_configs;
    }

    public function get_url()
    {
        if ($this->mode == "test") {
            return "https://uat.esewa.com.np/epay/main";
        }
        return "https://esewa.com.np/epay/main";
    }

    public function process_payment(Request $request)
    {
        $curl = curl_init($this->get_url());
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->get_configs());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public function payment_success()
    {
        echo 'success url';
    }

    public function payment_error()
    {
        echo "failed url";
    }

    /**
     * ---------------------------------------------------
     * This will parse XML string and return the object.
     * ---------------------------------------------------
     *
     * @param string $str
     * @return mixed
     * ---------------------------------------------------
     */
    private function parseXML(String $response)
    {

        $xml = simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA);
        return json_decode(json_encode((array)$xml), false);
    }


    /**
     * Verify Payment Esewa Payment Process
     */

    public function verify_payment(Request $request)
    {
        if ( ! Arr::has($this->get_configs(),["scd","rid","pid","amt"])) {
            throw new Error("Invalid parameters.");
        }
        $this->set_config(Arr::only($this->get_configs(),["scd","rid","amt","pid"]));
        $curl = curl_init($this->verification_url());
        // dd($curl);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, Arr::only($this->get_configs(),["scd","rid","amt","pid"]));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        $parse_response = $this->parseXML($response);
        return (strtolower(trim($parse_response->response_code)) == "success") ? true : false;
    }
}

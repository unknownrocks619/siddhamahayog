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
        $this->mode = config('services.esewa.environment');
        $this->merchant_key = config('services.esewa.merchant_code');
        $this->set_verification_url(config('services.esewa.verification_' . $this->mode));
    }


    public function set_verification_url($url)
    {
        $this->verification_url = $url;
    }

    public function verification_url()
    {
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
        $this->payment_configs = $configs;

        if (!isset($this->payment_configs['scd'])) {
            $this->payment_configs["scd"] = $this->merchant_key;
        }
        session()->put(auth()->id(), $this->payment_configs);
    }

    /**
     * @param string @key
     */
    public function get_configs(string $key = null): mixed
    {
        return ($key && isset($this->payment_configs[$key])) ? $this->payment_configs[$key] : $this->payment_configs;
    }

    public function get_payment_url()
    {
        return config('services.esewa.redirect_' . $this->mode);
    }

    public function process_payment()
    {
        $curl = curl_init($this->get_payment_url());
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->get_configs());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public function process_payment_html()
    {
        $output =  "<form method='POST' action='{$this->get_payment_url()}' id='esewa_form' class='d-none'>";
        foreach ($this->get_configs() as $payment_key => $payment_value) :
            $output .= "<input type='hidden' value='{$payment_value}' name='{$payment_key}' />";
        endforeach;
        $output .= "</form>";

        // autosubmit form
        $output .= "<script type='text/javascript'>";
        $output .= "document.getElementById('esewa_form').submit();";
        $output .= "</script>";

        return $output;
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

    protected function payment_verification_config(): void
    {
        if (session()->has(auth()->id())) {
            $sessionData = session()->get(auth()->id());
            $this->set_config([
                "scd" => $this->merchant_key,
                "rid" => request()->get('refId'),
                "amt" => $sessionData['amt'],
                "pid" => $sessionData['pid']
            ]);
            // session()->forget(auth()->id());
        }
    }

    /**
     * Verify Payment Esewa Payment Process
     */

    public function verify_payment(): bool
    {
        $this->payment_verification_config();

        if (!$this->get_configs()) {
            return false;
        }

        $curl = curl_init($this->verification_url());
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, Arr::only($this->get_configs(), ["scd", "rid", "amt", "pid"]));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        $parse_response = $this->parseXML($response);
        return (strtolower(trim($parse_response->response_code)) == "success") ? true : false;
    }
}

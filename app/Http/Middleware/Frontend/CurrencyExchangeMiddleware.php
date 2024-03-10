<?php

namespace App\Http\Middleware\Frontend;

use App\Models\Centers;
use App\Models\CurrencyExchange;
use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Stripe\ExchangeRate;

class CurrencyExchangeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // if (getenv('APP_ENV') == 'local') {
        //     return $next($request);
        // }
        $this->storeTodayExchangeRate();
        return $next($request);
    }

    public function storeTodayExchangeRate()
    {
        if (!CurrencyExchange::getExchangeRateByDate(date("Y-m-d"))) {

            $exchangeRates = new Client();

            $params = [
                'per_page' => 10,
                'page' => 1,
                'from'  => date('Y-m-d'),
                'to'    => date('Y-m-d')
            ];

            $response = $exchangeRates->get('https://www.nrb.org.np/api/forex/v1/rates?'.http_build_query($params));

            if ($response->getStatusCode() !== 200) {
                return;
            }

            $bodyRespose = $response->getBody()->getContents();
            $decodeQuery = json_decode($bodyRespose,true);
            
            if ( ! isset ($decodeQuery['data']['payload'][0]['rates']) ) {
                return;
            }

            if ( $decodeQuery['data']['payload'][0]['date'] != date('Y-m-d') ) {
                return;
            }
            
            $rates = $decodeQuery['data']['payload'][0]['rates'];

            $requiredCurrency = Centers::get();

            foreach ($rates as $rate) {
                $currency = strtoupper($rate['currency']['iso3']);

                if (! $requiredCurrency->where('default_currency',$currency)->first() ) {
                    continue;
                }

                $exchangeRate = new CurrencyExchange();
                $exchangeRate->exchange_date = date('Y-m-d');
                $exchangeRate->exchange_from = strtolower($currency);
                $exchangeRate->exchange_to = 'npr';
                $exchangeRate->exchange_data = $rate;
                $exchangeRate->save();

            }

            // $exchange = new CurrencyExchange();
            // $exchange->exchange_date = date("Y-m-d");
            // $exchange->exchange_from = "USD";
            // $exchange->exchange_to = "NPR";




            // $query_params = [
            //     'amount' => 1
            // ];

            // $headers = [
            //     "Content-Type" => "text/plain",
            //     'apiKey' => ENV("APILAYER_CURRENCY_API")
            // ];

            // $exchange_date  = [];

            // $curl = curl_init();

            // curl_setopt_array($curl, array(
            //     CURLOPT_URL => "https://www.nrb.org.np/api/forex/v1/rate?".http_build_query($params),
            //     CURLOPT_RETURNTRANSFER => true,
            //     CURLOPT_ENCODING => "",
            //     CURLOPT_MAXREDIRS => 10,
            //     CURLOPT_TIMEOUT => 0,
            //     CURLOPT_FOLLOWLOCATION => true,
            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //     CURLOPT_CUSTOMREQUEST => "GET"
            // ));

            // $response = curl_exec($curl);

            // $decodeJson = json_decode($response);
            // dd($decodeJson);
            // $data = $decodeJson->data->payload->rates[1];


            // $exchangeModel = new CurrencyExchange();
            // $exchangeModel->exchange_date = date("Y-m-d");
            // $exchangeModel->exchange_from = 'usd';
            // $exchangeModel->exchange_to = "npr";
            // $exchangeModel->exchange_data = $data;

            // $exchangeModel->save();
        }
    }
}

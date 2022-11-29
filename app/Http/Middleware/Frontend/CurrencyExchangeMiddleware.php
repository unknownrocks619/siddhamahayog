<?php

namespace App\Http\Middleware\Frontend;

use App\Models\CurrencyExchange;
use Closure;
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
        $this->storeTodayExchangeRate();
        return $next($request);
    }

    private function storeTodayExchangeRate()
    {
        if (!CurrencyExchange::getExchangeRateByDate(date("Y-m-d"))) {
            $exchange = new CurrencyExchange();
            $exchange->exchange_date = date("Y-m-d");
            $exchange->exchange_from = "USD";
            $exchange->exchange_to = "NPR";


            $query_params = [
                'amount' => 1
            ];

            $headers = [
                "Content-Type" => "text/plain",
                'apiKey' => ENV("APILAYER_CURRENCY_API")
            ];

            $exchange_date  = [];

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://www.nrb.org.np/api/forex/v1/rate",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET"
            ));

            $response = curl_exec($curl);

            $decodeJson = json_decode($response);
            $data = $decodeJson->data->payload->rates[1];


            $exchangeModel = new CurrencyExchange();
            $exchangeModel->exchange_date = date("Y-m-d");
            $exchangeModel->exchange_from = 'usd';
            $exchangeModel->exchange_to = "npr";
            $exchangeModel->exchange_data = $data;

            $exchangeModel->save();
        }
    }
}

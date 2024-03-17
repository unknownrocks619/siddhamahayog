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
        if ( ! CurrencyExchange::getExchangeRateByDate(date('Y-m-d')) ) {
            $this->storeTodayExchangeRate(date('Y-m-d'));
        }
        return $next($request);
    }

    public function storeTodayExchangeRate($date)
    {

            $exchangeRates = new Client();

            $params = [
                'per_page' => 10,
                'page' => 1,
                'from'  => $date,
                'to'    => $date
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

            if ( $decodeQuery['data']['payload'][0]['date'] != $date ) {
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
                $exchangeRate->exchange_date = $date;
                $exchangeRate->exchange_from = strtolower($currency);
                $exchangeRate->exchange_to = 'npr';
                $exchangeRate->exchange_data = $rate;
                $exchangeRate->save();

            }

    }
}

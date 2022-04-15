<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExchangeResource;
use App\Services\ExchangeService;
use Illuminate\Http\Request;

/**
 *
 */
class QuizController extends Controller
{
    private $exchangeService;

    public function __construct(
        ExchangeService $exchangeService
    ) {
        $this->exchangeService = $exchangeService;
    }

    public function getExchangeRate(Request $request)
    {
         // dd("1");
        $content=       file_get_contents('https://tw.rter.info/capi.php');
        $currency=      json_decode($content);
        $json_request=  json_decode($request);

        $from=          $request->from;
        $to=            $request->to;
        $search =       $from.$to;
        // dd($currency);
        if(empty($currency->$search))
        {
            $response =collect(["error","error"]);
        }
        else
        {
            $response = collect([$currency->$search->Exrate,$currency->$search->UTC]);
        }
        // dd(collect([$currency->$search->Exrate,$currency->$search->UTC]));

        
        // dd($response);
        // TODO: 實作取得匯率
        // API回傳結果
        return new ExchangeResource($response);
    }
}

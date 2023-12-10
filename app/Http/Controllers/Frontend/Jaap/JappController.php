<?php

namespace App\Http\Controllers\Frontend\Jaap;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Yagya\HanumandDailyCounter;
use App\Models\Yagya\HanumandYagyaCounter;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;

class JappController extends Controller
{
    //
    /**
     * return json response
     *
     * @param bool $state
     * @param string|null $msg
     * @param mixed $jsCallback
     * @param array $params
     * @param int $status
     * @param int $errorStatus
     * @return \Illuminate\Support\Facades\Response
     */
    public function json(bool $state, ?string $msg = null, $jsCallback = null, array $params = [], int $status = 200, int $errorStatus = 422): HttpResponse
    {
        $response = [
            'state' => $state,
            'status' => $status,
            'msg' => $msg,
            'params' => $params,
            'callback' => $jsCallback
        ];

        $response = Response::make($response, (($state) ? $status : $errorStatus));
        $response->header('Content-Type', 'application/json');
        return $response;
    }

    public function modalSetting() {
        // check if user have registered as not interested.
        $hanumandYagyaInfo = HanumandYagyaCounter::where('member_id',auth()->id())->first();

        if (  $hanumandYagyaInfo && ! $hanumandYagyaInfo->is_taking_part) {
            return $this->json(false,'');
        }

        if ( ! $hanumandYagyaInfo ) {

            $view = 'confirm-choice';

        } else {
            // check if user has filled in today count.
            $hanumandYagyaCounter = HanumandDailyCounter::where('member_id',auth()->id())
                ->where('count_date',date('Y-m-d'))
                ->first();

            if ( $hanumandYagyaCounter ) {
                return $this->json(true,'Information Already Added.');
            }

            $view = 'daily-counter';
        }

        $viewRender = view('frontend.user.hanumand-yagya.partials.'.$view,['hanumandYagyaInfo' => $hanumandYagyaInfo])->render();

        return $this->json(true,'Modal Loaded','displayModal',['view' => $viewRender]);
    }

    public function cancelChoice(Request $request){
        $hanumandYagyaCounter = HanumandYagyaCounter::where('member_id',auth()->id())->first();

        if (! $hanumandYagyaCounter ) {
            $hanumandYagyaCounter = new HanumandYagyaCounter();

            $hanumandYagyaCounter->fill([
                'member_id' => auth()->id(),
                'total_counter' => 0
            ]);

        }

        $hanumandYagyaCounter->is_taking_part = false;
        $hanumandYagyaCounter->save();
    }

    public function insertDailyCounter(Request $request) {

        // get yagya information.
        $hanumandYagyaCounter = HanumandYagyaCounter::where('member_id',auth()->id())->first();


        $hanumandYagyaDailyCounter = new HanumandDailyCounter();

        $hanumandYagyaDailyCounter->fill([
            'humand_yagya_id' => $hanumandYagyaCounter->getKey(),
            'member_id' => auth()->id(),
            'count_date'    => $request->post('date'),
            'total_count' => $request->post('total_count')
        ]);

        $hanumandYagyaDailyCounter->save();
        return back();
    }

    public function indexYagya(Program $program) {
        $jaaps = HanumandYagyaCounter::where('program_id',$program->getKey())
                                    ->where('member_id',auth()->id())
                                    ->with('dailyCounter')
                                    ->first();

        return view('frontend.user.program.mantra-count.index',['program' => $program,'jaaps' => $jaaps]);
    }

    public function deleteJaap(HanumandDailyCounter $jap) {
        $jap->delete();
        return back();
    }
}

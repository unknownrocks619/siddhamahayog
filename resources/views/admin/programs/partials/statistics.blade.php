@php
/** @var  \App\Models\Program $program */

$totalStat = collect($program->totalAdmissionFee('admission_fee'));
$admission_fee = $totalStat->where('total_by','admission_fee')->first();
$monthly_fee = $totalStat->where('total_by','monthly_fee')->first();
$total_revenue = $totalStat->where('total_by','grand_total')->first();
@endphp
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between mb-3">
            <h5 class="card-title mb-0">Statistics</h5>
        </div>
    </div>
    <div class="card-body">
        <div class="row gy-3">
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                    <div class="badge rounded-pill bg-label-primary me-3 p-2"><i class="ti ti-chart-pie-2 ti-sm"></i></div>
                    <div class="card-info">
                        <h5 class="mb-0">
                            {{default_currency($admission_fee->total_amount ?? 0.0)}}
                        </h5>
                        <small>Total Admission Fee</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                    <div class="badge rounded-pill bg-label-info me-3 p-2"><i class="ti ti-currency ti-sm"></i></div>
                    <div class="card-info">
                        <h5 class="mb-0">
                            {{default_currency($monthly_fee->total_amount ?? 0.0)}}
                        </h5>
                        <small>Total Monthly Fee</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                    <div class="badge rounded-pill bg-label-danger me-3 p-2"><i class="ti ti-shopping-cart ti-sm"></i></div>
                    <div class="card-info">
                        <h5 class="mb-0">{{ default_currency(0.0) }}</h5>
                        <small>Video Revenue</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                    <div class="badge rounded-pill bg-label-success me-3 p-2"><i class="ti ti-currency-dollar ti-sm"></i></div>
                    <div class="card-info">
                        <h5 class="mb-0">
                            {{default_currency($total_revenue->total_amount ?? 0.0)}}
                        </h5>
                        <small>Revenue</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($program->getKey() == 5 )
    @php
        $totalMantraJap = \App\Models\Yagya\HanumandYagyaCounter::where('program_id',$program->getKey())
                                                                   ->sum('total_counter');
        $totalEnrolled = \App\Models\Yagya\HanumandYagyaCounter::where('program_id',$program->getKey())
                                                                    ->count();
    @endphp
    <div class="card my-3">
        <div class="card-header">
            <div class="d-flex justify-content-between mb-3">
                <h5 class="card-title mb-0">Hanumand Statistics</h5>
            </div>
        </div>
        <div class="card-body">
            <div class="row gy-3">
                <div class="col-md-3 col-6">
                    <div class="d-flex align-items-center">
                        <div class="badge rounded-pill bg-label-primary me-3 p-2"><i class="ti ti-chart-pie-2 ti-sm"></i></div>
                        <div class="card-info">
                            <h5 class="mb-0">
                                {{$totalMantraJap}}
                            </h5>
                            <small>Total Mantra Jap</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="d-flex align-items-center">
                        <div class="badge rounded-pill bg-label-info me-3 p-2"><i class="ti ti-currency ti-sm"></i></div>
                        <div class="card-info">
                            <h5 class="mb-0">
                                {{$totalEnrolled}}
                            </h5>
                            <small>Total Participants</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="d-flex align-items-center">
                        <div class="badge rounded-pill bg-label-danger me-3 p-2"><i class="ti ti-shopping-cart ti-sm"></i></div>
                        <div class="card-info">
                            <h5 class="mb-0">0</h5>
                            <small>Total Confirmed</small>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endif

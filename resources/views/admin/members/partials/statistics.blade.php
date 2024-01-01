@php
/** @var  \App\Models\Member $member */
$yagyaInformation = \App\Models\Yagya\HanumandYagyaCounter::where('member_id',$member->getKey())->first();
@endphp
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between mb-3">
            <h5 class="card-title mb-0">Statistics</h5>
        </div>
    </div>
    <div class="card-body">
        <div class="row gy-3">
            <div class="col-md-12 col-12">
                <div class="d-flex align-items-center">
                    <div class="badge rounded-pill bg-label-primary me-3 p-2"><i class="ti ti-chart-pie-2 ti-sm"></i></div>
                    <div class="card-info">
                        <h5 class="mb-0">
                            {{$yagyaInformation?->total_counter ?? 0}}
                        </h5>
                        <small>Total Mantra Jap</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

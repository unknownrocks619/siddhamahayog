<?php

use App\Models\Scholarship;
use App\Models\UnpaidAccess;
$enroll = $program;
$showPayment = false;
$showPending = false;
$allowJoin = false;
$live = $program->live;

$program = $program->program;
$admission = $program->admission_fee()->first();

if ($program->program_type == 'open') {
} else {
    $scholarship = Scholarship::where('program_id', $program->getKey())
        ->where('student_id', user()->getKey())
        ->first();
    $unpaidAccess = UnpaidAccess::totalAccess(user(), $program);

    if ($scholarship || (int) user()->role_id === 1) {
        $allowJoin = true;
    }

    if (!$allowJoin) {
        // check for admission paid.
        if (!$admission) {
            // check for grace period.
            if ($unpaidAccess <= site_settings('unpaid_access')) {
                $allowJoin = true;
            }
            $showPayment = true;
        }

        if ($admission) {
            if ($admission->verified) {
                $allowJoin = true;
            }

            if ($admission->rejected) {
                $allowJoin = false;
                $showPayment = true;
            }

            if (!$admission->verified && !$admission->rejected) {
                $showPayment = false;
                $showPending = true;
            }

            if (!$allowJoin) {
                if ($unpaidAccess <= site_settings('unpaid_access')) {
                    $allowJoin = true;
                }
            }
        }
    }

    if (!$live) {
        $allowJoin = false;
    } else {
        if ($allowJoin) {
            $showPayment = false;
            $showPending = false;
        }
    }
}
?>
@includeWhen(!$enroll->active, 'frontend.user.dashboard.buttons.cancel-subscription')
@includeWhen(
    $allowJoin && $enroll->active,
    'frontend.user.dashboard.buttons.join-now',
    compact('program', 'live'))
@includeWhen(
    $showPayment && $enroll->active,
    'frontend.user.dashboard.buttons.pay-now',
    compact('program', 'live'))
@includeWhen($showPending && $enroll->active, 'frontend.user.dashboard.buttons.pending')
@includeWhen(!$showPending && !$allowJoin && !$showPayment, 'frontend.user.dashboard.buttons.not-available')

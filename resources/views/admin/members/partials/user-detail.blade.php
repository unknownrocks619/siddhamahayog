<div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
    <!-- User Pills -->
    <ul class="nav nav-pills flex-column flex-md-row mb-4">
        <li class="nav-item">
            <a class="nav-link @if ($tab == 'user-detail') active @endif"
                href="@if ($tab == 'user-detail') javascript:void(0);@else{{ route('admin.members.show', ['member' => $member->getKey(), 'tab' => 'user-detail']) }} @endif"><i
                    class="ti ti-user-check ti-xs me-1"></i>Account</a>
        </li>

        <li class="nav-item">
            <a class="nav-link  @if ($tab == 'programs') active @endif"
                href="@if ($tab == 'programs') javascript:void(0);@else{{ route('admin.members.show', ['member' => $member->getKey(), 'tab' => 'programs']) }} @endif">
                <i class="ti ti-lock ti-xs me-1"></i>Programs</a>
        </li>
        @if (adminUser()->role()->isSuperAdmin())
            <li class="nav-item">
                <a class="nav-link  @if ($tab == 'billing') active @endif"
                    href="@if ($tab == 'billing') javascript:void(0);@else{{ route('admin.members.show', ['member' => $member->getKey(), 'tab' => 'billing']) }} @endif"><i
                        class="ti ti-currency-dollar ti-xs me-1"></i>Billings</a>
            </li>
        @endif
        {{--        <li class="nav-item"> --}}
        {{--            <a class="nav-link  @if ($tab == 'support') active @endif" href="@if ($tab == 'support')javascript:void(0);@else{{route('admin.members.show',['member'=>$member->getKey(),'tab'=>'support'])}}@endif"><i class="ti ti-bell ti-xs me-1"></i>Supports</a></li> --}}
        <li class="nav-item">
            <a class="nav-link  @if ($tab == 'dikshya-info') active @endif"
                href="@if ($tab == 'dikshya-info') javascript:void(0);@else{{ route('admin.members.show', ['member' => $member->getKey(), 'tab' => 'dikshya-info']) }} @endif"><i
                    class="ti ti-link ti-xs me-1"></i>Dikshya Info</a>
        </li>

        <li class="nav-item">
            <a class="nav-link  @if ($tab == 'sadhana-info') active @endif"
                href="@if ($tab == 'sadhana-info') javascript:void(0);@else{{ route('admin.members.show', ['member' => $member->getKey(), 'tab' => 'sadhana-info']) }} @endif"><i
                    class="ti ti-link ti-xs me-1"></i>Sadhana Info</a>
        </li>

        <li class="nav-item">
            <a class="nav-link  @if ($tab == 'emergency-info') active @endif"
                href="@if ($tab == 'emergency-info') javascript:void(0);@else{{ route('admin.members.show', ['member' => $member->getKey(), 'tab' => 'emergency-info']) }} @endif"><i
                    class="ti ti-link ti-xs me-1"></i>Emergency Info</a>
        </li>

        <li class="nav-item">
            <a class="nav-link  @if ($tab == 'media-info') active @endif"
                href="@if ($tab == 'media-info') javascript:void(0);@else{{ route('admin.members.show', ['member' => $member->getKey(), 'tab' => 'media-info']) }} @endif"><i
                    class="ti ti-link ti-xs me-1"></i>Media</a>
        </li>

        @if (adminUser()->role()->isSuperAdmin() || adminUser()->role()->isAdmin())
            <li class="nav-item">
                <a class="nav-link  @if ($tab == 'dharmashala-info') active @endif"
                    href="@if ($tab == 'dharmashala-info') javascript:void(0);@else{{ route('admin.members.show', ['member' => $member->getKey(), 'tab' => 'dharmashala-info']) }} @endif"><i
                        class="ti ti-link ti-xs me-1"></i>Dharmashala</a>
            </li>
            <li class="nav-item">
                <a class="nav-link  @if ($tab == 'refers-info') active @endif"
                    href="@if ($tab == 'refers-info') javascript:void(0);@else{{ route('admin.members.show', ['member' => $member->getKey(), 'tab' => 'refers-info']) }} @endif"><i
                        class="ti ti-link ti-xs me-1"></i>Refers</a>
            </li>
        @endif
        @if (
            $member->role->isTeacher() &&
                (in_array(adminUser()->role(), [
                    App\Classes\Helpers\Roles\Rule::SUPER_ADMIN,
                    App\Classes\Helpers\Roles\Rule::ADMIN,
                ]) ||
                    in_array(adminUser()->centers?->pluck('center_id')->toArray() ?? 0, [adminUser()->center_id])))
            <li class="nav-item">
                <a class="nav-link  @if ($tab == 'under-sadhak') active @endif"
                    href="@if ($tab == 'under-sadhak') javascript:void(0);@else{{ route('admin.members.show', ['member' => $member->getKey(), 'tab' => 'under-sadhak']) }} @endif"><i
                        class="ti ti-link ti-xs me-1"></i>Under Sadhak</a>
            </li>
            <li class="nav-item">
                <a class="nav-link  @if ($tab == 'under-sadhak') active @endif"
                   href="@if ($tab == 'training-info') javascript:void(0);@else{{ route('admin.members.show', ['member' => $member->getKey(), 'tab' => 'training-info']) }} @endif"><i
                        class="ti ti-link ti-xs me-1"></i>Training Info</a>
            </li>
        @endif
    </ul>
    <!--/ User Pills -->
    @include('admin.members.tabs.' . $tab)
</div>

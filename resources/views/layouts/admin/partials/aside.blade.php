<!-- Menu -->
<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal  menu bg-menu-theme flex-grow-0">
    <div class="container-xxl d-flex h-100">
        <ul class="menu-inner">
            @foreach (\App\Classes\Helpers\Navigation::adminParentAsideNavigationItems() as $nav_item)
                <li class="menu-item">
                    <a href="@if( ! $nav_item->child()->count() && $nav_item->route){{route($nav_item->route,$nav_item->route_params ?? [])}}@endif" class="menu-link @if( $nav_item->child()->count()) menu-toggle @endif">
                        @if($nav_item->icon) <i class="menu-icon tf-icons ti ti-{{$nav_item->icon}}"></i> @endif
                        <div data-i18n="{{$nav_item->name}}">{{$nav_item->name}}</div>
                    </a>

                    @if($nav_item->child()->count() )
                        <ul class="menu-sub">
                            @foreach ($nav_item->child as $child_menu)

                                <li class="menu-item">
                                    <a href="@if( ! $child_menu->child()->count() && $child_menu->route){{route($child_menu->route,$child_menu->route_params ?? [])}}@endif" class="menu-link @if( $child_menu->child()->count()) menu-toggle @endif">
                                        @if($child_menu->icon) <i class="menu-icon tf-icons ti ti-{{$child_menu->icon}}"></i> @endif
                                        <div data-i18n="{{$child_menu->name}}">{{$child_menu->name}}</div>
                                    </a>

                                    @if($child_menu->child()->count())
                                        <ul class="menu-sub">
                                            @foreach ($child_menu->child as $children_menu)
                                                    <li class="menu-item">
                                                        <a href="@if($children_menu->route){{route($children_menu->route,$children_menu->route_params ?? [])}}@endif" class="menu-link">
                                                            @if($children_menu->icon) <i class="menu-icon tf-icons ti ti-{{$children_menu->icon}}"></i> @endif
                                                            <div data-i18n="{{$children_menu->name}}">{{$children_menu->name}}</div>
                                                        </a>
                                                    </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</aside>
<!-- / Menu -->

<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle" style="width: 250px; min-width: 250px; max-width: 250px; flex: 0 0 250px;">
    <!--begin::Brand-->
    <div class="aside-logo flex-column-auto py-5" id="kt_aside_logo">
        <!--begin::Logo-->
        <a href="#">
            {{-- <img alt="Logo" src="{{asset('media/logo/iward-sidebar.png')}}" class="logo" /> --}}
            <img alt="Logo" src="{{asset('media/logo/iward-sidebar.png')}}" style="max-height:30px; margin-bottom: 5px;"/>
        </a>
        <!--end::Logo-->
    </div>
    <!--end::Brand-->
    <!--begin::Aside menu-->
    <div class="aside-menu flex-column-fluid">
        <!--begin::Aside Menu-->
        <div class="hover-scroll-overlay-y py-2" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
            <!--begin::Menu-->
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true">
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion mt-5">
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}" href="{{ route('dashboard.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Dashboard</span>
                            </a>
                        </div>
                        {{-- <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('ocassignment.index') ? 'active' : '' }}" href="{{ route('ocassignment.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">On Call Assignment</span>
                            </a>
                        </div> --}}
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('patmanagement.index') ? 'active' : '' }}" href="{{ route('patmanagement.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Patient Management</span>
                            </a>
                        </div>                         
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('ocassignment.*') ? 'show' : '' }}">
                            <span class="menu-link">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Oncall Roster Assignment</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <div class="menu-sub menu-sub-accordion">
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('ocassignment.ct.index') ? 'active' : '' }}" href="{{ route('ocassignment.ct.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Cardiothoracic</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('ocassignment.cd.index') ? 'active' : '' }}" href="{{ route('ocassignment.cd.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Cardiology</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('ocassignment.nm.index') ? 'active' : '' }}" href="{{ route('ocassignment.nm.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Nurse Manager</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('ocassignment.anaes.index') ? 'active' : '' }}" href="{{ route('ocassignment.anaes.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Anaesthesia</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('ocassignment.pchc.index') ? 'active' : '' }}" href="{{ route('ocassignment.pchc.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">PCHC</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('ocassignment.other.index') ? 'active' : '' }}" href="{{ route('ocassignment.other.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Others</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('ocassignment.sa.index') ? 'active' : '' }}" href="{{ route('ocassignment.sa.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Staff Assignment</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('ocassignment.ert.index') ? 'active' : '' }}" href="{{ route('ocassignment.ert.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Area Response Team</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
            </div>
            <!--end::Menu-->
        </div>
    </div>
    <!--end::Aside menu-->
</div>
<!-- Left Sidebar start-->
<div class="side-menu-fixed">
    <div class="scrollbar side-menu-bg">
        <ul class="nav navbar-nav side-menu" id="sidebarnav">

            <!-- menu item Dashboard-->
            <li>
                <span class="center-nav-text p-2 bg-light"><img class="w-75 m-3"
                        src="{{ URL::asset('images/logo-dark.png') }}" alt=""></span>

            </li>
            </hr>
            <li>
                <a href="{{ route('dashboard') }}"><i class="ti-home"></i><span
                        class="right-nav-text font-weight-bold">لوحة التحكم</span>
                </a>
            </li>
            @can('عرض القطاعات')
                <li>
                    <a href="{{ route('department.index') }}"><i class="ti-pie-chart"></i><span
                            class="right-nav-text font-weight-bold">القطاعات</span> </a>
                </li>
            @endcan
            @can('عرض الشارات')
                <li>
                    <a href="{{ route('badge.index') }}"><i class="ti-pie-chart"></i><span
                            class="right-nav-text font-weight-bold">شارات</span> </a>
                </li>
            @endcan
                <li>
                    <a href="{{ route('user.index') }}"><i class="ti-user"></i><span
                            class="right-nav-text font-weight-bold">الافراد</span> </a>
                </li>

            <li>
                <a href="{{ route('payment.index') }}"><i class="ti-money"></i><span
                        class="right-nav-text font-weight-bold">ميزانية</span> </a>
            </li>


            <li>
                <a href="javascript:void(0);" data-toggle="collapse" data-target="#reports">
                    <div class="pull-left"><i class="ti-home"></i><span class="right-nav-text">تقارير</span></div>
                    <div class="pull-right"><i class="ti-plus"></i></div>
                    <div class="clearfix"></div>
                </a>
                <ul id="reports" class="collapse" data-parent="#sidebarnav">
                    <li> <a href="{{ route('reports.attendance') }}">الحضور و الفياب</a> </li>
                    <li> <a href={{ route('reports.birthday') }}>اعياد الميلاد</a> </li>
                    <li> <a href={{ route('reports.absent.data') }}>تقرير الغياب</a> </li>
                    <li> <a href={{ route('reports.black_list_report') }}>تقرير البلاك ليست</a> </li>
                    <li> <a href={{ route('reports.totals_view') }}>تقرير اجمالي الحضور</a> </li>

                </ul>
            </li>
            @can('عرض الصلاحيات')
                <li>
                    <a href="{{ route('roles.index') }}"><i class="ti-lock"></i><span
                            class="right-nav-text font-weight-bold">الصلاحيات</span> </a>
                </li>
            @endcan
        </ul>
    </div>
</div>
<!-- Left Sidebar End-->

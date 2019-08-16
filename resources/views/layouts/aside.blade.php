@php
    $page = config('site.page');
@endphp
<nav class="sidebar sidebar-sticky">
    <div class="sidebar-content  js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <i class="align-middle" data-feather="layers"></i>
            <span class="align-middle">{{config('app.name')}}</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-item @if($page == 'home') active @endif"><a href="{{route('home')}}" class="font-weight-bold sidebar-link"><i class="align-middle" data-feather="home"></i> <span class="align-middle">Dashboard</span></a></li>
            @php
                $supply_items = ['supply_list', 'add_supply'];
            @endphp
            <li class="sidebar-item @if($page == in_array($page, $supply_items)) active @endif">
                <a href="#supplies" data-toggle="collapse" class="font-weight-bold sidebar-link collapsed">
                    <i class="align-middle" data-feather="server"></i> <span class="align-middle">Supplies</span>
                </a>
                <ul id="supplies" class="sidebar-dropdown list-unstyled collapse ">
                    <li class="sidebar-item @if($page == 'supply_list') active @endif"><a class="sidebar-link" href="{{route('supply.index')}}">Supply List</a></li>
                    <li class="sidebar-item @if($page == 'add_supply') active @endif"><a class="sidebar-link" href="{{route('supply.create')}}">Add Supply</a></li>
                </ul>
            </li>
            <li class="sidebar-item @if($page == 'supplier') active @endif"><a href="{{route('supplier.index')}}" class="font-weight-bold sidebar-link"><i class="align-middle" data-feather="home"></i> <span class="align-middle">Suppliers</span></a></li>
            <li class="sidebar-item @if($page == 'user') active @endif"><a href="{{route('users.index')}}" class="font-weight-bold sidebar-link"><i class="align-middle" data-feather="users"></i> <span class="align-middle">User Management</span></a></li>
            @php
                $settings_items = ['scategory', 'pcategory'];
            @endphp
            <li class="sidebar-item @if($page == in_array($page, $settings_items)) active @endif">
                <a href="#layouts" data-toggle="collapse" class="font-weight-bold sidebar-link collapsed">
                    <i class="align-middle" data-feather="settings"></i> <span class="align-middle">Settings</span>
                </a>
                <ul id="layouts" class="sidebar-dropdown list-unstyled collapse ">
                    <li class="sidebar-item @if($page == 'scategory') active @endif"><a class="sidebar-link" href="{{route('scategory.index')}}">Supply Category</a></li>
                    <li class="sidebar-item @if($page == 'pcategory') active @endif"><a class="sidebar-link" href="{{route('pcategory.index')}}">Product Category</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">

    <div class="app-sidebar__user">
        <div class="avatar-box">
            <img class="app-sidebar__user-avatar" src="{{asset("assets/Layer 2.png")}}" alt="User Image">
        </div>
        <!--<div>-->
        <!--    <p class="app-sidebar__user-name">{{ auth()->user()->full_name }}</p>-->
        <!--</div>-->
    </div>
    <ul class="app-menu">

              
        @if(hasPermissions("view-dashboard"))
        <li><a class="app-menu__item @if(request()->routeIs("dashboard.index")) active @endif" href="{{route("dashboard.index")}}"><i class="app-menu__icon fas fa-tachometer-alt"></i><span class="app-menu__label">Dashboard</span></a></li>
        @endif

         @if(hasPermissions(["create-branch" ,"edit-branch", "delete-branch", "control-sliders-branches"]))
        <li class="treeview @if(request()->routeIs("branches.*")) is-expanded @endif"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-store"></i><span class="app-menu__label">Branches</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item @if(request()->routeIs("branches.create")) active @endif" href="{{ route("branches.create") }}"><i class="icon fa fa-circle-o"></i> Create New Branch</a></li>
                <li><a class="treeview-item @if(request()->routeIs("branches.index")) active @endif" href="{{ route("branches.index") }}"><i class="icon fa fa-circle-o"></i> All Branches</a></li>
            </ul>
        </li>
         @endif

            @if(hasPermissions(["create-category" ,"edit-category", "delete-category"]))

        <li class="treeview @if(request()->routeIs("categories.*")) is-expanded @endif"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-list"></i><span class="app-menu__label">Categories</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item @if(request()->routeIs("categories.create")) active @endif" href="{{ route("categories.create") }}"><i class="icon fa fa-circle-o"></i> Create New Category</a></li>
                <li><a class="treeview-item @if(request()->routeIs("categories.index")) active @endif" href="{{ route("categories.index") }}"><i class="icon fa fa-circle-o"></i> All Categories</a></li>
            </ul>
        </li>
            @endif

            @if(hasPermissions(["create-items" ,"edit-items", "delete-items"]))
            <li class="treeview @if(request()->routeIs("items.*")) is-expanded @endif"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-tags"></i><span class="app-menu__label">Items</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item @if(request()->routeIs("items.create")) active @endif" href="{{ route("items.create") }}"><i class="icon fa fa-circle-o"></i> Create New Items</a></li>
                <li><a class="treeview-item @if(request()->routeIs("items.index")) active @endif" href="{{ route("items.index") }}"><i class="icon fa fa-circle-o"></i> All Items</a></li>
            </ul>
        </li>
            @endif

            @if(hasPermissions(["create-slider" ,"edit-slider", "delete-slider"]))

            <li class="treeview @if(request()->routeIs("sliders.*")) is-expanded @endif"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas far fa-images"></i><span class="app-menu__label">Sliders</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item @if(request()->routeIs("sliders.create")) active @endif" href="{{ route("sliders.create") }}"><i class="icon fa fa-circle-o"></i> Create New Slider</a></li>
                <li><a class="treeview-item @if(request()->routeIs("sliders.index")) active @endif" href="{{ route("sliders.index") }}"><i class="icon fa fa-circle-o"></i> All Sliders</a></li>
            </ul>
        </li>
            @endif

            @if(hasPermissions("view-and-control-users-application"))

               <li class="treeview @if(request()->routeIs("users.*")) is-expanded @endif"><a class="app-menu__item" href="#"  data-toggle="treeview" ><i class="app-menu__icon  fas fa-user"></i><span class="app-menu__label">Users</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                  <ul class="treeview-menu">
                         <li><a class="app-menu__item @if(request()->routeIs("users.app.index")) active @endif" href="{{route("users.app.index")}}"><i class="app-menu__icon fas fa-mobile-alt"></i><span class="app-menu__label">App Users</span></a></li>
                        <li><a class="app-menu__item @if(request()->routeIs("users.driver.index")) active @endif" href="{{route("users.driver.index")}}"><i class="app-menu__icon fas fa-truck"></i><span class="app-menu__label">Driver Users</span></a></li>
                        <li><a class="app-menu__item @if(request()->routeIs("users.vendor.index")) active @endif" href="{{route("users.vendor.index")}}"><i class="h2">V</i><span class="app-menu__label">endor Users</span></a></li>
                    </ul>
                </li>
            @endif


            @if(hasPermissions("admin-control"))
        <li class="treeview @if(request()->routeIs("admins.*")) is-expanded @endif"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-users-cog"></i><span class="app-menu__label">Admins</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">

                <li><a class="treeview-item @if(request()->routeIs("admins.create")) active @endif" href="{{ route("admins.create") }}"><i class="icon fa fa-circle-o"></i> Create New Admin</a></li>
                <li><a class="treeview-item @if(request()->routeIs("admins.index")) active @endif" href="{{ route("admins.index") }}"><i class="icon fa fa-circle-o"></i> All Admins</a></li>
                <li><a class="treeview-item @if(request()->routeIs("roles.create")) active @endif" href="{{ route("roles.create") }}"><i class="icon fa fa-circle-o"></i> Create New Roles</a></li>
                <li><a class="treeview-item @if(request()->routeIs("roles.index")) active @endif" href="{{ route("roles.index") }}"><i class="icon fa fa-circle-o"></i> Roles & Permissions</a></li>

            </ul>
        </li>
            @endif

            @if(hasPermissions("view-orders"))
            <li><a class="app-menu__item @if(request()->routeIs("orders.*")) active @endif" href="{{route("orders.index")}}"><i class="app-menu__icon fas fa-box-open"></i><span class="app-menu__label">Orders</span></a></li>
             @endif
            @if(hasPermissions("control-and-edit-application-settings"))
           <li><a class="app-menu__item @if(request()->routeIs("settings.*")) active @endif" href="{{route("settings.index")}}"><i class="app-menu__icon fas fa-tools"></i><span class="app-menu__label">App Settings</span></a></li>
           @endif



        <!--<li class="treeview @if(request()->routeIs("delivery_price.*")) is-expanded @endif"><a class="app-menu__item" href="#"  data-toggle="treeview" ><i class="app-menu__icon  fas fa-truck"></i><span class="app-menu__label">Delivery Price</span><i class="treeview-indicator fa fa-angle-right"></i></a>-->
        <!--    <ul class="treeview-menu">-->


        <!--     <li><a class="treeview-item @if(request()->routeIs("delivery_price.index")) active @endif" href="{{ route("delivery_price.index") }}" ><i class="icon fa fa-circle-o"></i> show Delivery Price</a></li>-->
        <!--        <li><a class="treeview-item @if(request()->routeIs("delivery_price.create")) active @endif" href="{{ route("delivery_price.create") }}"><i class="icon fa fa-circle-o"></i> Add Delivery Price</a></li>-->


        <!--    </ul>-->
        <!--</li>-->
            @if(hasPermissions(["view-items-ordered-report", "view-users-ordered-report", "view-branches-sales-report"]))
                <li class="treeview @if(request()->routeIs("reports.*")) is-expanded @endif"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-file-alt"></i><span class="app-menu__label">Reports</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a class="treeview-item @if(request()->routeIs("reports.items_count_order")) active @endif" href="{{ route("reports.items_count_order") }}"><i class="icon fa fa-circle-o"></i> Items Ordered</a></li>
                        <li><a class="treeview-item @if(request()->routeIs("reports.users_with_count_him_orders")) active @endif" href="{{ route("reports.users_with_count_him_orders") }}"><i class="icon fa fa-circle-o"></i> Users Ordered</a></li>
                    </ul>
                </li>
            @endif


            @if(hasPermissions(["view-promo-Code","edit-promo-Code","delete-promo-Code"]))

                <li class="treeview @if(request()->routeIs("promoCode.*")) is-expanded @endif"><a class="app-menu__item" href="#" data-toggle="treeview"><i class=" app-menu__icon  fas fa-percent"></i><span class="app-menu__label">promoCode</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a class="treeview-item @if(request()->routeIs("promoCode.create")) active @endif" href="{{ route("promoCode.create") }}"><i class="icon fa fa-circle-o"></i>create promo Code</a></li>
                        <li><a class="treeview-item @if(request()->routeIs("promoCode.index")) active @endif" href="{{ route("promoCode.index") }}"><i class="icon fa fa-circle-o"></i>show promocode</a></li>

                    </ul>
                </li>
            @endif

            @if(hasPermissions(["view-welcome-message","edit-welcome-message","delete-welcome-message" ]))


            <li class="treeview @if(request()->routeIs("WelcomeMessage.*")) is-expanded @endif"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon  fas fa-envelope"></i><span class="app-menu__label">WelcomeMessage</span><i class=" fa fa-angle-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a class="treeview-item @if(request()->routeIs("WelcomeMessage.create")) active @endif" href="{{ route("WelcomeMessage.create") }}"><i class="icon fa fa-circle-o"></i>create Welcome Message </a></li>
                            <li><a class="treeview-item @if(request()->routeIs("WelcomeMessage.index")) active @endif" href="{{ route("WelcomeMessage.index") }}"><i class="icon fa fa-circle-o"></i>show Welcome Messages</a></li>
                        </ul>
                    </li>
            @endif








    </ul>
</aside>

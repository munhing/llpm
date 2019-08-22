<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <h4><a href="{{ URL::route('home')}}">
            <b>LLPM - THIS IS JUST A TEST SITE ON NEW SERVER</b>
            </a></h4>
            <div class="menu-toggler sidebar-toggler hide">
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
   
                <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <i class="icon-anchor"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                <li>
                                    <a href="{{ URL::route('manifest.schedule.create') }}">
                                    <span class="details">
                                    <i class="icon-plus"></i>
                                    Vessel Schedule </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ URL::route('manifest.vessels.create') }}">
                                    <span class="details">
                                    <i class="icon-plus"></i>
                                    Vessel </span>
                                    </a>
                                </li>                                
                            </ul>
                        </li>
                    </ul>
                </li> 

                <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <i class="fa fa-arrow-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                <li>
                                    <a href="{{ URL::route('receiving.containers.create') }}">
                                    <span class="details">
                                    <i class="icon-plus"></i>
                                    Empty Containers </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ URL::route('receiving.cargoes.create') }}">
                                    <span class="details">
                                    <i class="icon-plus"></i>
                                    Export Cargo </span>
                                    </a>
                                </li>                                
                            </ul>
                        </li>
                    </ul>
                </li> 

                <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <i class="fa fa-exchange"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                <li>
                                    <a href="{{ URL::route('workorders.create') }}">
                                    <span class="details">
                                    <i class="icon-plus"></i>
                                    Work Order </span>
                                    </a>
                                </li>                                                                                               
                            </ul>
                        </li>
                    </ul>
                </li> 

                <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <i class="fa fa-male"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                <li>
                                    <a href="{{ URL::route('portusers.create') }}">
                                    <span class="details">
                                    <i class="icon-plus"></i>
                                    Port User </span>
                                    </a>
                                </li>                                
                            </ul>
                        </li>
                    </ul>
                   
                </li>

                <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <i class="icon-user"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                <li>
                                    <a href="{{ URL::route('register') }}">
                                    <span class="details">
                                    <i class="icon-plus"></i>
                                    User </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ URL::route('roles.create') }}">
                                    <span class="details">
                                    <i class="icon-plus"></i>
                                    Roles </span>
                                    </a>
                                </li>                                
                            </ul>
                        </li>
                    </ul>
                </li>
                <!-- BEGIN USER LOGIN DROPDOWN -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <li class="dropdown dropdown-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <i class="fa fa-user"/></i>
                    <span class="username username-hide-on-mobile">
                        {{ Auth::user()->name }}
                    </span>
                    <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="{{ URL::route('profile') }}">
                            <i class="icon-user"></i> My Profile </a>
                        </li>

                        <li class="divider">
                        </li>

                        <li>
                            <a href="{{ URL::route('logout') }}">
                            <i class="icon-key"></i> Log Out </a>
                        </li>
                    </ul>
                </li>
                <!-- END USER LOGIN DROPDOWN -->
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->

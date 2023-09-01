        <!-- Main sidebar -->
        <div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

            <!-- Sidebar content -->
            <div class="sidebar-content">

                <!-- Sidebar header -->
                <div class="sidebar-section">
                    <div class="sidebar-section-body d-flex justify-content-center">
                        <h5 class="sidebar-resize-hide flex-grow-1 my-auto">Navigation</h5>

                        <div>
                            <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                                <i class="ph-arrows-left-right"></i>
                            </button>

                            <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                                <i class="ph-x"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /sidebar header -->


                <!-- Main navigation -->
                <div class="sidebar-section">
                    <ul class="nav nav-sidebar" id="navbar-nav" data-nav-type="accordion">

                        <!-- Main -->
                        <li class="nav-item-header pt-0">
                            <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Main</div>
                            <i class="ph-dots-three sidebar-resize-show"></i>
                        </li>
                        <li class="nav-item">
                            <a href="/dashboard" class="nav-link">
                                <i class="ph-house"></i>
                                <span>
                                    Dashboard
                                    {{-- <span class="d-block fw-normal opacity-50">No pending orders</span> --}}
                                </span>
                            </a>
                        </li> 
                        {{-- <li class="nav-item">
                            <a href="customer_form" class="nav-link">
                                <i class="ph-list-numbers"></i>
                                <span>Customer</span>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="members" class="nav-link">
                                <i class="ph-user-list"></i>
                                <span>Members</span>
                            </a>
                        </li>
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link">
                                <i class="ph-files"></i>
                                <span>Master Data</span>
                            </a>
                            <ul class="nav-group-sub collapse">
                                <li class="nav-item"><a href="/master_designation" class="nav-link">Designation</a></li>
                                <li class="nav-item"><a href="/master_place_of_work" class="nav-link">Place of work</a></li>
                                <li class="nav-item"><a href="/master_sub_department" class="nav-link">Serving Sub-Department</a></li>
                                <li class="nav-item"><a href="/master_place_of_payroll" class="nav-link">Place of Payroll Preparation</a></li>
                            </ul>
                        </li>
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link">
                                <i class="ph-gear"></i>
                                <span>Settings</span>
                            </a>
                            <ul class="nav-group-sub collapse">
                                <li class="nav-item"><a href="/user_role_list" class="nav-link">User Roles</a></li>
                                <li class="nav-item"><a href="/view_user" class="nav-link">Create User</a></li>
                                <li class="nav-item"><a href="/view_users_list" class="nav-link">User List</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- /main navigation -->

            </div>
            <!-- /sidebar content -->

        </div>
        <!-- /main sidebar -->

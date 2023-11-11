        <!-- Main sidebar -->
        <div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

            <!-- Sidebar content -->
            <div class="sidebar-content">

                <!-- Sidebar header -->
                <div class="sidebar-section">
                    <div class="sidebar-section-body d-flex justify-content-center">
                        <h5 class="sidebar-resize-hide flex-grow-1 my-auto">Navigation</h5>

                        <div>
                            <button type="button"
                                class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                                <i class="ph-arrows-left-right"></i>
                            </button>

                            <button type="button"
                                class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
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
                        @if(Auth::user()->can('member_information'))
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link">
                                <i class="ph-gear"></i>

                                <span>Member Information</span>
                            </a>
                            <ul class="nav-group-sub collapse">
                                <ul class="nav-item-submenu">
                                    <!-- <li class="nav-item">
                                        <a href="/members" class="nav-link">
                                            <i class="ph-user-list"></i>
                                            <span>
                                                Member Loan
                                                {{-- <span class="d-block fw-normal opacity-50">No pending orders</span> --}}
                                            </span>
                                        </a>
                                    </li>-->
                                    @if(Auth::user()->can('members'))
                                    <li class="nav-item"><a href="/members" class="nav-link"> <i
                                                class="ph-user-list"></i>Members</a></li>
                                    @endif
                                </ul>
                                <!--<ul class="nav-item-submenu">
                                    <li class="nav-item"><a href="/member_contribution" class="nav-link"> <i
                                                class="ph-user-list"></i>Member Contribution</a></li>

                                </ul>-->
                                @if(Auth::user()->can('setting'))
                                <ul class="nav-item-submenu">
                                    <a href="#" class="nav-link">
                                        <i class="ph-gear"></i>
                                        <span>Setting</span>
                                    </a>
                                    <ul class="nav-group-sub collapse">
                                        @if(Auth::user()->can('designation'))
                                        <li class="nav-item"><a href="/master_designation"
                                                class="nav-link">Designation</a></li>
                                        @endif
                                        @if(Auth::user()->can('place_of_work'))
                                        <li class="nav-item"><a href="/master_place_of_work" class="nav-link">Place of
                                                work</a>
                                        </li>
                                        @endif
                                        @if(Auth::user()->can('sub_department'))
                                        <li class="nav-item"><a href="/master_sub_department" class="nav-link">Serving
                                                Sub Department</a></li>
                                        @endif
                                        @if(Auth::user()->can('place_of_payeroll'))
                                        <li class="nav-item"><a href="/master_place_of_payroll" class="nav-link">Place
                                                of Payeoll Preparation</a></li>
                                        @endif
                                    </ul>

                                </ul>
                                @endif

                            </ul>
                        </li>
                        @endif
                        @if(Auth::user()->can('contribution'))
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link">
                                <i class="ph-files"></i>
                                <span>Contribution</span>
                            </a>
                            <ul class="nav-group-sub collapse">
                                @if(Auth::user()->can('member_contribution'))
                                <li class="nav-item">
                                    <a href="/member_contribution" class="nav-link">
                                        <i class="ph-user-list"></i>
                                        <span>
                                            Member Contribution
                                            {{-- <span class="d-block fw-normal opacity-50">No pending orders</span> --}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if(Auth::user()->can('contribution_ledger'))
                                <li class="nav-item">
                                    <a href="/member_contribution_ledger_process_list" class="nav-link">
                                        <i class="ph-user-list"></i>
                                        <span>
                                            Contribution Ledger
                                            {{-- <span class="d-block fw-normal opacity-50">No pending orders</span> --}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                <li class="nav-item">

                                </li>
                                @if(Auth::user()->can('setting'))
                                <ul class="nav-item-submenu">
                                    <a href="#" class="nav-link">
                                        <i class="ph-gear"></i>
                                        <span>Setting</span>
                                    </a>
                                    @if(Auth::user()->can('contribution_setting'))
                                    <ul class="nav-group-sub collapse">

                                        <li class="nav-item"><a href="/contribution" class="nav-link">Contribution</a>

                                    </ul>
                                    @endif

                                </ul>
                                @endif
                            </ul>
                        </li>
                        @endif
                        @if(Auth::user()->can('loan'))
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link">
                                <i class="ph-files"></i>
                                <span>Loan</span>
                            </a>
                            <ul class="nav-group-sub collapse">
                                @if(Auth::user()->can('loan_request'))
                                <li class="nav-item">
                                    <a href="/members_loan_request" class="nav-link">
                                        <i class="ph-user-list"></i>
                                        <span>
                                            Loan Request
                                            {{-- <span class="d-block fw-normal opacity-50">No pending orders</span> --}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if(Auth::user()->can('loan_request_approval'))
                                <li class="nav-item">
                                    <a href="/members_loan_request_Approvel" class="nav-link">
                                        <i class="ph-user-list"></i>
                                        <span>
                                            Loan Request Approval
                                            {{-- <span class="d-block fw-normal opacity-50">No pending orders</span> --}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if(Auth::user()->can('member_loan'))
                                <li class="nav-item">
                                    <a href="/member_loan" class="nav-link">
                                        <i class="ph-user-list"></i>
                                        <span>
                                            Member Loan
                                            {{-- <span class="d-block fw-normal opacity-50">No pending orders</span> --}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if(Auth::user()->can('loan_ledger'))
                                <li class="nav-item">
                                    <a href="/member_loan_ledger_list" class="nav-link">
                                        <i class="ph-house"></i>
                                        <span>
                                            Loan Ledger
                                            {{-- <span class="d-block fw-normal opacity-50">No pending orders</span> --}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                <!--<li class="nav-item">
                                    <a href="/member_contribution_ledger_process_list" class="nav-link">
                                        <i class="ph-house"></i>
                                        <span>
                                            Contribution ledger
                                            {{-- <span class="d-block fw-normal opacity-50">No pending orders</span> --}}
                                        </span>
                                    </a>
                                </li>-->
                                @if(Auth::user()->can('recipt'))
                                <li class="nav-item">
                                    <a href="contributionAndloanFilter" class="nav-link">
                                        <i class="ph-house"></i>
                                        <span>
                                            Recipet
                                            {{-- <span class="d-block fw-normal opacity-50">No pending orders</span> --}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                <!--<li class="nav-item">
                                    <a href="/contributionAndloanFilter" class="nav-link">
                                        <i class="ph-house"></i>
                                        <span>
                                            Payment
                                            {{-- <span class="d-block fw-normal opacity-50">No pending orders</span> --}}
                                        </span>
                                    </a>
                                </li>-->
                                @if(Auth::user()->can('setting'))
                                <ul class="nav-item-submenu">
                                    <a href="#" class="nav-link">
                                        <i class="ph-gear"></i>
                                        <span>Setting</span>
                                    </a>
                                    <ul class="nav-group-sub collapse">
                                        @if(Auth::user()->can('loan_setting'))
                                        <li class="nav-item"><a href="/loneManagement" class="nav-link">Loan</a></li>
                                        @endif
                                        <!-- <li class="nav-item"><a href="/contribution" class="nav-link">Contribution</a>
                                        <li class="nav-item"><a href="/member_contribution" class="nav-link">Member
                                                Contribution</a>
                                        </li>-->
                                    </ul>

                                </ul>
                                @endif

                            </ul>
                        </li>
                        @endif
                        @if(Auth::user()->can('donations_and_grativity'))
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link">
                                <i class="ph-files"></i>
                                <span>Donations & Grativity </span>
                            </a>
                            <ul class="nav-group-sub collapse">
                                @if(Auth::user()->can('donations_and_grativity_request'))
                                <li class="nav-item">
                                    <a href="/Death_gratuity_all_requests" class="nav-link">
                                        <i class="ph-user-list"></i>
                                        <span>

                                            Death Grativity Request
                                            {{-- <span class="d-block fw-normal opacity-50">No pending orders</span> --}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if(Auth::user()->can('donations_and_grativity_approval'))
                                <li class="nav-item">
                                    <a href="/Death_gratuity_requests_Approvel" class="nav-link">
                                        <i class="ph-user-list"></i>
                                        <span>

                                            Death Grativity Approval
                                            {{-- <span class="d-block fw-normal opacity-50">No pending orders</span> --}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if(Auth::user()->can('setting'))
                                <ul class="nav-item-submenu">
                                    <a href="#" class="nav-link">
                                        <i class="ph-gear"></i>
                                        <span>Setting</span>
                                    </a>
                                    @if(Auth::user()->can('donation'))
                                    <ul class="nav-group-sub collapse">
                                        <li class="nav-item"><a href="/donation" class="nav-link">Donations</a></li>

                                    </ul>
                                    @endif
                                </ul>
                                @endif

                            </ul>
                        </li>
                        @endif
                        @if(Auth::user()->can('payment'))
                        <!--<li class="nav-item"><a href="/loneManagement" class="nav-link">Setting</a></li>
                        <li class="nav-item"><a href="/contribution" class="nav-link">Contribution</a></li>-->
                        <li class="nav-item nav-item-submenu">

                        <li class="nav-item"><a href="#" class="nav-link"> <i class="ph-files"></i>Payment</a></li>

                        </li>
                        @endif
                        @if(Auth::user()->can('report'))
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link">
                                <i class="ph-file-text"></i>
                                <span>Report </span>
                            </a>
                            <ul class="nav-group-sub collapse">
                                @if(Auth::user()->can('member_information_sheet'))
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="ph-user-list"></i>
                                        <span>

                                            Member information Sheet
                                            {{-- <span class="d-block fw-normal opacity-50">No pending orders</span> --}}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if(Auth::user()->can('advice_of_dedction'))
                                <li class="nav-item">
                                    <a href="/memberReport" class="nav-link">
                                        <i class="ph-files"></i>
                                        <span>

                                            Advice of dedction
                                            {{-- <span class="d-block fw-normal opacity-50">No pending orders</span> --}}
                                        </span>
                                    </a>
                                </li>
                                @endif

                            </ul>
                        </li>
                        @endif
                        @if(Auth::user()->can('tools'))
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link">
                                <i class="ph-gear"></i>
                                <span>Tools</span>
                            </a>
                            <ul class="nav-group-sub collapse">
                                @if(Auth::user()->can('process_loan'))
                                <li class="nav-item"><a href="/loan_process" class="nav-link">Process Loan </a></li>
                                @endif
                                @if(Auth::user()->can('process_contribution'))
                                <li class="nav-item"><a href="/member_contribution_ledger_process"
                                        class="nav-link">Process Contribution</a></li>
                                @endif
                                @if(Auth::user()->can('month_end_process'))
                                <li class="nav-item"><a href="/monthend_process" class="nav-link">Month End Process</a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        @if(Auth::user()->can('setting'))
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link">
                                <i class="ph-gear"></i>
                                <span>Settings</span>
                            </a>
                            <ul class="nav-group-sub collapse">
                                @if(Auth::user()->can('user_role'))
                                
                                <li class="nav-item"><a href="/user_role_list" class="nav-link">User Roles</a></li>
                                @endif
                                @if(Auth::user()->can('user_list'))
                                <li class="nav-item"><a href="/view_users_list" class="nav-link">User List</a></li>
                                @endif
                            </ul>
                        </li>
                        @endif

                    </ul>
                </div>
                <!-- /main navigation -->

            </div>
            <!-- /sidebar content -->

        </div>
        <!-- /main sidebar -->

        <!--
<ul class="nav-item-submenu">
                                <a href="/members" class="nav-link">
                                    <i class="ph-gear"></i>
                                    <span>Members</span>
                                </a>
                                <a href="#" class="nav-link">
                                    <i class="ph-gear"></i>
                                    <span>Master Data</span>
                                </a>

                                <ul class="nav-group-sub collapse">
                                    <li class="nav-item"><a href="/loneManagement" class="nav-link">Lone</a></li>
                                    <li class="nav-item"><a href="/contribution" class="nav-link">Contribution</a></li>
                                </ul>
                            </ul>
                            <ul class="nav-item-submenu">
                                <a href="#" class="nav-link">
                                    <i class="ph-gear"></i>
                                    <span>Master Data</span>
                                </a>
                                <ul class="nav-group-sub collapse">
                                    <li class="nav-item"><a href="/loneManagement" class="nav-link">Lone</a></li>
                                    <li class="nav-item"><a href="/contribution" class="nav-link">Contribution</a></li>
                                </ul>
                                <a href="#" class="nav-link">
                                    <i class="ph-gear"></i>
                                    <span>Master Data</span>
                                </a>

                                <ul class="nav-group-sub collapse">
                                    <li class="nav-item"><a href="/loneManagement" class="nav-link">Lone</a></li>
                                    <li class="nav-item"><a href="/contribution" class="nav-link">Contribution</a></li>
                                </ul>
                            </ul>

-->
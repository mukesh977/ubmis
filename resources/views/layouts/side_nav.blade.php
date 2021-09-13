<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{Auth::user()->first_name.' '.Auth::user()->last_name}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
       {{--  <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form> --}}
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            {{-- <li class="header">MAIN NAVIGATION</li> --}}
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>

                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                  </span>
              </a>
              <ul class="treeview-menu">
                @if(Auth::user()->hasRole('admin'))
                <li class="active"><a href="{{route('admin.dashboard')}}"><i class="fa fa-circle-o"></i> Dashboard </a></li>
                @else
                <li class="active"><a href="{{route('home')}}"><i class="fa fa-circle-o"></i> Dashboard </a></li>
                @endif
            </ul>
        </li>
        @role(['admin','marketingManager'])
        <li class="treeview">
            <a href="#">
                <i class="fa fa-user"></i>
                <span>User Management</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('user.index')}}"><i class="fa fa-user-circle"></i>User & Role Management</a></li>

        </ul>
    </li>
    @endrole

    @role('admin')
    <li class="treeview">
        <a href="#">
            <i class="fa fa-user"></i>
            <span>Employee Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu">

        <li><a href="{{ url('/admin/employee-detail/create') }}"><i class="fa fa-user-circle"></i>Employee Registration Form</a></li>

        <li><a href="{{ url('/admin/employee-detail/list') }}"><i class="fa fa-user-circle"></i>List Employees</a></li>

    </ul>
</li>
@endrole

@role(['admin', 'marketingManager', 'marketingOfficer', 'marketingBoy'])
<li class="treeview">
    <a href="#">
        <i class="fa fa-laptop"></i>
        <span>Field Visits</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu">

    <li><a href="{{route('daily-field-visits.index')}}"><i class="fa fa-circle-o"></i> Daily</a></li>

    @role(['admin','marketingManager'])
    <li><a href="{{route('fieldVisits.all')}}"><i class="fa fa-circle-o"></i> Field Visits</a></li>
    @endauth

    @role(['marketingOfficer', 'marketingBoy'])
    <li><a href="{{route('get.assigned.field.visits')}}"><i class="fa fa-circle-o"></i> Follow Up</a></li>
    @endauth

    <li><a href="{{route('get.assigned.positive.field.visits')}}"><i class="fa fa-circle-o"></i> Positive Field Visits</a></li>

    @role(['marketingManager', 'marketingOfficer', 'marketingBoy'])
    <li><a href="{{ url('calender')}}"><i class="fa fa-circle-o"></i> Calender (Follow Up)</a></li>
    @endauth
</ul>
</li>
@endrole

@role('client')
<li>
  <a href="{{ url('/client/account-information')}}">
    <i class="fa fa-dollar"></i> <span>Account Information</span>
</a>
</li>

<li>
  <a href="{{ url('/client/change-password-form') }}">
    <i class="fa fa-key"></i> <span>Change Password</span>
</a>
</li>
@endrole

@role(['admin', 'marketingManager'])
<li class="treeview">
    <a href="#">
        <i class="fa fa-edit"></i> <span>Set Targets</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{route('users-targets.index')}}"><i class="fa fa-circle-o"></i>Target Management</a></li>
</ul>
</li>
<li class="treeview">
    <a href="#">
        <i class="fa fa-table"></i> <span>Sales</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{route('users-sales.index')}}"><i class="fa fa-circle-o"></i>Sales Targets</a></li>
    <li><a href="{{route('sales.index')}}"><i class="fa fa-circle-o"></i>Sales Management</a></li>
    @endauth

    @role('accountant')
    <li class="treeview">
        <a href="#">
            <i class="fa fa-balance-scale"></i>
            <span>Sales</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="{{ url('/list-sales') }}"><i class="fa fa-list-alt"></i>List sales transactions</a></li>
        <li><a href="{{ url('/add-sales') }}"><i class="fa fa-pencil-square-o"></i>Add sales transaction</a></li>
        @endrole

        @role(['admin', 'accountant'])
        <li><a href="{{ url('/due-transactions') }}"><i class="fa fa-binoculars"></i>Due Transactions</a></li>
        <li><a href="{{ url('/client-transactions') }}"><i class="fa fa-binoculars"></i>Client Transactions</a></li>

        @endrole

        @role('accountant')
    </ul>
</li>

<li class="treeview">
    <a href="#">
        <i class="fa fa-shopping-cart"></i>
        <span>Purchase</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{ url('/list-purchases') }}"><i class="fa fa-list-alt"></i>List purchase transactions</a></li>
    <li><a href="{{ url('/add-purchase') }}"><i class="fa fa-pencil-square-o"></i>Add purchase transaction</a></li>
</ul>
</li>

<li class="treeview">
    <a href="#">
        <i class="fa fa-newspaper-o"></i>
        <span>Invoice</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{ url('/invoices') }}"><i class="fa fa-newspaper-o"></i>Invoices</a></li>

    <li><a href="{{ url('/invoice-companies') }}"><i class="fa fa-newspaper-o"></i>Invoice Pdf Export</a></li>
</ul>
</li>

<li class="treeview">
    <a href="#">
        <i class="fa fa-tasks"></i> <span> Tasks </span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li>
            <a href="{{ url('/due-tasks') }}"><i class="fa fa-tasks"></i> Due Tasks</a>
        </li>

        <li>
            <a href="{{ url('/completed-tasks') }}"><i class="fa fa-tasks"></i> Completed Tasks</a>
        </li>
    </ul>
</li>

<li class="treeview">
    <a href="#">
        <i class="fa fa-calendar"></i> <span>Calendar</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li>
            <a href="{{ url('/notification-calendar') }}"><i class="fa fa-calendar"></i>Notification Calendar</a>
        </li>

        <li>
            <a href="{{ url('/client-follow-up') }}"><i class="fa fa-edit"></i>Add Client Follow Up</a>
        </li>
    </ul>
</li>

@endrole

@role('admin')
</ul>
</li>
<li class="treeview">
    <a href="#">
        <i class="fa fa-edit"></i> <span>Company</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li>
            <a href="{{ url('/admin/list-company') }}"><i class="fa fa-circle-o"></i>List Company</a>
        </li>

        <li>
            <a href="{{ url('/admin/add-company') }}"><i class="fa fa-circle-o"></i>Add Company</a>
        </li>
    </ul>
</li>

<li class="treeview">
    <a href="#">
        <i class="fa fa-edit"></i> <span>Shop</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li>
            <a href="{{ url('/admin/list-shop') }}"><i class="fa fa-circle-o"></i>List Shop</a>
        </li>

        <li>
            <a href="{{ url('/admin/add-shop') }}"><i class="fa fa-circle-o"></i>Add Shop</a>
        </li>
    </ul>
</li>

<li class="treeview">
    <a href="#">
        <i class="fa fa-edit"></i> <span>Visit Category</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li>
            <a href="{{ url('/admin/list-visit-category') }}"><i class="fa fa-circle-o"></i>List Visit Category</a>
        </li>

        <li>
            <a href="{{ url('/admin/add-visit-category') }}"><i class="fa fa-circle-o"></i>Add Visit Category</a>
        </li>
    </ul>
</li>

<li class="treeview">
    <a href="#">
        <i class="fa fa-edit"></i> <span>Payment Method</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li>
            <a href="{{ url('/admin/payment-method') }}"><i class="fa fa-circle-o"></i>List Payment Method</a>
        </li>

        <li>
            <a href="{{ url('/admin/payment-method/create') }}"><i class="fa fa-circle-o"></i>Add Payment Method</a>
        </li>
    </ul>
</li>

<li class="treeview">
    <a href="#">
        <i class="fa fa-edit"></i> <span>Packages</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li>
            <a href="{{ url('/admin/seo-package') }}"><i class="fa fa-circle-o"></i>Seo Package</a>
        </li>

        <li>
            <a href="{{ url('/admin/amc-package') }}"><i class="fa fa-circle-o"></i>AMC Attribute</a>
        </li>
    </ul>
</li>

<li>
    <a href="{{ url('/admin/referred') }}">
        <i class="fa fa-edit"></i> <span>Project Referred Relationship</span>
    </a>
</li>

<li class="treeview">
    <a href="#">
        <i class="fa fa-edit"></i> <span>Calendar</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li>
            <a href="{{ url('/admin/notification-calendar') }}"><i class="fa fa-circle-o"></i>Notification Calendar</a>
        </li>

        <li>
            <a href="{{ url('/admin/client-follow-up') }}"><i class="fa fa-circle-o"></i>Add Client Follow Up</a>
        </li>
    </ul>
</li>
@endrole

@role(['marketingOfficer','marketingBoy'])
<li class="treeview">
    <a href="#">
        <i class="fa fa-edit"></i> <span>Targets</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{route('daily.users.targets')}}"><i class="fa fa-circle-o"></i>Daily</a></li>
    <li><a href="{{route('weekly.users.targets')}}"><i class="fa fa-circle-o"></i>Weekly</a></li>
    <li><a href="{{route('monthly.users.targets')}}"><i class="fa fa-circle-o"></i>Monthly</a></li>
    <li><a href="{{route('quarterly.users.targets')}}"><i class="fa fa-circle-o"></i>Quarterly</a></li>
</ul>
</li>
@endrole
@role('marketingOfficer')
<li class="treeview">
    <a href="#">
        <i class="fa fa-table"></i> <span>Sales</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{route('daily.users.sales')}}"><i class="fa fa-circle-o"></i>Daily</a></li>
    <li><a href="{{route('weekly.users.sales')}}"><i class="fa fa-circle-o"></i>Weekly</a></li>
    <li><a href="{{route('monthly.users.sales')}}"><i class="fa fa-circle-o"></i>Monthly</a></li>
    <li><a href="{{route('quarterly.users.sales')}}"><i class="fa fa-circle-o"></i>Quarterly</a></li>
    <li><a href="{{route('sales.index')}}"><i class="fa fa-circle-o"></i>Sales Lists</a></li>
</ul>
</li>
<li class="treeview">
    <a href="#">
        <i class="fa fa-table"></i> <span>Reporting</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{route('users.sales.reports')}}"><i class="fa fa-circle-o"></i>Reports</a></li>
</ul>
</li>
@endrole
@role('marketingBoy')
<li class="treeview">
    <a href="#">
        <i class="fa fa-table"></i> <span>Reporting</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{route('users.visit.reports')}}"><i class="fa fa-circle-o"></i>Reports</a></li>
</ul>
</li>
@endauth

@role('supporter')
<li>
  <a href="{{ url('/supporter/project-information')}}">
    <i class="fa fa-dollar"></i> <span>Project Information</span>
</a>
</li>

<li>
  <a href="{{ url('/supporter/change-password-form') }}">
    <i class="fa fa-key"></i> <span>Change Password</span>
</a>
</li>
@endrole

{{-- ticket accessible for all --}}
@role('admin|agent')
    <li class="treeview">
        <a href="#">
            <i class="fa fa-ticket"></i> <span>Ticket</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li>
                <a href="{{ url('/tickets') }}"><i class="fa fa-hourglass"></i>Active Tickets
                <small class="label pull-right bg-red">{{  !empty($activeTicketsCount)? $activeTicketsCount : '' }}</small></a>
            </li>

            <li>
                <a href="{{ url('/tickets/complete') }}"><i class="fa fa-check"></i>Completed Tickets
                <small class="label pull-right bg-green">{{  !empty($completedTicketsCount)? $completedTicketsCount : '' }}</small></a>
            </li>

            @role('admin')
                <li>
                    <a href="{{ url('/admin/ticket-dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a>
                </li>
                <li class="treeview">
                    <a href="#"><i class="fa fa-circle-o"></i> Settings
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url('/admin/status') }}"><i class="fa fa-circle-o"></i> Status</a></li>
                        <li><a href="{{ url('/admin/priorities') }}"><i class="fa fa-circle-o"></i> Priorities</a></li>
                        <li><a href="{{ url('/admin/categories') }}"><i class="fa fa-circle-o"></i> Categoies</a></li>
                    </ul>
                </li>
            @endrole
            
        </ul>
    </li>
@endrole

</section>
<!-- /.sidebar -->
</aside>
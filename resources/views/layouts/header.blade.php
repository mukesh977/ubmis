<header class="main-header">
    <!-- Logo -->
    <a href=" @if(Auth::user()->hasRole('admin')) {{route('admin.dashboard')}} @else {{route('home')}}@endif" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>U</b>BY</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Ultra</b>Byte</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">


            @if(Auth::user()->hasRole('admin'))
                <!-- Notifications: style can be found in dropdown.less -->
              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning">{{ ($rST->count()==0)? '' : $rST->count() }}</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have {{ ($rST->count()==0)? 'no any' : $rST->count() }} notifications</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">

                      <?php $count = 0; ?>

                      @foreach( $rST as $r )
                        <?php $count++; ?>
                          @if( $r->r_operation == "edit" )
                          
                          <li>
                            <a href="{{ url('/admin/notification/'.$r->id) }}">
                              <i class="fa fa-balance-scale text-green"></i> Sales edit request from {{ $r->user->first_name}} {{ $r->user->last_name}}
                            </a>
                          </li>

                          @elseif( $r->r_operation == "delete" )
                            <li>
                            <a href="{{ url('/admin/notification/'.$r->id) }}">
                              <i class="fa fa-balance-scale text-green"></i> Sales delete request from {{ $r->user->first_name}} {{ $r->user->last_name}}
                            </a>
                          </li>

                        @elseif( $r->r_operation == "editPurchase" )
                          <li>
                            <a href="{{ url('/admin/purchase-notification/'.$r->id) }}">
                              <i class="fa fa-balance-scale text-green"></i> Purchase edit request from {{ $r->user->first_name}} {{ $r->user->last_name}}
                            </a>
                          </li>
                        @else
                          <li>
                            <a href="{{ url('/admin/purchase-notification/'.$r->id) }}">
                              <i class="fa fa-balance-scale text-green"></i> Purchase delete request from {{ $r->user->first_name}} {{ $r->user->last_name}}
                            </a>
                          </li>
                        @endif

                          <?php 
                            if($count > 10)
                              break;
                          ?>

                      @endforeach
                      
                    </ul>
                  </li>
                  <li class="footer"><a href="{{ url('/admin/notifications') }}">View all</a></li>
                </ul>
              </li>
            @endif

            @if(Auth::user()->hasRole('accountant'))
                <!-- Notifications: style can be found in dropdown.less -->
              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning">{{ ($timelyNotificationsCount == 0)? '' : $timelyNotificationsCount }}</span>
                </a>
                <?php //dd($timelyNotifications); ?>
                <ul class="dropdown-menu notification_box">
                  <li class="header">You have {{ ($timelyNotificationsCount == 0)? 'no any' : $timelyNotificationsCount }} notifications unread</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">

                      <?php $count = 0; ?>

                      @foreach( $timelyNotifications as $timelyNotification )
                        
                        @if( $timelyNotification->seen == 1 )
                          <?php $color = '#ffffff'; ?>
                          @if( $timelyNotification->successfully_sent == 1 )
                           
                            <li style="background: {{ $color }}; ">
                              <a href="{{ url('ac-notification/'.$timelyNotification->id) }}">
                                <div>
                                <i class="fa fa-envelope text-green mr-10"></i>
                                Expiration of 
                                  @foreach($services as $service)
                                    @if($service->id == $timelyNotification->service_id) 
                                      <b>{{ $service->name }}</b>
                                    @endif
                                  @endforeach
                                    
                                   service of <b>{{ $timelyNotification->company->name }}</b>
                              </div>
                              
                                <div>
                                <p class="notification">{{ Carbon\Carbon::parse($timelyNotification->created_at)->diffForHumans() }}</p>
                              </div>
                              </a>
                            </li>
                          @else
                            <li style="background: {{ $color }}; ">
                                <a href="{{ url('ac-notification/'.$timelyNotification->id) }}">
                                  <div>
                                  <i class="fa fa-envelope text-red mr-10"></i>
                                  Expiration of 
                                    @foreach($services as $service)
                                      @if($service->id == $timelyNotification->service_id) 
                                        <b>{{ $service->name }}</b>
                                      @endif
                                    @endforeach
                                    
                                   service of <b>{{ $timelyNotification->company->name }}</b>
                                </div>

                                  <div>
                                <p class="notification">{{ Carbon\Carbon::parse($timelyNotification->created_at)->diffForHumans() }}</p>
                              </div>

                                </a>
                              </li>
                          @endif


                        @else
                           
                          <?php $color = '#f1efef'; ?>
                          @if( $timelyNotification->successfully_sent == 1 )
                            <li style="background: {{ $color }}; ">
                              <a href="{{ url('ac-notification/'.$timelyNotification->id) }}">
                                <div>
                                  <i class="fa fa-envelope text-green mr-10"></i>
                                  Expiration of 
                                    @foreach($services as $service)
                                      @if($service->id == $timelyNotification->service_id) 
                                        <b>{{ $service->name }}</b>
                                      @endif
                                    @endforeach
                                    
                                   service of <b>{{ $timelyNotification->company->name }}</b>
                                </div>
                                <div>
                                  <p class="notification">{{ Carbon\Carbon::parse($timelyNotification->created_at)->diffForHumans() }}</p>
                                </div>

                              </a>
                            </li>
                          @else
                            <li style="background: {{ $color }}; ">
                              <a href="{{ url('ac-notification/'.$timelyNotification->id) }}">
                                <div>
                                  <i class="fa fa-envelope text-red mr-10"></i>
                                  Expiration of 
                                    @foreach($services as $service)
                                      @if($service->id == $timelyNotification->service_id) 
                                        <b>{{ $service->name }}</b>
                                      @endif
                                    @endforeach
                                    
                                   service of <b>{{ $timelyNotification->company->name }}</b>

                                </div>
                                <div>
                                  <p class="notification">{{ Carbon\Carbon::parse($timelyNotification->created_at)->diffForHumans() }}</p>
                                </div>
                              </a>
                            </li>
                          @endif

                        @endif
                          
                      @endforeach
                      
                    </ul>
                  </li>
                  @if( $timelyNotifications->count() >= 4)
                    <li class="footer"><a href="#">View all</a></li>
                  @endif
                </ul>
              </li>
            @endif



                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ Auth::user()->email }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- Menu Body -->
                        <li class="user-footer">
                            <div class="pull-right">
                                <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Sign out</a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                {{--<li>--}}
                    {{--<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>--}}
                {{--</li>--}}
            </ul>
        </div>
    </nav>
</header>

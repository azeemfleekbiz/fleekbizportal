<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image" style="height: 20px">

            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->f_name }}  {{ Auth::user()->l_name }}</p>

            </div>
        </div>
        <!-- search form -->

        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">        
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>          
            </li>
            <li>
                <a href=""><i class="fa fa-first-order" aria-hidden="true"></i> 
                    Orders
                </a>
            </li>
            <li>
                <a href=""><i class="fa fa-envelope" aria-hidden="true"></i> 
                    Invoices
                </a>
            </li>
            <li>
                <a href="{{url('contributor/profile')}}"><i class="fa fa-user" aria-hidden="true"></i>
                    Profile
                </a>
            </li>
            <li>
                <a href=""><i class="fa fa-lock" aria-hidden="true"></i>
                    Change Password
                </a>
            </li>
            <li>
                <a href="{{url('logout')}}"><i class="fa fa-power-off" aria-hidden="true"></i>
                    SignOut</a>
            </li>












        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
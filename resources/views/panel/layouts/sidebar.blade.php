 <!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('leads.index')? '' : 'collapsed'  }}" href="{{route('leads.index')}}">
                <i class="bi bi-grid"></i>
                <span>Leads</span>
            </a>
        </li>


       


    </ul>

</aside><!-- End Sidebar-->

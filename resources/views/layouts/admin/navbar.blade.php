<nav class="main-header navbar navbar-expand  navbar-dark " style="background-color: #6B92A4">

    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" id="collapse_id" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto"  >
        <li class="nav-item">
            <a href="#" data-toggle ="dropdown" class="nav-link" id="">
                <i class="fas fa-user"></i>
            </a>
        </li>
       <li class="nav-item dropdown">
            <a href="#" data-toggle ="dropdown" class="nav-link">
                <i class="fas fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style=" font-family: 'Poppins', sans-serif;">  
             
                <div class="dropdown-divider"></div>
              
                <a href="{{route('setting_password')}}" class="dropdown-item">
                    <i class="fas fa-tools mr-2"></i>Setting<span class="float-right text-muted text-sm"></span>
                </a>
            
                    <div class="dropdown-divider"></div>
                    
                    <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item dropdown-footer">
                    <i class="fa-solid fa-power-off mr-2"></i> Log Out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
              </div>
       </li>
    </ul>
</nav>
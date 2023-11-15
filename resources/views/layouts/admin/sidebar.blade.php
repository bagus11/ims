<aside class="main-sidebar sidebar-dark-danger elevation-4" style="background-color: #26577C" >
    <a href="" class="brand-link bg-white" style=" border-top-right-radius: 25px;">
        <div id="60_container" hidden>
            <img src="{{asset('60.png')}}" height="30px" style="margin-left:auto;margin-right:auto;display:block" alt="">
        </div>
        <div id="logo_container">
            <img src="{{asset('icon.png')}}" height="30px" style="margin-left:auto;margin-right:auto;display:block" alt="">
        </div>
        
     </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{URL::asset('profile.png')}}" class="img-circle elevation-2" alt="User Image">
                
            </div>
            <div class="info">
                <a href="#" class="d-block" style="font-size:14px">{{auth()->user()->name}}</a>
            </div>
        </div>
      
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @php
                    $menus = DB::table('menus')
                        ->join('permissions', 'permissions.name','=','menus.permission_name')
                        ->join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                        ->join('roles', 'roles.id','role_has_permissions.role_id')
                        ->join('model_has_roles', 'model_has_roles.role_id', 'roles.id')
                        ->select('menus.*')
                        ->where('status',1)
                        ->where('model_has_roles.model_id', auth()->user()->id)
                        ->orderBy('order','asc')
                        ->get();
                @endphp
                @foreach ($menus as $item)
                    @if($item->type == 1)
                        <li class="nav-item">
                            <a href="{{$item->link}}" class="nav-link">
                                <ion-icon name="{{$item->icon}}"></ion-icon>
                                <p class="ml-2">{{$item->name}}</p>
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            @php
                                $submenus = DB::table('submenus')->select('submenus.*')
                                        ->join('permissions','permissions.name','=','submenus.permission_name')
                                        ->join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                                        ->join('roles', 'roles.id','role_has_permissions.role_id')
                                        ->join('model_has_roles', 'model_has_roles.role_id', 'roles.id')
                                        ->where('submenus.id_menus', $item->id)
                                        ->where('submenus.status', 1)
                                        ->where('model_has_roles.model_id', auth()->user()->id)
                                        ->orderBy('order','asc')
                                        ->get();
                            @endphp
                             <a href="#" class="nav-link">
                                <ion-icon name="{{$item->icon}}"></ion-icon>
                                <p class="ml-2" style="margin-top:-10px !mportant">{{$item->name}}<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                @foreach ($submenus as $row)
                                    <li class="nav-item" style="width:100%">
                                        <a href="{{$row->link}}" class="nav-link ml-2">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{{$row->name}}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>   
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>
</aside>
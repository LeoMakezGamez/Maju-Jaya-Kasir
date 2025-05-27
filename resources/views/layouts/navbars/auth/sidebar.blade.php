 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!---------------------====== CSS ======-------------------->
     <link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css">
     <!--------------------===== Boxicons CSS =====------------------->
     <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>



     <title>Sidebar Menu</title>
 </head>

 <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0  my-3 fixed-start ms-3 "
     id="sidenav-main">

     <body>
         <aside class="sidebar close" id="sidebar" style="background: #DADDE4;">
             <header>
                 <div class="image-text">
                     <span class="image">
                         <img src="{{ asset('assets/img/LOGO MAJU JAYA.png') }}" alt="Logo">

                     </span>
                 </div>

             </header>

             <div class="menu-bar">
                 <div class="menu">
                     <ul class="menu-links">

                         <li class="nav-link {{ request()->routeIs('unit.index') ? 'active' : '' }}">
                             <a href="{{ route('unit.index') }}">
                                 <i class='bx bx-box icon'></i>
                                 <span class="text nav-text">Unit</span>
                             </a>
                         </li>
                         <li class="nav-link {{ request()->routeIs('category.index') ? 'active' : '' }}">
                             <a href="{{ route('category.index') }}">
                                 <i class='bx bx-category icon'></i>
                                 <span class="text nav-text">Category</span>
                             </a>
                         </li>
                         <li class="nav-link {{ request()->routeIs('item.index') ? 'active' : '' }}">
                             <a href="{{ route('item.index') }}">
                                 <i class='bx bx-sitemap icon'></i>
                                 <span class="text nav-text">Item</span>
                             </a>
                         </li>
                         <li class="nav-link {{ request()->routeIs('sales.index') ? 'active' : '' }}">
                             <a href="{{ route('sales.index') }}">
                                 <i class='bx bx-objects-vertical-bottom icon'></i>
                                 <span class="text nav-text">Sales</span>
                             </a>
                         </li>
                     </ul>
                 </div>
                 <div class="bottom-content">
                     <li class="nav-link">
                         <a href="{{ url('/logout') }}">
                             <i class='bx bx-log-out icon'></i>
                             <span class="text nav-text">Logout</span>
                         </a>
                     </li>
                 </div>
             </div>
         </aside>



 </aside>

 </body>

 </html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token obligatorio -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard | Baegel Perú</title>

    @yield('cssstyles')

</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="/template/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{route('panel.index')}}" class="brand-link">
            <img src="/template/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Dashboard</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="/template/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">Thais Woolcott</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-file"></i>
                            <p>
                                Páginas
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('panel.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Inicio</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('footer.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Footer</p>
                                </a>
                            </li>       
                            <li class="nav-item">
                                <a href="{{route('catering.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Catering</p>
                                </a>
                            </li>          
                            <li class="nav-item">
                                <a href="{{route('home_story_blocks.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Our Story</p>
                                </a>
                            </li>  
                            <li class="nav-item">
                                <a href="{{route('mailing.header_image')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Mailing</p>
                                </a>
                            </li>   
                            <li class="nav-item">
                                <a href="{{route('faqs.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Faq's</p>
                                </a>
                            </li>        
                            <li class="nav-item">
                                <a href="{{route('privacy.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Politicas de Privacidad</p>
                                </a>
                            </li>  
                            <li class="nav-item">
                                <a href="{{route('terms.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Términos y Condiciones</p>
                                </a>
                            </li>                              
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-sitemap"></i>
                            <p>
                                Categoría
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('category.index')}}" class="nav-link">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Lista de Categorías</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-sitemap"></i>
                            <p>
                                Subcategoría
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('subcategory.index')}}" class="nav-link">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Lista de Subcategorías</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-shopping-basket"></i>
                            <p>
                                Productos Unit.
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('product.unit.index')}}" class="nav-link">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Lista de Productos Unit.</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('product.unit.create')}}" class="nav-link">
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Crear Productos Unit.</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-shopping-basket"></i>
                            <p>
                                Box 1 Sabor
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('product.boxs.index')}}" class="nav-link">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Lista de Box 1 Sabor</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('product.boxs.create')}}" class="nav-link">
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Crear Box 1 Sabor</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-shopping-basket"></i>
                            <p>
                                Box Surtido
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('product.boxm.index')}}" class="nav-link">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Lista de Box Surtido</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('product.boxm.create')}}" class="nav-link">
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Crear Box Surtido</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-shopping-basket"></i>
                            <p>
                                Brunch Box
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('product.brunch.index')}}" class="nav-link">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Lista de Brunch Box</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-header">OTROS</li>
                    <li class="nav-item">
                        <a href="{{route('orders.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-dollar-sign"></i>
                            <p>
                                Ventas
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('reports.orders.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-dollar-sign"></i>
                            <p>
                                Reporte de Ventas
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('user.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                Usuarios
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-truck"></i>
                            <p>
                                Delivery
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('districts.index')}}" class="nav-link active">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Lista de distritos</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('districts.create')}}" class="nav-link">
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Crear distrito</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-percentage"></i>
                            <p>
                                Cupones
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('discount.index')}}" class="nav-link active">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Lista de Cupones</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('discount.create')}}" class="nav-link">
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Crear Cupón</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('testimonial.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-comment"></i>
                            <p>
                                Testimonios
                            </p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{route('bloqueo-turnos.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-calendar"></i>
                            <p>
                                Turnos bloqueados
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('sales.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-dollar-sign"></i>
                            <p>
                                Ventas Históricas
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="nav-icon fas fa-window-close"></i>
                            <p>
                                Cerrar Sesión
                            </p>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

@yield('body')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>


</html>


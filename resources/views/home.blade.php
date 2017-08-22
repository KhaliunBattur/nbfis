<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->

    <script>
        window.Laravel = {csrfToken:"{{csrf_token()}}"};
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper" id="app">

        <header class="main-header">
            <!-- Logo -->
            <router-link to="/" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">ББСБ</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">ББСБ</span>
            </router-link>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ asset(Auth::user()->image) }}" class="user-image" alt="User Image">
                                <span class="hidden-xs">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="{{ asset(Auth::user()->image) }}" class="img-circle" alt="User Image">

                                    <p>
                                        {{ Auth::user()->name }}
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <router-link to="/users/{{ Auth::user()->getKey() }}/profile" class="btn btn-default btn-flat">Хувийн мэдээлэл</router-link>
                                    </div>
                                    <div class="pull-right">
                                        <a onclick="document.getElementById('form-logout').submit()" class="btn btn-default btn-flat">Гарах</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a onclick="document.getElementById('form-logout').submit()" class="links"><i class="fa fa-power-off"></i></a>
                            <form action="/logout" method="POST" id="form-logout">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="{{ asset(Auth::user()->image) }}" class="img-circle image-side-bar" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p>{{ Auth::user()->name }}</p>
                        @foreach(Auth::user()->roles as $role)
                            <span>{{ $role->display_name }}</span>
                        @endforeach
                    </div>
                </div>
                <!-- search form -->
                <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                        <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                        </button>
                      </span>
                    </div>
                </form>
                <!-- /.search form -->
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <li class="header">Үндсэн цэс</li>
                    <li class="active">
                        <router-link to="/"><i class="fa fa-dashboard"></i> <span>Удирдлага</span></router-link>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-user"></i> <span>Хэрэглэгч</span> <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <router-link to="/new/customer"><i class="fa fa-circle-o"></i> Зээлийн хүсэлт бөглөх</router-link>
                            </li>
                            <li>
                                <router-link to="/users"><i class="fa fa-circle-o"></i> Хэрэглэгчийн бүртгэл</router-link>
                            </li>
                            <li>
                                <router-link to="/roles"><i class="fa fa-circle-o"></i> Эрхийн түвшин</router-link>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <router-link to="/account">
                            <i class="fa fa-credit-card"></i> <span>Данс</span>
                        </router-link>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <transition name="fade">
                <router-view></router-view>
            </transition>
        </div>

        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> BETA 1
            </div>
            <strong>Copyright &copy; 2017 <a href="http://woovoo.com" target="_blank">Woovoo</a>.</strong> All rights
            reserved.
        </footer>

    </div>
    <!-- ./wrapper -->

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>

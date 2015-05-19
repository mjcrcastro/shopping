<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">

        <title>Shopping Management System</title>

        {{ HTML::style('//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css') }}
        {{ HTML::style('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css') }}
        {{ HTML::style('//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css') }}
        {{ HTML::style('//cdn.datatables.net/tabletools/2.2.3/css/dataTables.tableTools.css') }}
        {{ HTML::style('css/style.css') }}

        {{ HTML::script('https://code.jquery.com/jquery-2.1.3.min.js') }}
        {{ HTML::script('https://code.jquery.com/ui/1.11.4/jquery-ui.min.js') }}
        {{ HTML::script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js') }}
        {{ HTML::script('//cdn.datatables.net/1.10.7/js/jquery.dataTables.js') }}
        {{ HTML::script('//cdn.datatables.net/tabletools/2.2.3/js/dataTables.tableTools.js') }}
        {{ HTML::script('//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js') }}

        @yield('header') <!-- Header is here to include required functions from the included blade page-->
        <!-- for graphs displays -->
    </head>

    <body>

        <div id="SiteBody">
            <div class="container">
                <div class="row">
                    <div class="span12">

                        <nav class="navbar navbar-default" role="navigation">
                            <div class="container-fluid">
                                <!-- Brand and toggle get grouped for better mobile display -->
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                    <a class="navbar-brand" href="about" >Happy Shopping</a>
                                </div>

                                <!-- Collect the nav links, forms, and other content for toggling -->
                                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                    <ul class="nav navbar-nav">
                                        <li @yield('dashboard_active')> <a href='/'>Dashboard</a> </li>
                                        <li @yield('search_prices_active')> <a href='/prices'>Create Shopping List</a> </li>
                                        <li @yield('purchases_active')>{{ link_to_route('purchases.index','Purchases') }}</li>

                                        <li class ="dropdown @yield('config_active')">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Configuration<span class="caret"></span></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li> {{ link_to_route('shops.index','Shops') }} </li>
                                                <li> {{ link_to_route('products.index','Products') }} </li>
                                                <li> {{ link_to_route('productsTypes.index','Products Types') }} </li>
                                                <li> {{ link_to_route('descriptors.index','Descriptors') }} </li>
                                                <li> {{ link_to_route('descriptorsTypes.index','Descriptors Types') }} </li>
                                                <li> {{ link_to_route('home.getdata','GetData') }} </li>
                                            </ul>
                                        </li>

                                        <li class ="dropdown @yield('dropdown_active')">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Users and Roles<span class="caret"></span></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li> {{ link_to_route('users.index','Users') }} </li>
                                                <li> {{ link_to_route('roles.index','Roles') }} </li>
                                                <li> {{ link_to_route('actions.index','Actions') }} </li>
                                            </ul>
                                        </li>    
                                    </ul>

                                    @yield('form_search')

                                    <ul class="nav navbar-nav navbar-right">
                                        <li>{{ Auth::check() ? '<a href="/logout">Log Out</a>' : '<a href="/login">Log In</a>'; }}</li>
                                    </ul>
                                </div><!-- /.navbar-collapse -->
                            </div><!-- /.container-fluid -->
                        </nav>



                        @if(Session::has('message'))
                        <div class="alert alert-success">
                            {{Session::get('message')}}
                        </div>
                        @endif

                        @yield('main')

                    </div>

                    <div id="footer">
                        Copyright &copy; 2014 by Majcro<br/>
                        All Rights Reserved
                    </div><!-- footer -->

                </div>
            </div>
        </div>
    </body>

</html>

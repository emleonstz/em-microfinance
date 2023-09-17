<!DOCTYPE html>

<head>
    <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <title>ANY | microfinance</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/main.css') ?>">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css') ?>">
    <script src="<?php echo base_url('assets/jquery/jquery-3.7.0.min.js') ?>"></script>
    
</head>

<body class="app sidebar-mini rtl">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="/">Vali</a>
        <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
        <!-- Navbar Right Menu-->
        <ul class="app-nav">
            <li class="app-search">
                <input class="app-search__input" type="search" placeholder="Search">
                <button class="app-search__button"><i class="fa fa-search"></i></button>
            </li>
            <!--Notification Menu-->
            <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Show notifications"><i class="fa fa-bell-o fa-lg"></i></a>
                <ul class="app-notification dropdown-menu dropdown-menu-right">
                    <li class="app-notification__title">You have 4 new notifications.</li>
                    <div class="app-notification__content">
                        <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-primary"></i><i class="fa fa-envelope fa-stack-1x fa-inverse"></i></span></span>
                                <div>
                                    <p class="app-notification__message">Lisa sent you a mail</p>
                                    <p class="app-notification__meta">2 min ago</p>
                                </div>
                            </a></li>
                        <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-danger"></i><i class="fa fa-hdd-o fa-stack-1x fa-inverse"></i></span></span>
                                <div>
                                    <p class="app-notification__message">Mail server not working</p>
                                    <p class="app-notification__meta">5 min ago</p>
                                </div>
                            </a></li>
                        <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-success"></i><i class="fa fa-money fa-stack-1x fa-inverse"></i></span></span>
                                <div>
                                    <p class="app-notification__message">Transaction complete</p>
                                    <p class="app-notification__meta">2 days ago</p>
                                </div>
                            </a></li>
                        <div class="app-notification__content">
                            <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-primary"></i><i class="fa fa-envelope fa-stack-1x fa-inverse"></i></span></span>
                                    <div>
                                        <p class="app-notification__message">Lisa sent you a mail</p>
                                        <p class="app-notification__meta">2 min ago</p>
                                    </div>
                                </a></li>
                            <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-danger"></i><i class="fa fa-hdd-o fa-stack-1x fa-inverse"></i></span></span>
                                    <div>
                                        <p class="app-notification__message">Mail server not working</p>
                                        <p class="app-notification__meta">5 min ago</p>
                                    </div>
                                </a></li>
                            <li><a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-success"></i><i class="fa fa-money fa-stack-1x fa-inverse"></i></span></span>
                                    <div>
                                        <p class="app-notification__message">Transaction complete</p>
                                        <p class="app-notification__meta">2 days ago</p>
                                    </div>
                                </a></li>
                        </div>
                    </div>
                    <li class="app-notification__footer"><a href="#">See all notifications.</a></li>
                </ul>
            </li>
            <!-- User Menu-->
            <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
                <ul class="dropdown-menu settings-menu dropdown-menu-right">
                    <li><a class="dropdown-item" href="/mpangilio"><i class="fa fa-cog fa-lg"></i> Mipangilio</a></li>
                    <li><a class="dropdown-item" href="/wasifu"><i class="fa fa-user fa-lg"></i> Wasifu</a></li>
                    <li><a class="dropdown-item" href="/ondoka"><i class="fa fa-sign-out fa-lg"></i> Ondoka</a></li>
                </ul>
            </li>
        </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
        <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?php echo base_url('assets/img/user.png') ?>" width="30px" height="30px" alt="User Image">
            <div>
                <p class="app-sidebar__user-name"><?php echo session()->USER_FIRSTNAME." ".session()->USER_LASTNAME ?></p>
                <p class="app-sidebar__user-designation"><i class="fa fa-home"></i> <?php echo session()->USER_POSTION ?></p>
            </div>
        </div>
        <ul class="app-menu">
            <li><a class="app-menu__item active" href="/"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
            <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Wakopaji</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item" href="/ongezawakopaji"><i class="icon fa fa-circle-o"></i> Sajili Wakopaji </a></li>
                    <li><a class="treeview-item" href="/wakopaji" ><i class="icon fa fa-circle-o"></i> Tazama wakopaji</a></li>
                    <li><a class="treeview-item" href="/wakopajiujumbe"><i class="icon fa fa-circle-o"></i> Tuma SMS kwa Wakopaji</a></li>
                    <li><a class="treeview-item" href="/wadhamini"><i class="icon fa fa-circle-o"></i> Wadhamini</a></li>
                </ul>
            </li>
            
            <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-edit"></i><span class="app-menu__label">Mikopo</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item" href="/ongezamikopo"><i class="icon fa fa-circle-o"></i> Wasilisha Maombi ya mkopo</a></li>
                    <li><a class="treeview-item" href="/maombiyanayosubiri"><i class="icon fa fa-circle-o"></i>Maombi yaliyosubirishwa</a></li>
                    <li><a class="treeview-item" href="/mikopoisiyolipwa"><i class="icon fa fa-circle-o"></i> Ambayo haijalipwa</a></li>
                    <li><a class="treeview-item" href="/mikopoisiyomalizika"><i class="icon fa fa-circle-o"></i> Ambayo haijakamilika</a></li>  
                    <li><a class="treeview-item" href="/iliyopitiliza"><i class="icon fa fa-circle-o"></i> Iliyopitiliza muda wa malipo</a></li>  
                    <li><a class="treeview-item" href="/tazamamikopo"><i class="icon fa fa-circle-o"></i>Mikopo yote</a></li>
                </ul>
            </li>
            <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Malipo ya mikopo</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item" href="/lipamkopo"><i class="icon fa fa-circle-o"></i> Wasilisha malipo</a></li>
                    <li><a class="treeview-item" href="/malipoyaliyosubirishwa"><i class="icon fa fa-circle-o"></i> Malipo yaliyosubirishwa</a></li>
                    
                </ul>
            </li>
            <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Wafanyakazi</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item" href="/ongezamfanyakazi"><i class="icon fa fa-circle-o"></i> Sajili mfanyakazi</a></li>
                    <li><a class="treeview-item" href="/wafanyakazi"><i class="icon fa fa-circle-o"></i> Tazama Wafanyakazi</a></li>
                    <li><a class="treeview-item" href="/ujumbekwawafanykazi"><i class="icon fa fa-circle-o"></i> Tuma SMS kwa wafanyakazi</a></li>
                    
                </ul>
            </li>
            <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-file-text"></i><span class="app-menu__label">Ripoti</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item" href="/ripotiyamikopo"><i class="icon fa fa-circle-o"></i> Ripoti ya mikopo</a></li>
                    <li><a class="treeview-item" href="/ripotiyamalipo"><i class="icon fa fa-circle-o"></i> Ripoti ya malipo</a></li>
                    <li><a class="treeview-item" href="/ripotiyawakopji"><i class="icon fa fa-circle-o"></i> Ripoti ya wakopaji</a></li>
                    <li><a class="treeview-item" href="/ripotiyamapato"><i class="icon fa fa-circle-o"></i> Ripoti ya mapato</a></li>
                    <li><a class="treeview-item" href="/ripoti"><i class="icon fa fa-circle-o"></i> Ripoti kwa ujumla</a></li>
                    
                </ul>
            </li>
            <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Tawi langu</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item" href="/sajilitawi"><i class="icon fa fa-circle-o"></i> Sajili Tawi</a></li>
                    <li><a class="treeview-item" href="/matawiyangu"><i class="icon fa fa-circle-o"></i> Tazama matawil</a></li>                    
                </ul>
            </li>
            <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Mengineyo</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item" href="/sms"><i class="icon fa fa-circle-o"></i> Kifurushi cha SMS</a></li>
                    <li><a class="treeview-item" href="/mchanganuo"><i class="icon fa fa-circle-o"></i> Uchanganuzi</a></li>
                </ul>
            </li>
        </ul>
    </aside>
    <main class="app-content">
        
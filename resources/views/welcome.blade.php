<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="{{asset('Metro/metro/css/metro-all.css?ver=@@b-version')}}" rel="stylesheet">
    <link href="{{asset('Metro/start.css')}}" rel="stylesheet">

    <title> El Mirador</title>

    <style>
        body {
            background-color: #FAFAFA;
        }
    </style>
</head>
<body class=" fg-black h-vh-100 m4-cloak">

<h1><a href="/login"> Restaurante <span> El Mirador</span></a></h1>
<div class="container-fluid start-screen h-100">

    <div class="tiles-area clear">
        <div class="tiles-grid tiles-group size-2 fg-gray" data-group-title="Principal">

            @if(Session::get('rol')!="Meseros")
                <a href="/home" data-role="tile" class="bg-cyan fg-white">
                    <span class="mif-list2 icon"></span>
                    <span class="branding-bar">Productos</span>
                </a>
            @endif
            @if((Session::get('rol')!="Meseros") && (Session::get('rol')!="Bodeguero"))
                <a href="/mesas" data-role="tile" class="bg-orange fg-white">
                    <span class="mif-layers icon"></span>
                    <span class="branding-bar">Mesas</span>
                </a>
            @endif
            @if(Session::get('rol')=="Administradores")
                <a href="/peoples" data-role="tile" class="bg-green fg-white">
                    <span class="mif-users icon"></span>
                    <span class="branding-bar">Personas</span>
                </a>
            @endif
        </div>

        <div class="tiles-grid tiles-group size-2 fg-gray" data-group-title="Administrativo ">

            @if((Session::get('rol')!="Meseros")&& (Session::get('rol')!="Bodeguero"))
                <a href="/cobrar" data-role="tile" class="bg-red fg-white">
                    <span class="mif-dollar2 icon"></span>
                    <span class="branding-bar">Caja</span>
                </a>
            @endif

            @if((Session::get('rol')!="Meseros")&& (Session::get('rol')!="Bodeguero"))
                <a href="/reporte" data-role="tile" class="bg-blue fg-white">
                    <span class="mif-chart-bars icon"></span>
                    <span class="branding-bar">Reportes</span>
                </a>

            @endif
            @if((Session::get('rol')=="Meseros")||(Session::get('rol')=="Administradores"))
                <a href="/ordenes" data-role="tile" class="bg-brown fg-white">
                    <span class="mif-cart icon"></span>
                    <span class="branding-bar">Ordenes</span>
                </a>
            @endif

        </div>

        <div class="tiles-grid tiles-group size-2 fg-gray" data-group-title="Utensilios">


            @if((Session::get('rol')!="Meseros")&& (Session::get('rol')!="Bodeguero"))
                <a href="/utensilios" data-role="tile" class="bg-orange fg-white">
                    <span class="mif-spoon-fork icon"></span>
                    <span class="branding-bar">Utensilios</span>
                </a>

            @endif
            @if((Session::get('rol')!="Meseros")&& (Session::get('rol')!="Bodeguero"))
                <a href="/proveedores" data-role="tile" class="bg-green fg-white">
                    <span class="mif-profile icon"></span>
                    <span class="branding-bar">Proveedores</span>
                </a>
            @endif

            @if((Session::get('rol')!="Meseros")&& (Session::get('rol')!="Bodeguero"))
                <a href="/planilla" data-role="tile" class="bg-green fg-white">
                    <span class="mif-profile icon"></span>
                    <span class="branding-bar">Planilla</span>
                </a>
            @endif

        </div>

    </div>

    <script src="{{asset('Metro/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('Metro/metro/js/metro.js')}}"></script>
    <script src="{{asset('Metro/start.js')}}"></script>

</div>
</body>
</html>

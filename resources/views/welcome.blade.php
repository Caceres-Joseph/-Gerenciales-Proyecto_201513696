<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="{{asset('Metro/metro/css/metro-all.css?ver=@@b-version')}}" rel="stylesheet">
    <link href="{{asset('Metro/start.css')}}" rel="stylesheet">

    <title> El Gamer</title>

    <style>
        body {
            background-color: #FAFAFA;
        }
    </style>
</head>
<body class=" fg-black h-vh-100 m4-cloak">

<h1><a href="/login"> - <span> El Gamer</span></a></h1>
<div class="container-fluid start-screen h-100">

    <div class="tiles-area clear">
        <div class="tiles-grid tiles-group size-2 fg-gray" data-group-title="Modulos">
 
                <a href="/home" data-role="tile" class="bg-cyan fg-white">
                    <span class="mif-list2 icon"></span>
                    <span class="branding-bar">Invetario</span>
                </a> 

                <!-- <a href="/mesas" data-role="tile" class="bg-orange fg-white">
                    <span class="mif-layers icon"></span>
                    <span class="branding-bar">Sucursales</span>
                </a> -->

                <a href="/cobrar" data-role="tile" class="bg-orange fg-white">
                    <span class="mif-dollar2 icon"></span>
                    <span class="branding-bar">Finanzas</span>
                </a>
                <a href="/peoples" data-role="tile" class="bg-green fg-white">
                    <span class="mif-users icon"></span>
                    <span class="branding-bar">RRHH</span>
                </a>

                <a href="/proveedores" data-role="tile" class="bg-brown fg-white">
                    <span class="mif-profile icon"></span>
                    <span class="branding-bar">Compras</span>
                </a>

        </div>
 


    </div>

    <script src="{{asset('Metro/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('Metro/metro/js/metro.js')}}"></script>
    <script src="{{asset('Metro/start.js')}}"></script>

</div>
</body>
</html>

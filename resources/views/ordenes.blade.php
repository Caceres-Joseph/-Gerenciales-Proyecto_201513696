<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

         
        <title>El Gamer</title>
        <!-- <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet"> -->
       <!--  <link href="https://unpkg.com/vuetify/dist/vuetify.min.css" rel="stylesheet"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

    </head>
    <body onload="zoom()" >
        <div id="app"> 
            <div align="center" class="container">
                    <img src="{{ asset('images/cloud_load.gif') }}" alt="Smiley face" width="250"   >
            </div>
                <router-view></router-view> 
        </div>
    
        <script src="{{ asset('js/appOrdenes.js') }}"></script>  

		<script type="text/javascript">
				function zoom() {
					document.body.style.zoom = "90%" 
				}
		</script>

    </body>
</html>

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

         
        <title>El Mirador</title>
        <!-- <link href='https://fonts.googleapis.com/css?family=Material+Icons' rel="stylesheet"> -->
       <!--  <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet"> -->
       <!--  <link href="https://unpkg.com/vuetify/dist/vuetify.min.css" rel="stylesheet"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
       <!--  <link rel="stylesheet" type="text/css" href="{{asset('Bienvenido/css/fuentes.css')}}" /> -->
    </head>
    <body onload="zoom()">
        <div id="app"> 
            <div align="center" class="container">
                    <img src="{{ asset('images/cloud_load.gif') }}" alt="Smiley face" width="250"   >
                    @if(Session::has('my_name')) 
                    </div>
                <router-view></router-view> 
        </div>

@endif

    
        <script src="{{ asset('js/app.js') }}"></script>
        
		<script type="text/javascript">
				function zoom() {
					document.body.style.zoom = "90%" 
				}
		</script>

    </body>
</html>

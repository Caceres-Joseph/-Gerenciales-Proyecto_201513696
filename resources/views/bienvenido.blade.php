<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

         
        <title>El Mirador</title>
        
		<link rel="stylesheet" type="text/css" href="{{asset('Bienvenido/css/default.css')}}" />
		 <link rel="stylesheet" type="text/css" href="{{asset('Bienvenido/css/component.css')}}" />
		 <link rel="stylesheet" type="text/css" href="{{asset('Bienvenido/css/component.css')}}" />
        <script src="{{asset('Bienvenido/js/modernizr.custom.js')}}"></script>  
        
		 <link href='https://fonts.googleapis.com/css?family=Material+Icons' rel="stylesheet">

        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

	</head>
	<body onload="zoom()">
		<div class="container">	
			<!-- Codrops top bar -->
 
			<header>
				<h1>Restaurante El Mirador <span>Menú de-opciones -</span></h1>
				<!-- {{ Session::get('rol') }} -->
			</header>
			<div class="main clearfix">
				<nav id="menu" class="nav">					
					<ul>
					@if(Session::get('rol')!="Meseros")
						<li>
							<a href="/home">
								<span class="icon"> 
									 <i class="material-icons" >assignment</i>
									<!-- <img src="Bienvenido/Iconos/baseline-assignment-24px.svg" alt="asdf">> -->
								</span>
								<span>Productos</span>
							</a>
						</li>
					@endif
					@if((Session::get('rol')!="Meseros") && (Session::get('rol')!="Bodeguero"))
						<li>
							<a href="/mesas">
								<span class="icon"> 
									<i class="material-icons" >layers</i>
								</span>
								<span>Mesas</span>
							</a>
						</li>
					@endif
					@if(Session::get('rol')=="Administradores")
						<li>
							<a href="/peoples">
								<span class="icon">
									<i class="material-icons" >people</i>
								</span>
								<span>Personas</span>
							</a>
						</li>
					@endif
					@if((Session::get('rol')!="Meseros")&& (Session::get('rol')!="Bodeguero"))
						<li>
							<a href="/cobrar">
								<span class="icon">
									<i class="material-icons" >attach_money</i>
								</span>
								<span>Caja</span>
							</a>
						</li>
					@endif
					
					@if((Session::get('rol')!="Meseros")&& (Session::get('rol')!="Bodeguero"))
						<li>
							<a href="/reporte">
								<span class="icon">
                                <i class="material-icons" >playlist_add_check</i>
								</span>
								<span>Reportes</span>
							</a>
						</li>
					@endif
					@if((Session::get('rol')=="Meseros")||(Session::get('rol')=="Administradores"))
						<li>
							<a href="/ordenes">
								<span class="icon">
                                <i class="material-icons" >add_shopping_cart</i>
								</span>
								<span>Ordenes</span>
							</a>
						</li> 
					@endif
					</ul>
				</nav>
			</div>
		</div><!-- /container -->
		<script>
			//  The function to change the class
			var changeClass = function (r,className1,className2) {
				var regex = new RegExp("(?:^|\\s+)" + className1 + "(?:\\s+|$)");
				if( regex.test(r.className) ) {
					r.className = r.className.replace(regex,' '+className2+' ');
			    }
			    else{
					r.className = r.className.replace(new RegExp("(?:^|\\s+)" + className2 + "(?:\\s+|$)"),' '+className1+' ');
			    }
			    return r.className;
			};	

			//  Creating our button in JS for smaller screens
			var menuElements = document.getElementById('menu');
			menuElements.insertAdjacentHTML('afterBegin','<button type="button" id="menutoggle" class="navtoogle" aria-hidden="true"><i aria-hidden="true" class="icon-menu"> </i> Menu</button>');

			//  Toggle the class on click to show / hide the menu
			document.getElementById('menutoggle').onclick = function() {
				changeClass(this, 'navtoogle active', 'navtoogle');
			}

			// http://tympanus.net/codrops/2013/05/08/responsive-retina-ready-menu/comment-page-2/#comment-438918
			document.onclick = function(e) {
				var mobileButton = document.getElementById('menutoggle'),
					buttonStyle =  mobileButton.currentStyle ? mobileButton.currentStyle.display : getComputedStyle(mobileButton, null).display;

				if(buttonStyle === 'block' && e.target !== mobileButton && new RegExp(' ' + 'active' + ' ').test(' ' + mobileButton.className + ' ')) {
					changeClass(mobileButton, 'navtoogle active', 'navtoogle');
				}
			}
		</script>
		<script type="text/javascript">
				function zoom() {
					document.body.style.zoom = "90%" 
				}
		</script>
	</body>
</html>
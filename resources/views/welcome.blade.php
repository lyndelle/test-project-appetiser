<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Lyndelle Pangolibay - Test Project</title>

		
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
		<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
        </style>
    </head>
    <body>
        <div id="app" class="flex-center position-ref full-height">
             <div class="container-fluid p-5">
					<div id="appAlert" class="alert d-none"></div>
					<div class="panel-body ">
						<router-view name="personsIndex"></router-view>
						<router-view></router-view>
					</div>
				</div>
            </div>
        </div>
		<!-- Scripts -->
		<script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>

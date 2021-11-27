<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
    <meta name="csrf-token" content="{{ csrf_token() }}">  
    <title>Rapitips</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">  
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">  
    <link rel="icon" type="image/png" href="/dolar.png" />
  </head>
  <body>
    <div id="reportsPage">
        <div class="" id="app">
          <app-nav></app-nav>
          <app id="app-container-root" class="app-container-root"></app>
          <app-footer></app-footer>
        </div>
    </div>    
    <script src="{{ asset('js/app.js') }}"></script>
  </body>
</html>

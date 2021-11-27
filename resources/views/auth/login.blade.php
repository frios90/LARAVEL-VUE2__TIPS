<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Tips</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700"/> 
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">  
</head>
<body class="body-log-in">
  <div class="container tm-mt-big tm-mb-big">
    <div class="row">
      <div class="col-12 mx-auto tm-login-col">
        <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
          <div class="row">
            <div class="col-12 text-center">
              <div class="grid-logo">
                  <div class="grid-logo-div1">
                      <img src="dolar.png" width="50" heght="50" alt="">
                  </div>
                  <div class="grid-logo-div2">
                      <h1 class="tm-site-title mb-0">
                  <span class="title-nav">
                      RAPITIPS
                  </span><br>
                  <span class="subtitle-nav">
                      Gestión de propinas
                  </span>
              </h1>
                  </div>
              </div>     
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-12">
              <form class="tm-login-form" id="access-login">
                <input type="hidden"id="token" value="{{ csrf_token() }}">  
                <div class="form-group">
                  <label for="" class="title-input">Empresa</label>
                  <input type="text" class="form-control form-control-sm rut" id="rut" name="rut" maxlength="12" placeholder="Ingrese rut de la empresa" >
                </div>
                <div class="form-group">
                  <label for="" class="title-input">Usuario</label>
                  <input type="text" class="form-control form-control-sm" id="email" name="email" value=" {{old('email')}} " placeholder="Ingrese su correo de usuario" >
                </div>
                <div class="form-group {{$errors->has('password') ? 'danger' : ''}} ">
                  <label for="" class="title-input">Contraseña</label>
                  <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Ingrese su contraseña">
                </div>
                <div class="text-success">
                  Acceso correcto
                </div>
                <div class="text-error">
                  Acceso denegado
                </div>
                <div class="mt-3">
                  <input type="submit" class="mt-5 btn btn-primary btn-block text-uppercase" value="Ingresar"/>
                </div>              
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <video autoplay loop muted plays-inline id="video_background" preload="auto" />
    <source src="/videos/login.mp4" type="video/mp4" />
  </video/>
  <script src="js/loginjquery.js"></script> 
  <script src="js/bootstrap.js"></script>
  <script src="js/rut-js.js"></script>
  <script>
    $('#rut').Rut({
      on_error: function(){ console.log('rut invalido') },
      format_on: 'keyup'
    });
  </script>
  <script>
   $('#access-login').on('submit', function(event){
            $('#error-login').css('display', 'none')
            event.preventDefault();
            var send = {
                "_token"   : $('#token').val(),
                "rut"      : $('#rut').val(),
                "email"    : $('#email').val(),
                "password" : $('#password').val(),               
            }
            var r = $.ajax({
                data: send,
                type: "POST",
                url: "{{ route('/sing-in') }}",
                        
                success: function (data) { 
                  $('.text-error').css('display', 'none')    
                  $('.text-success').css('display', 'block')                 
                  window.location.replace('/home')
                },
                error: function (data) { 
                  $('.text-error').css('display', 'block')    
                  $('.text-success').css('display', 'none')                                  
                              
                }
            })
        })
  </script>
</body>
</html>
<style class="">
  .help-block{
    color: #f5a623;
  }
  #video_background {
    position: absolute;
    bottom: 0px;
    right: 0px;
    min-width: 100%;
    min-height: 100%;
    width: auto;
    height: auto;
    z-index: -1000;
    overflow: hidden;
  }
  #video_pattern {
    background:#fff;
    position: fixed;
    opacity: 0.8;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 1;
  }
  .title-nav{
    color: #f5a623;
    font-family: Wallpoet;
    font-size: 35px; 
    font-weight: 400; 
    line-height: 26.4px; 
  }
  .subtitle-nav{
    color: white;
    font-family: Audiowide;
    font-size: 12px; 
    line-height: 26.4px; 
  }
  .title-input{
    margin-bottom: 0px!important;
    margin-top: 0px!important;
    font-family: Audiowide;
  }
@font-face {
  font-family: 'Audiowide';
  font-style: normal;
  font-weight: 400;
  src: local('Audiowide'), local('Audiowide-Regular'), url(http://themes.googleusercontent.com/static/fonts/audiowide/v1/8XtYtNKEyyZh481XVWfVOqCWcynf_cDxXwCLxiixG1c.ttf) format('truetype');
}
@font-face {
  font-family: 'Wallpoet';
  font-style: normal;
  font-weight: 400;
  src: local('Wallpoet'), url(http://themes.googleusercontent.com/static/fonts/wallpoet/v4/dZ64SxnEftBP3dI7LTKW3_esZW2xOQ-xsNqO47m55DA.ttf) format('truetype');
}
.text-error {
  color: red;
  display: none;
}
.text-success {
  color: green;
  display: none;
}

</style>

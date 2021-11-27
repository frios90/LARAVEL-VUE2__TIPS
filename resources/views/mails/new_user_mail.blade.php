@extends('mails.mail_master')
@section('content')
    <div class="title">Nuevo Usuario</div>
    <div class="welcome">
        <p>{{ $user['name'] }}</p>
        <p>Bienvenido/a a Rapitips, nuestra comunidad te da la más cordial bienvenida.</p>
        <p>Se han registrado los siguientes datos, con los cuales podrá tener acceso a su panel de gestión de propinas.</p>
        <hr>
        <h3>Datos de la empresa</h3>
        <table>
            <tbody>
                <tr>
                    <td>Nombre</td>
                    <td>{{ $user['company_name'] }}</td>
                </tr>
                <tr>
                    <td>Rut</td>
                    <td>{{ $user['company_rut'] }}</td>
                </tr>
                <tr>
                    <td>Dirección</td>
                    <td>{{ $user['company_address'] }}</td>
                </tr>
                <tr>
                    <td>Licencia</td>
                    <td>{{ $user['company_license'] }}</td>
                </tr>
                <tr>
                    <td>Detalle cantidad de staff</td>
                    <td>{{ $user['company_qty_staff'] }}</td>
                </tr>
                <tr>
                    <td>Detalle cantidad de usuarios</td>
                    <td>{{ $user['company_qty_user'] }}</td>
                </tr>
                <tr>
                    <td>Detalle cantidad de trabajos al mes</td>
                    <td>{{ $user['company_qty_work_month'] }}</td>
                </tr>
                <tr>
                    <td>Valor mensual</td>
                    <td>{{ $user['company_value'] }}</td>
                </tr>
            </tbody>
        </table>  
        <hr>
        <h3>Datos del usuario</h3>
        <table>
            <tbody>
                <tr>
                    <td>Nombre</td>
                    <td>{{ $user['name'] }}</td>
                </tr>
                <tr>
                    <td>Rut</td>
                    <td>{{ $user['rut'] }}</td>
                </tr>
                <tr>
                    <td>Dirección</td>
                    <td>{{ $user['address'] }}</td>
                </tr>
                <tr>
                    <td>Teléfono</td>
                    <td>{{ $user['phone'] }}</td>
                </tr>
                <tr>
                    <td>Correo</td>
                    <td>{{ $user['email'] }}</td>
                </tr>
            </tbody>
        </table>  
        <hr>
        <h3>Datos del accesso</h3>
        <table>
            <tbody>
                <tr>
                    <td>Rut de empresa</td>
                    <td>{{ $user['company_rut'] }}</td>
                </tr>
                <tr>
                    <td>Usuario</td>
                    <td>{{ $user['email'] }}</td>
                </tr>
                <tr>
                    <td>Contraseña</td>
                    <td>{{ $user['password'] }}</td>
                </tr>
              
            </tbody>
        </table>
        <p>
            Para ingresar al panel de gestión ingresa has click el el siguiente link: 
            <a href="https://gestion.rapitips.cl">
                RAPITIPS
            </a>
        </p>  
        <hr>
        
      
       
    </div>
    <div>     

    </div>
@endsection

    
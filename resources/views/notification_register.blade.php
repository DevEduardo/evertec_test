<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Llamado de emergencia</title>
</head>
<body>
    <p>Hola! Se ha generado una cuenta de usuario en YourStore.</p>
    <p>Gracias por preferirnos</p>
    <p>A continuacion los datos para ingresar a nuestra aplicaion</p>
    <ul>
        <li>Correo: {{ $data['email'] }}</li>
        <li>Clave de acceso: {{ $data['pass'] }}</li>
    </ul>
</body>
</html>
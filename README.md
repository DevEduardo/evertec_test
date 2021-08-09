<p align="center">YourStore</p>

## Configuración del proyecto

Todos los comando fueron ejecutandos en un ambiente linux

Una vez clonado el repositorio dirigirce a la carpeta root del proyecto
```
cd evertec_test 
```
## Configuracion de variables de entorno
### Editamos el archivo .env
Copiamos el formato del archivo .env.example
```
cp .env.example .env
```
Agregamos los datos de la conexion a la pasarela de pago placetoplay y las credenciales de la base de datos
```
PLACETOPAY_LOGIN
PLACETOPAY_TRANKEY
PLACETOPAY_URL
```
### Creacion de los contenedores docker
Dentro de la carpeta root del proyecto ejecutamos el siguiente comando
```
./vendor/bin/sail up
```
Este comando sera el encargado de servicios necesarios para el correcto funcionamiento de la app.
Es recomendable generar un alias de la sigiente manera
```
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```
Quedando el comando de la siguiente manera
```
sail up
```
### Creacion de la base de datos
Una ves culmida el preceso de creacion de los servicos procederemos a ejecutar las migraciones con el siguiente comando
```
sail artisan migrate
```
### Instalacion de los componentes del frontend
Para instalar los modulos necesarios para front ejecutaremos los siguientes comandos
```
sail npm install
```
Una vez culmida el proceso realizamos la compilacion del lo modulos
```
sail npm run dev
```

### Al momento de generar una venta el sistema le envia un correo al cliente con los datos de acceso al sistema


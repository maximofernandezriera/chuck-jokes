# Chuck Jokes (CakePHP 5 + SQLite)

Proyecto educativo para DAW: aplicación mínima en CakePHP 5 que obtiene un chiste aleatorio de la API pública de Chuck Norris y permite guardarlo en una base de datos SQLite.

## Índice
- Requisitos previos
- Crear el proyecto
- Estructura básica de una app CakePHP
- Configuración de base de datos (SQLite)
- Migraciones: crear la tabla `jokes`
- Modelos y entidades (ORM)
- Controlador `JokesController` paso a paso
- Vistas y formularios
- Rutas
- Ejecutar el servidor de desarrollo
- Probar la aplicación
- Consultar la base de datos con `sqlite3`
- Problemas frecuentes y soluciones
- Siguientes pasos propuestos

## Requisitos previos
- PHP 8.1+ (recomendado 8.2/8.3)
- Composer 2.x
- Extensión pdo_sqlite habilitada (viene por defecto en la mayoría de instalaciones)
- Conocimientos básicos de MVC y PHP orientado a objetos

## Crear el proyecto
```bash
cd /home/maximo/repos
composer create-project cakephp/app:^5.0 chuck-jokes
```
Esto crea la aplicación base de CakePHP en `chuck-jokes/` con dependencias y estructura estándar.

## Estructura básica de una app CakePHP
- `config/`: configuración de la app y rutas
- `src/`: código fuente PHP
  - `Controller/`: controladores (lógica de peticiones)
  - `Model/`: capa de acceso a datos (ORM)
  - `View/`: vistas y helpers
- `templates/`: plantillas de vistas
- `webroot/`: punto de entrada público (document root del servidor)
- `tmp/`: cachés, sesiones y, en este proyecto, el archivo SQLite

## Configuración de base de datos (SQLite)
Edita `config/app_local.php` para usar SQLite:
```php
'Datasources' => [
    'default' => [
        'driver' => Cake\Database\Driver\Sqlite::class,
        'database' => '/home/maximo/repos/chuck-jokes/tmp/database.sqlite',
        'url' => env('DATABASE_URL', null),
    ],
],
```
Crea el fichero de base de datos y directorio si no existen:
```bash
mkdir -p /home/maximo/repos/chuck-jokes/tmp
touch /home/maximo/repos/chuck-jokes/tmp/database.sqlite
```

¿Por qué SQLite? Para desarrollo/local es muy cómodo: un solo archivo, cero configuración de servidor de BD.

## Migraciones: crear la tabla `jokes`
Usamos el plugin Migrations (Phinx) para versionar el esquema:
```bash
cd /home/maximo/repos/chuck-jokes
php bin/cake.php bake migration CreateJokes setup:string[255] punchline:string[255] created modified
php bin/cake.php migrations migrate
```
Esto genera y aplica una migración que crea la tabla `jokes` con columnas `setup`, `punchline`, `created`, `modified`.

## Modelos y entidades (ORM)
Genera la tabla y entidad con Bake:
```bash
php bin/cake.php bake model Jokes --no-test
```
- `src/Model/Table/JokesTable.php`: reglas, asociaciones y behaviors.
- `src/Model/Entity/Joke.php`: qué campos son “asignables” y tipos.

Ajuste importante en validación para permitir `punchline` vacío:
```php
$validator
    ->scalar('punchline')
    ->maxLength('punchline', 255)
    ->allowEmptyString('punchline');
```

## Controlador `JokesController` paso a paso
Creamos `src/Controller/JokesController.php` con una acción `random`:
- Realiza una petición GET a `https://api.chucknorris.io/jokes/random`.
- Muestra el chiste (campo `value`).
- Si el usuario pulsa “Guardar”, se realiza POST y se inserta en la tabla.

Puntos clave:
- En CakePHP 5 usa `fetchTable('Jokes')` (no `loadModel`).
- Recortamos a 255 caracteres para cumplir la longitud.
- Mostramos mensajes flash de éxito/error.

## Vistas y formularios
Plantilla `templates/Jokes/random.php`:
- Presenta el chiste en un `<blockquote>`.
- Formulario con campos ocultos `setup` y `punchline` y botón de envío.
- Al enviar, el controlador valida y guarda.

## Rutas
En `config/routes.php` añade:
```php
$builder->connect('/jokes/random', ['controller' => 'Jokes', 'action' => 'random']);
```
Así mapeamos la URL `/jokes/random` a la acción del controlador.

## Ejecutar el servidor de desarrollo
Asegúrate de lanzarlo desde el proyecto correcto:
```bash
php -S 0.0.0.0:8765 -t /home/maximo/repos/chuck-jokes/webroot
```
Si el puerto está ocupado, usa otro (por ejemplo 8770), o detén el proceso que lo usa:
```bash
lsof -i :8765 -sTCP:LISTEN -n -P
kill <PID>
```

## Probar la aplicación
1. Abre `http://localhost:8765/jokes/random`.
2. Deberías ver un chiste aleatorio.
3. Pulsa “Guardar en la base de datos”.
4. Verás un mensaje de éxito; si no, revisa validación y logs.

## Consultar la base de datos con `sqlite3`
```bash
sqlite3 /home/maximo/repos/chuck-jokes/tmp/database.sqlite \
  "SELECT id, substr(setup,1,80) AS setup, created FROM jokes ORDER BY id DESC LIMIT 10;"
```
Comprobar tablas:
```bash
sqlite3 /home/maximo/repos/chuck-jokes/tmp/database.sqlite ".tables"
```

## Problemas frecuentes y soluciones
- MissingController: asegúrate de servir desde `webroot` del proyecto correcto y de que exista `src/Controller/JokesController.php` con `namespace App\Controller;`.
- Puerto ocupado: cambia de puerto o mata el proceso.
- Error al guardar: verifica validación en `JokesTable`, longitudes (255) y que `punchline` permita vacío.
- “default datasource not found” en scripts sueltos: ejecuta dentro de la app (carga `config/bootstrap.php`) o usa comandos `bin/cake.php`.
- Cachés desactualizadas: limpia con `php bin/cake.php cache clear_all` y `php bin/cake.php schema_cache clear`.

## Siguientes pasos propuestos
- Listar chistes guardados (`index`) y ver detalle (`view`).
- Añadir paginación y borrado.
- Guardar también el `id` de la API para evitar duplicados.
- Tests con PHPUnit para el controlador y el modelo.
- Dockerizar el proyecto.

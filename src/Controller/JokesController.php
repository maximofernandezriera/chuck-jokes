<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Client;
use Cake\Http\Exception\BadRequestException;

/**
 * Controlador de Chistes de Chuck Norris
 *
 * Este controlador maneja todas las operaciones relacionadas con los chistes
 * de Chuck Norris. Se conecta con la API externa de chucknorris.io para
 * obtener chistes aleatorios y permite guardarlos en la base de datos local.
 *
 * Funcionalidades principales:
 * - Obtención de chistes aleatorios desde API externa
 * - Guardado de chistes en base de datos local
 * - Validación y sanitización de datos de entrada
 * - Manejo de errores de conexión con la API
 *
 * @see https://api.chucknorris.io/ API de chistes de Chuck Norris
 */
class JokesController extends AppController
{
    /**
     * Método de inicialización del controlador de chistes.
     *
     * Configura el comportamiento específico para este controlador:
     * - Establece el layout por defecto para las vistas
     * - Restringe los métodos HTTP permitidos a GET y POST por seguridad
     *
     * @return void
     */
    public function initialize(): void
    {
        // Hereda la configuración base del AppController
        parent::initialize();
        
        // Establece el layout por defecto para todas las vistas de este controlador
        $this->viewBuilder()->setLayout('default');
        
        // Restringe los métodos HTTP permitidos solo a GET y POST
        // Esto mejora la seguridad al rechazar otros métodos como PUT, DELETE, etc.
        $this->request->allowMethod(['get', 'post']);
    }

    /**
     * Acción para obtener y mostrar un chiste aleatorio.
     *
     * Esta acción realiza las siguientes operaciones:
     * 1. Consume la API de chucknorris.io para obtener un chiste aleatorio
     * 2. Prepara una entidad Joke para mostrar en el formulario
     * 3. Si se envía el formulario (POST), guarda el chiste en la base de datos
     * 4. Maneja errores de conexión y validación
     *
     * Métodos HTTP soportados: GET (mostrar), POST (guardar)
     *
     * @return \Cake\Http\Response|null Redirección en caso de guardado exitoso
     * @throws \Cake\Http\Exception\BadRequestException Si falla la conexión con la API
     */
    public function random()
    {
        // Crea un cliente HTTP para consumir la API externa
        $client = new Client();
        
        // Realiza petición GET a la API de chistes de Chuck Norris
        $response = $client->get('https://api.chucknorris.io/jokes/random');
        
        // Verifica si la respuesta de la API fue exitosa
        if (!$response->isOk()) {
            throw new BadRequestException('No se pudo obtener un chiste.');
        }
        
        // Extrae los datos JSON de la respuesta
        $data = $response->getJson();
        // Obtiene el texto del chiste de forma segura
        $jokeText = (string)($data['value'] ?? '');

        // Obtiene la tabla Jokes para operaciones de base de datos
        $jokesTable = $this->fetchTable('Jokes');
        // Crea una nueva entidad vacía para el formulario
        $joke = $jokesTable->newEmptyEntity();
        // Pre-llena el campo setup con el chiste obtenido de la API
        $joke->setup = $jokeText;
        // Inicializa el punchline como vacío (puede ser editado por el usuario)
        $joke->punchline = '';

        // Procesa el formulario si se envió por POST
        if ($this->request->is('post')) {
            // Obtiene los datos enviados por el formulario
            $data = $this->request->getData();
            
            // Sanitiza y limita la longitud de los campos para evitar overflow
            // Limita setup a 255 caracteres máximo
            $data['setup'] = mb_substr((string)($data['setup'] ?? ''), 0, 255);
            // Limita punchline a 255 caracteres máximo
            $data['punchline'] = mb_substr((string)($data['punchline'] ?? ''), 0, 255);
            
            // Aplica los datos del formulario a la entidad
            $joke = $jokesTable->patchEntity($joke, $data);
            
            // Intenta guardar el chiste si no hay errores de validación
            if (!$joke->getErrors() && $jokesTable->save($joke)) {
                // Muestra mensaje de éxito al usuario
                $this->Flash->success('Chiste guardado.');
                // Redirecciona a la misma acción para mostrar un nuevo chiste
                return $this->redirect(['action' => 'random']);
            }
            
            // Muestra mensaje de error si no se pudo guardar
            $this->Flash->error('No se pudo guardar el chiste.');
        }

        // Pasa las variables a la vista para su renderizado
        $this->set(compact('jokeText', 'joke'));
    }
}



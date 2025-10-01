<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.3.4
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Controlador de Manejo de Errores
 *
 * Este controlador especializado se encarga de manejar y renderizar las respuestas
 * de error de la aplicación. Es utilizado automáticamente por el ExceptionRenderer
 * de CakePHP cuando ocurren excepciones o errores durante la ejecución.
 *
 * Funcionalidades principales:
 * - Renderizado de páginas de error personalizadas (404, 500, etc.)
 * - Configuración específica para el manejo de errores
 * - Evita la herencia completa de AppController para mayor seguridad
 *
 * @see \Cake\Error\ExceptionRenderer
 */
class ErrorController extends AppController
{
    /**
     * Método de inicialización del controlador de errores.
     *
     * Intencionalmente NO llama a parent::initialize() para evitar cargar
     * componentes o configuraciones que podrían causar errores adicionales
     * durante el manejo de errores. Esto garantiza un entorno limpio y seguro
     * para el renderizado de páginas de error.
     *
     * @return void
     */
    public function initialize(): void
    {
        // Intencionalmente vacío - no se llama a parent::initialize()
        // para evitar posibles errores en cascada durante el manejo de errores
    }

    /**
     * Callback ejecutado antes de filtrar la petición.
     *
     * Se ejecuta antes de que se procese la acción del controlador.
     * Actualmente vacío, pero disponible para configuraciones específicas
     * de manejo de errores si fuera necesario.
     *
     * @param \Cake\Event\EventInterface<\Cake\Controller\Controller> $event Evento de CakePHP
     * @return void
     */
    public function beforeFilter(EventInterface $event): void
    {
        // Método vacío - disponible para configuraciones específicas de errores
    }

    /**
     * Callback ejecutado antes de renderizar la vista.
     *
     * Configura el path de las plantillas para que apunten al directorio 'Error',
     * donde se encuentran las vistas personalizadas para diferentes tipos de error
     * (error400.php, error500.php, etc.).
     *
     * @param \Cake\Event\EventInterface<\Cake\Controller\Controller> $event Evento de CakePHP
     * @return void
     */
    public function beforeRender(EventInterface $event): void
    {
        // Llama al método padre para mantener el comportamiento base
        parent::beforeRender($event);

        // Configura el directorio de plantillas para usar las vistas de error
        // Las plantillas se buscarán en templates/Error/
        $this->viewBuilder()->setTemplatePath('Error');
    }

    /**
     * Callback ejecutado después de filtrar la respuesta.
     *
     * Se ejecuta después de que se haya procesado la acción y renderizado la vista.
     * Actualmente vacío, pero disponible para limpieza o logging específico
     * de errores si fuera necesario.
     *
     * @param \Cake\Event\EventInterface<\Cake\Controller\Controller> $event Evento de CakePHP
     * @return void
     */
    public function afterFilter(EventInterface $event): void
    {
        // Método vacío - disponible para limpieza post-renderizado de errores
    }
}

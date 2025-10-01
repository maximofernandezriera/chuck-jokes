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
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;

/**
 * Controlador Base de la Aplicación
 *
 * Este controlador sirve como clase base para todos los controladores de la aplicación.
 * Contiene la configuración común y los métodos que serán heredados por todos los
 * controladores específicos (JokesController, PagesController, etc.).
 *
 * Funcionalidades principales:
 * - Configuración inicial común para todos los controladores
 * - Carga de componentes compartidos (Flash para mensajes)
 * - Punto central para configuraciones de seguridad y autenticación
 *
 * @link https://book.cakephp.org/5/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Método de inicialización del controlador.
     *
     * Se ejecuta automáticamente cuando se instancia cualquier controlador que herede
     * de AppController. Aquí se configuran los componentes y configuraciones comunes
     * que necesitan todos los controladores de la aplicación.
     *
     * Componentes cargados:
     * - Flash: Para mostrar mensajes de éxito, error e información al usuario
     *
     * @return void
     */
    public function initialize(): void
    {
        // Llama al método initialize del controlador padre (Controller)
        parent::initialize();

        // Carga el componente Flash para mostrar mensajes al usuario
        // Permite mostrar notificaciones de éxito, error, advertencia, etc.
        $this->loadComponent('Flash');

        /*
         * Componente de protección de formularios (comentado por defecto)
         * Proporciona protección CSRF y otras medidas de seguridad para formularios
         * Descomenta la siguiente línea para habilitar la protección recomendada
         * @see https://book.cakephp.org/5/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }
}

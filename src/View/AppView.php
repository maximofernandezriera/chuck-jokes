<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\View;

use Cake\View\View;

/**
 * Vista Base de la Aplicación (AppView)
 *
 * Esta clase sirve como vista base para toda la aplicación de chistes de Chuck Norris.
 * Extiende la clase View de CakePHP y proporciona configuraciones comunes que serán
 * heredadas por todas las vistas específicas de la aplicación.
 *
 * Responsabilidades principales:
 * - Configuración común de helpers para todas las vistas
 * - Definición de comportamientos compartidos de renderizado
 * - Punto central para personalizaciones globales de vista
 * - Configuración de elementos y layouts por defecto
 *
 * Casos de uso típicos:
 * - Cargar helpers comunes (Html, Form, Flash, etc.)
 * - Configurar variables globales para todas las vistas
 * - Definir métodos auxiliares reutilizables
 * - Establecer configuraciones de internacionalización
 *
 * @link https://book.cakephp.org/5/en/views.html#the-app-view
 */
class AppView extends View
{
    /**
     * Método de inicialización de la vista.
     *
     * Este método se ejecuta automáticamente cuando se instancia cualquier vista
     * que herede de AppView. Es el lugar ideal para cargar helpers comunes,
     * configurar variables globales y establecer comportamientos compartidos.
     *
     * Configuraciones típicas que se pueden agregar:
     * - Helpers comunes: Html, Form, Flash, Url, etc.
     * - Variables globales para todas las vistas
     * - Configuraciones de tema o layout
     * - Helpers personalizados de la aplicación
     *
     * Ejemplos de uso:
     * ```php
     * $this->addHelper('Html');           // Helper HTML básico
     * $this->addHelper('Form');           // Helper para formularios
     * $this->addHelper('Flash');          // Helper para mensajes flash
     * $this->addHelper('Url');            // Helper para URLs
     * ```
     *
     * Nota: Actualmente vacío, pero listo para futuras configuraciones
     * cuando la aplicación requiera helpers o configuraciones adicionales.
     *
     * @return void
     */
    public function initialize(): void
    {
        // Método intencionalmente vacío
        // Aquí se pueden agregar helpers y configuraciones comunes cuando sea necesario
        // Por ejemplo:
        // $this->addHelper('Html');
        // $this->addHelper('Form');
        // $this->addHelper('Flash');
    }
}

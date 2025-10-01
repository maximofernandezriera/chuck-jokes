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

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;

/**
 * Controlador de Páginas Estáticas
 *
 * Este controlador se encarga de renderizar contenido estático de la aplicación.
 * Permite mostrar páginas que no requieren lógica compleja de negocio, como
 * páginas de información, términos de uso, políticas de privacidad, etc.
 *
 * Funcionalidades principales:
 * - Renderizado de vistas estáticas desde templates/Pages/
 * - Manejo seguro de rutas para evitar directory traversal
 * - Soporte para páginas anidadas (page/subpage)
 * - Manejo de errores 404 para plantillas inexistentes
 *
 * @link https://book.cakephp.org/5/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
    /**
     * Muestra una vista estática basada en la ruta proporcionada.
     *
     * Este método permite renderizar páginas estáticas de forma dinámica
     * basándose en los segmentos de la URL. Por ejemplo:
     * - /pages/about renderizará templates/Pages/about.php
     * - /pages/help/faq renderizará templates/Pages/help/faq.php
     *
     * Características de seguridad:
     * - Previene directory traversal attacks (../, ./)
     * - Valida que las plantillas existan antes de renderizar
     * - Maneja errores 404 de forma apropiada según el modo debug
     *
     * @param string ...$path Segmentos de ruta que definen la plantilla a renderizar
     * @return \Cake\Http\Response|null Respuesta HTTP o null si se renderiza normalmente
     * @throws \Cake\Http\Exception\ForbiddenException Cuando se detecta intento de directory traversal
     * @throws \Cake\View\Exception\MissingTemplateException Cuando no se encuentra la plantilla (modo debug)
     * @throws \Cake\Http\Exception\NotFoundException Cuando no se encuentra la plantilla (modo producción)
     */
    public function display(string ...$path): ?Response
    {
        // Si no se proporciona ruta, redirecciona a la página principal
        if (!$path) {
            return $this->redirect('/');
        }
        
        // Validación de seguridad: previene directory traversal attacks
        // Rechaza rutas que contengan '..' o '.' para evitar acceso a directorios padre
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        
        // Inicializa variables para la vista
        $page = $subpage = null;

        // Extrae el primer segmento como página principal
        if (!empty($path[0])) {
            $page = $path[0];
        }
        
        // Extrae el segundo segmento como subpágina (si existe)
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        
        // Pasa las variables a la vista para su uso en las plantillas
        $this->set(compact('page', 'subpage'));

        try {
            // Intenta renderizar la plantilla basada en la ruta completa
            // Une todos los segmentos con '/' para formar la ruta de la plantilla
            return $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            // Manejo de errores cuando no se encuentra la plantilla
            if (Configure::read('debug')) {
                // En modo debug, muestra la excepción completa para facilitar desarrollo
                throw $exception;
            }
            // En modo producción, muestra un error 404 genérico por seguridad
            throw new NotFoundException();
        }
    }
}

<?php
/**
 * Plantilla para mostrar chistes aleatorios de Chuck Norris
 * 
 * Esta vista se encarga de mostrar un chiste aleatorio obtenido de la API
 * de chucknorris.io y proporciona un formulario para guardarlo en la base
 * de datos local si el usuario lo desea.
 * 
 * Funcionalidades:
 * - Muestra el chiste en un formato atractivo (blockquote)
 * - Proporciona formulario para guardar el chiste
 * - Utiliza campos ocultos para pre-llenar los datos
 * - Aplica escape HTML para seguridad
 * 
 * Variables disponibles desde el controlador:
 * @var \App\View\AppView $this Instancia de la vista de la aplicación
 * @var string $jokeText Texto del chiste obtenido de la API externa
 * @var \App\Model\Entity\Joke $joke Entidad Joke preparada para el formulario
 */
?>

<!-- Contenedor principal para la sección de chistes aleatorios -->
<div class="jokes random">
    <!-- Título principal de la página -->
    <h1>Chuck Norris - Chiste aleatorio</h1>
    
    <!-- 
        Muestra el chiste en un blockquote para darle formato destacado
        h() aplica escape HTML para prevenir ataques XSS
    -->
    <blockquote><?= h($jokeText) ?></blockquote>

    <!-- 
        Formulario para guardar el chiste en la base de datos
        Form->create() genera un formulario que se enviará por POST al mismo controlador
    -->
    <?= $this->Form->create($joke) ?>
    
    <!-- 
        Campo oculto que contiene el texto del chiste
        Se pre-llena con el valor obtenido de la API
    -->
    <?= $this->Form->hidden('setup', ['value' => $jokeText]) ?>
    
    <!-- 
        Campo oculto para punchline (remate del chiste)
        Se inicializa vacío, permitiendo que el usuario lo edite si lo desea
    -->
    <?= $this->Form->hidden('punchline', ['value' => '']) ?>
    
    <!-- 
        Botón de envío del formulario
        Al hacer clic, enviará los datos al controlador para guardar en BD
    -->
    <?= $this->Form->button('Guardar en la base de datos') ?>
    
    <!-- Cierra el formulario correctamente -->
    <?= $this->Form->end() ?>
</div>



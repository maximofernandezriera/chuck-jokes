<?php
/** @var \App\View\AppView $this */
/** @var string $jokeText */
/** @var \App\Model\Entity\Joke $joke */
?>
<div class="jokes random">
    <h1>Chuck Norris - Chiste aleatorio</h1>
    <blockquote><?= h($jokeText) ?></blockquote>

    <?= $this->Form->create($joke) ?>
    <?= $this->Form->hidden('setup', ['value' => $jokeText]) ?>
    <?= $this->Form->hidden('punchline', ['value' => '']) ?>
    <?= $this->Form->button('Guardar en la base de datos') ?>
    <?= $this->Form->end() ?>
</div>



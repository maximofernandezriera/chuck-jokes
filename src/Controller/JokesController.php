<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Client;
use Cake\Http\Exception\BadRequestException;

class JokesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('default');
        $this->request->allowMethod(['get', 'post']);
    }

    public function random()
    {
        $client = new Client();
        $response = $client->get('https://api.chucknorris.io/jokes/random');
        if (!$response->isOk()) {
            throw new BadRequestException('No se pudo obtener un chiste.');
        }
        $data = $response->getJson();
        $jokeText = (string)($data['value'] ?? '');

        $jokesTable = $this->fetchTable('Jokes');
        $joke = $jokesTable->newEmptyEntity();
        $joke->setup = $jokeText;
        $joke->punchline = '';

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['setup'] = mb_substr((string)($data['setup'] ?? ''), 0, 255);
            $data['punchline'] = mb_substr((string)($data['punchline'] ?? ''), 0, 255);
            $joke = $jokesTable->patchEntity($joke, $data);
            if (!$joke->getErrors() && $jokesTable->save($joke)) {
                $this->Flash->success('Chiste guardado.');
                return $this->redirect(['action' => 'random']);
            }
            $this->Flash->error('No se pudo guardar el chiste.');
        }

        $this->set(compact('jokeText', 'joke'));
    }
}



<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tabla de Chistes (JokesTable)
 *
 * Esta clase representa la tabla de chistes en la base de datos y maneja
 * todas las operaciones relacionadas con el almacenamiento, validación y
 * recuperación de chistes de Chuck Norris.
 *
 * Responsabilidades principales:
 * - Configuración de la tabla y sus propiedades
 * - Definición de reglas de validación para los datos
 * - Gestión de comportamientos automáticos (timestamps)
 * - Proporcionar métodos para operaciones CRUD
 *
 * Estructura de la tabla:
 * - id: Clave primaria autoincremental
 * - setup: Texto principal del chiste (requerido, máx. 255 caracteres)
 * - punchline: Remate del chiste (opcional, máx. 255 caracteres)
 * - created: Timestamp de creación (automático)
 * - modified: Timestamp de modificación (automático)
 *
 * @method \App\Model\Entity\Joke newEmptyEntity() Crea una nueva entidad vacía
 * @method \App\Model\Entity\Joke newEntity(array $data, array $options = []) Crea entidad con datos
 * @method array<\App\Model\Entity\Joke> newEntities(array $data, array $options = []) Crea múltiples entidades
 * @method \App\Model\Entity\Joke get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args) Obtiene entidad por clave primaria
 * @method \App\Model\Entity\Joke findOrCreate($search, ?callable $callback = null, array $options = []) Busca o crea entidad
 * @method \App\Model\Entity\Joke patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = []) Actualiza entidad con datos
 * @method array<\App\Model\Entity\Joke> patchEntities(iterable $entities, array $data, array $options = []) Actualiza múltiples entidades
 * @method \App\Model\Entity\Joke|false save(\Cake\Datasource\EntityInterface $entity, array $options = []) Guarda entidad
 * @method \App\Model\Entity\Joke saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = []) Guarda entidad o lanza excepción
 * @method iterable<\App\Model\Entity\Joke>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Joke>|false saveMany(iterable $entities, array $options = []) Guarda múltiples entidades
 * @method iterable<\App\Model\Entity\Joke>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Joke> saveManyOrFail(iterable $entities, array $options = []) Guarda múltiples entidades o falla
 * @method iterable<\App\Model\Entity\Joke>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Joke>|false deleteMany(iterable $entities, array $options = []) Elimina múltiples entidades
 * @method iterable<\App\Model\Entity\Joke>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Joke> deleteManyOrFail(iterable $entities, array $options = []) Elimina múltiples entidades o falla
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior Comportamiento para manejo automático de timestamps
 */
class JokesTable extends Table
{
    /**
     * Método de inicialización de la tabla.
     *
     * Configura las propiedades básicas de la tabla y carga los comportamientos
     * necesarios. Este método se ejecuta automáticamente cuando se instancia
     * la tabla por primera vez.
     *
     * Configuraciones aplicadas:
     * - Nombre de la tabla en base de datos: 'jokes'
     * - Campo de visualización por defecto: 'setup' (usado en selects)
     * - Clave primaria: 'id'
     * - Comportamiento Timestamp: Manejo automático de created/modified
     *
     * @param array<string, mixed> $config Configuración para la tabla
     * @return void
     */
    public function initialize(array $config): void
    {
        // Llama al método de inicialización del padre
        parent::initialize($config);

        // Establece el nombre de la tabla en la base de datos
        $this->setTable('jokes');
        
        // Define el campo que se usará para mostrar registros en listas/selects
        // En este caso, el texto principal del chiste (setup)
        $this->setDisplayField('setup');
        
        // Establece la clave primaria de la tabla
        $this->setPrimaryKey('id');

        // Agrega el comportamiento Timestamp para manejo automático de fechas
        // Esto actualiza automáticamente los campos 'created' y 'modified'
        $this->addBehavior('Timestamp');
    }

    /**
     * Reglas de validación por defecto.
     *
     * Define las reglas que se aplicarán automáticamente cuando se validen
     * entidades de esta tabla. Estas validaciones se ejecutan antes de
     * guardar datos en la base de datos.
     *
     * Validaciones para 'setup' (texto principal):
     * - Debe ser un valor escalar (string)
     * - Longitud máxima de 255 caracteres
     * - Requerido al crear nuevos registros
     * - No puede estar vacío
     *
     * Validaciones para 'punchline' (remate):
     * - Debe ser un valor escalar (string)
     * - Longitud máxima de 255 caracteres
     * - Puede estar vacío (opcional)
     *
     * @param \Cake\Validation\Validator $validator Instancia del validador
     * @return \Cake\Validation\Validator Validador configurado
     */
    public function validationDefault(Validator $validator): Validator
    {
        // Validaciones para el campo 'setup' (texto principal del chiste)
        $validator
            ->scalar('setup')                           // Debe ser un string
            ->maxLength('setup', 255)                   // Máximo 255 caracteres
            ->requirePresence('setup', 'create')        // Requerido al crear
            ->notEmptyString('setup');                  // No puede estar vacío

        // Validaciones para el campo 'punchline' (remate del chiste)
        $validator
            ->scalar('punchline')                       // Debe ser un string
            ->maxLength('punchline', 255)               // Máximo 255 caracteres
            ->allowEmptyString('punchline');            // Puede estar vacío

        return $validator;
    }
}

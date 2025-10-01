<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Entidad Joke (Chiste)
 *
 * Esta entidad representa un chiste de Chuck Norris en la base de datos.
 * Encapsula los datos y comportamientos relacionados con un chiste individual,
 * incluyendo su contenido (setup y punchline) y metadatos de auditoría.
 *
 * Estructura de datos:
 * - setup: El texto principal del chiste (obtenido de la API o editado por el usuario)
 * - punchline: El remate o conclusión del chiste (opcional, puede estar vacío)
 * - created/modified: Timestamps automáticos para auditoría
 *
 * Casos de uso:
 * - Almacenar chistes obtenidos de la API de chucknorris.io
 * - Permitir edición de chistes por parte del usuario
 * - Mantener historial de creación y modificación
 *
 * @property int $id Identificador único del chiste
 * @property string $setup Texto principal del chiste (máximo 255 caracteres)
 * @property string $punchline Remate del chiste (máximo 255 caracteres, puede estar vacío)
 * @property \Cake\I18n\DateTime $created Fecha y hora de creación del registro
 * @property \Cake\I18n\DateTime $modified Fecha y hora de última modificación
 */
class Joke extends Entity
{
    /**
     * Campos que pueden ser asignados masivamente usando newEntity() o patchEntity().
     *
     * Esta configuración define qué campos pueden ser modificados directamente
     * desde formularios o datos de entrada, proporcionando una capa de seguridad
     * contra asignación masiva no autorizada.
     *
     * Campos accesibles:
     * - setup: Permite editar el texto principal del chiste
     * - punchline: Permite editar el remate del chiste
     * - created: Permite establecer fecha de creación (generalmente automático)
     * - modified: Permite establecer fecha de modificación (generalmente automático)
     *
     * Nota de seguridad: El campo 'id' NO está incluido intencionalmente
     * para prevenir modificación del identificador único por parte del usuario.
     *
     * @var array<string, bool> Array asociativo de campos y su accesibilidad
     */
    protected array $_accessible = [
        'setup' => true,        // Texto principal del chiste - editable
        'punchline' => true,    // Remate del chiste - editable
        'created' => true,      // Fecha de creación - normalmente automática
        'modified' => true,     // Fecha de modificación - normalmente automática
    ];
}

<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2014, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace lithium\data\model;

use Exception;
use Countable;
use lithium\util\Set;
use lithium\core\Libraries;
use lithium\core\ConfigException;
use lithium\core\ClassNotFoundException;

/**
 * The `Relationship` class encapsulates the data and functionality necessary to link two model
 * classes together.
 */
class Relationship extends \lithium\core\Object {

	/**
	 * Class dependencies.
	 *
	 * @var array
	 */
	protected $_classes = array(
		'entity'      => 'lithium\data\Entity'
	);

	/**
	 * A relationship linking type defined by one document or record (or multiple) being embedded
	 * within another.
	 */
	const LINK_EMBEDDED = 'embedded';

	/**
	 * The reciprocal of `LINK_EMBEDDED`, this defines a linking type wherein an embedded document
	 * references the document that contains it.
	 */
	const LINK_CONTAINED = 'contained';

	/**
	 * A one-to-one or many-to-one relationship in which a key contains an ID value linking to
	 * another document or record.
	 */
	const LINK_KEY = 'key';

	/**
	 * A many-to-many relationship in which a key contains an embedded array of IDs linking to other
	 * records or documents.
	 */
	const LINK_KEY_LIST = 'keylist';

	/**
	 * A relationship defined by a database-native reference mechanism, linking a key to an
	 * arbitrary record or document in another data collection or entirely separate database.
	 */
	const LINK_REF = 'ref';

	/**
	 * Constructs an object that represents a relationship between two model classes.
	 *
	 * @param array $config The relationship's configuration, which defines how the two models in
	 *        question are bound. The available options are:
	 *        - `'name'` _string_: The name of the relationship in the context of the
	 *          originating model. For example, a `Posts` model might define a relationship to
	 *          a `Users` model like so:
	 *          {{{ public $hasMany = array('Author' => array('to' => 'Users')); }}}
	 *          In this case, the relationship is bound to the `Users` model, but `'Author'` would
	 *          be the relationship name. This is the name with which the relationship is
	 *          referenced in the originating model.
	 *        - `'key'` _mixed_: An array of fields that define the relationship, where the
	 *          keys are fields in the originating model, and the values are fields in the
	 *          target model. If the relationship is not defined by keys, this array should be
	 *          empty.
	 *        - `'type'` _string_: The type of relationship. Should be one of `'belongsTo'`,
	 *          `'hasOne'` or `'hasMany'`.
	 *        - `'from'` _string_: The fully namespaced class name of the model where this
	 *          relationship originates.
	 *        - `'to'` _string_: The fully namespaced class name of the model that this
	 *          relationship targets.
	 *        - `'link'` _string_: A constant specifying how the object bound to the
	 *          originating model is linked to the object bound to the target model. For
	 *          relational databases, the only valid value is `LINK_KEY`, which means a foreign
	 *          key in one object matches another key (usually the primary key) in the other.
	 *          For document-oriented and other non-relational databases, different types of
	 *          linking, including key lists, database reference objects (such as MongoDB's
	 *          `MongoDBRef`), or even embedding.
	 *        - `'fields'` _mixed_: An array of the subset of fields that should be selected
	 *          from the related object(s) by default. If set to `true` (the default), all
	 *          fields are selected.
	 *        - `'fieldName'` _string_: The name of the field used when accessing the related
	 *          data in a result set. For example, in the case of `Posts hasMany Comments`, the
	 *          field name defaults to `'comments'`, so comment data is accessed (assuming
	 *          `$post = Posts::first()`) as `$post->comments`.
	 *        - `'constraints'` _mixed_: A string or array containing additional constraints
	 *          on the relationship query. If a string, can contain a literal SQL fragment or
	 *          other database-native value. If an array, maps fields from the related object
	 *          either to fields elsewhere, or to arbitrary expressions. In either case, _the
	 *          values specified here will be literally interpreted by the database_.
	 *        - `'strategy'` _closure_: An anonymous function used by an instantiating class,
	 *          such as a database object, to provide additional, dynamic configuration, after
	 *          the `Relationship` instance has finished configuring itself.
	 *        - `via` _string_: HABTM specific option with indicate the relation name of the
	 *          middle class
	 */
	public function __construct(array $config = array()) {
		$defaults = array(
			'name'        => null,
			'key'         => array(),
			'type'        => null,
			'to'          => null,
			'from'        => null,
			'link'        => static::LINK_KEY,
			'fields'      => true,
			'fieldName'   => null,
			'constraints' => array(),
			'strategy'    => null,
			'via' => null
		);
		$config += $defaults;

		if (!$config['type'] || !$config['fieldName']) {
			throw new ConfigException("`'type'`, `'fieldName'` and `'from'` options can't be empty.");
		}
		if (!$config['to'] && !$config['name']) {
			throw new ConfigException("`'to'` and `'name'` options can't both be empty.");
		}
		parent::__construct($config);
	}

	/**
	 * Initializes the `Relationship` object by attempting to automatically generate any values
	 * that were not provided in the constructor configuration.
	 */
	protected function _init() {
		parent::_init();
		$config =& $this->_config;

		if (!$config['to']) {
			$assoc = preg_replace("/\\w+$/", "", $config['from']) . $config['name'];
			$config['to'] = Libraries::locate('models', $assoc);
		} elseif (!strpos($config['to'], '\\')) {
			$config['to'] = preg_replace("/\\w+$/", "", $config['from']) . $config['to'];
		}

		if (!$config['key'] || !is_array($config['key'])) {
			$config['key'] = $this->_keys($config['key']);
		}
		if ($config['strategy']) {
			$config = (array) $config['strategy']($this) + $config;
			unset($this->_config['strategy']);
		}
	}

	/**
	 * Returns the named configuration item, or all configuration data, if no parameter is given.
	 *
	 * @param string $key The name of the configuration item to return, or `null` to return all
	 *               items.
	 * @return mixed Returns a single configuration item (mixed), or an array of all items.
	 */
	public function data($key = null) {
		if (!$key) {
			return $this->_config;
		}
		return isset($this->_config[$key]) ? $this->_config[$key] : null;
	}

	/**
	 * Allows relationship configuration items to be queried by name as methods.
	 *
	 * @param string $name The name of the configuration item to query.
	 * @param array $args Unused.
	 * @return mixed Returns the value of the given configuration item.
	 */
	public function __call($name, $args = array()) {
		return $this->data($name);
	}

	/**
	 * Gets a related object (or objects) for the given object connected to it by this relationship.
	 *
	 * @param object $object The object to get the related data for.
	 * @param array $options Additional options to merge into the query to be performed, where
	 *              applicable.
	 * @return object Returns the object(s) for this relationship.
	 */
	public function get($object, array $options = array()) {
		$model = $this->to();
		$link = $this->link();
		$strategies = $this->_strategies();

		if (!isset($strategies[$link]) || !is_callable($strategies[$link])) {
			$msg = "Attempted to get object for invalid relationship link type `{$link}`.";
			throw new ConfigException($msg);
		}
		return $strategies[$link]($object, $this, $options);
	}

	/**
	 * Generates query parameters for a related object (or objects) for the given object
	 * connected to it by this relationship.
	 *
	 * @param object $object The object to get the related data for.
	 * @return object Returns the object(s) for this relationship.
	 */
	public function query($object) {
		$conditions = (array) $this->constraints();

		foreach ($this->key() as $from => $to) {
			if (!isset($object->{$from})) {
				return null;
			}
			$conditions[$to] = $object->{$from};

			if (is_object($conditions[$to]) && $conditions[$to] instanceof Countable) {
				$conditions[$to] = iterator_to_array($conditions[$to]);
			}
		}
		$fields = $this->fields();
		$fields = $fields === true ? null : $fields;
		return compact('conditions', 'fields');
	}

	/**
	 * Build foreign keys from primary keys array.
	 *
	 * @param $primaryKey An array where keys are primary keys and values are
	 *                    the associated values of primary keys.
	 * @return array An array where keys are foreign keys and values are
	 *               the associated values of foreign keys.
	 */
	public function foreignKey($primaryKey) {
		$result = array();
		$entity = $this->_classes['entity'];
		$keys = ($this->type() === 'belongsTo') ? array_flip($this->key()) : $this->key();
		$primaryKey = ($primaryKey instanceof $entity) ? $primaryKey->to('array') : $primaryKey;

		foreach ($keys as $key => $foreignKey) {
			$result[$foreignKey] = $primaryKey[$key];
		}
		return $result;
	}

	/**
	 * Determines if a given method can be called.
	 *
	 * @param string $method Name of the method.
	 * @param boolean $internal Provide `true` to perform check from inside the
	 *                class/object. When `false` checks also for public visibility;
	 *                defaults to `false`.
	 * @return boolean Returns `true` if the method can be called, `false` otherwise.
	 */
	public function respondsTo($method, $internal = false) {
		return is_callable(array($this, $method), true);
	}

	/**
	 * Generates an array of relationship key pairs, where the keys are fields on the origin model,
	 * and values are fields on the lniked model.
	 */
	protected function _keys($keys) {
		if (!$keys) {
			return array();
		}
		$config = $this->_config;
		$hasType = ($config['type'] === 'hasOne' || $config['type'] === 'hasMany');
		$related = Libraries::locate('models', $config[$hasType ? 'from' : 'to']);

		if (!class_exists($related)) {
			throw new ClassNotFoundException("Related model class '{$related}' not found.");
		}
		if (!$related::key()) {
			throw new ConfigException("No key defined for related model `{$related}`.");
		}
		$keys = (array) $keys;
		$related = (array) $related::key();

		if (count($keys) !== count($related)) {
			$msg = "Unmatched keys in relationship `{$config['name']}` between models ";
			$msg .= "`{$config['from']}` and `{$config['to']}`.";
			throw new ConfigException($msg);
		}
		return $hasType ? array_combine($related, $keys) : array_combine($keys, $related);
	}

	/**
	 * Strategies used to query related objects, indexed by key.
	 */
	protected function _strategies() {
		return array(
			static::LINK_EMBEDDED => function($object, $relationship) {
				$fieldName = $relationship->fieldName();
				return $object->{$fieldName};
			},
			static::LINK_CONTAINED => function($object, $relationship) {
				$isArray = ($relationship->type() === "hasMany");
				return $isArray ? $object->parent()->parent() : $object->parent();
			},
			static::LINK_KEY => function($object, $relationship, $options) {
				$model = $relationship->to();
				if (!$query = $relationship->query($object)) {
					return;
				}
				$method = ($relationship->type() === "hasMany") ? 'all' : 'first';
				return $model::$method(Set::merge((array) $query, (array) $options));
			},
			static::LINK_KEY_LIST  => function($object, $relationship, $options) {
				$model = $relationship->to();
				$query = $relationship->query($object);
				return $model::all(Set::merge($query, $options));
			}
		);
	}

	/**
	 * Validates an entity relation.
	 *
	 * @param object $entity The relation's entity
	 * @param array $options Validates option.
	 */
	public function validates($entity, array $options = array()) {
		$defaults = array('with' => false);
		$fieldName = $this->fieldName();
		if (!isset($entity->$fieldName)) {
			return;
		}
		return (array) $entity->$fieldName->validates($options + $defaults);
	}

	/**
	 * Saving an entity relation.
	 *
	 * @param object $entity The relation's entity
	 * @param array $options Saving options.
	 */
	public function save($entity, array $options = array()) {
		$fieldName = $this->fieldName();
		$model = $entity->model();
		$isRelation = is_object($entity->$fieldName) && $this->link() === Relationship::LINK_KEY;
		if (!$isRelation || !$model) {
			return true;
		}
		if (($type = $this->type()) !== 'belongsTo' && !($keys = $model::key($entity))) {
			return true;
		}

		$result = false;
		switch ($type){
			case 'hasAndBelongsToMany':
				$relVia = $model::relations($this->via());
				$fKeys = $relVia->foreignKey($keys);
				$toVia = $relVia->to();
				$relTo = $toVia::relations($this->name());
				$related = $entity->$fieldName;
				$method = '_habtm' . ucfirst($this->viaMode() ?: 'diff');
				$result = $this->$method($related, $relTo, $relVia, $fKeys, $options);
				unset($entity->{$relVia->fieldName()});
			break;
			case 'hasMany':
				$fKeys = $this->foreignKey($keys);
				$to = $this->to();
				$data = array_fill_keys(array_keys($fKeys), null);
				$to::update($data, $fKeys);
				foreach ($entity->$fieldName as $relEntity) {
					$relEntity->set($fKeys);
					$result = $relEntity->save(null, $options);
				}
			break;
			case 'hasOne':
				$fKeys = $this->foreignKey($keys);
				$relEntity = $entity->$fieldName;
				$relEntity->set($fKeys);
				$result = $relEntity->save(null, $options);
			break;
			case 'belongsTo':
				$relEntity = $entity->$fieldName;
				$result = $relEntity->save();
				$relModel = $relEntity->model();
				$keys = $relModel::key($relEntity);
				$fKeys = $this->foreignKey($keys);
				$entity->set($fKeys);
			break;
		}
		return $result;
	}

	/**
	 * Perform a HABTM diff saving (i.e only create/delete the unexisted/deleted associations)
	 *
	 * @param object $entity The entity.
	 * @param object $relTo The destination relation.
	 * @param object $relVia The middle relation.
	 * @param array $foreignKeys The foreign keys extracted from the via relation.
	 * @param array $options Saving options.
	 * @return boolean
	 */
	protected function _habtmDiff($entity, $relTo, $relVia, &$foreignKeys, array &$options = array()) {
		$return = true;
		$to = $relTo->to();
		$middle = $relVia->to();
		$alreadySaved = $middle::find('all', array(
			'conditions' => array('or' => $foreignKeys)
		))->data();

		foreach ($entity as $relEntity) {
			$relEntity->save(null, $options);
			$keys = $to::key($relEntity);
			$foreignKeys2 = $relTo->foreignKey($keys);
			$toFind = count($foreignKeys2);
			$finded = false;
			foreach ($alreadySaved as $key => $value) {
				$intersect = array_intersect_assoc($foreignKeys2, $value);
				if (count($intersect) === $toFind) {
					unset($alreadySaved[$key]);
					$finded = true;
					break;
				}
			}

			if (!$finded) {
				$habtm = $middle::create($foreignKeys + $foreignKeys2);
				$return &= $habtm->save(null, $options);
			}
		}
		$toDelete = array();
		foreach ($alreadySaved as $key => $value) {
			$toDelete[] = $middle::key($value);
		}
		if ($toDelete) {
			$return &= $middle::remove(array('or' => $toDelete));
		}
		return true;
	}

	/**
	 * Perform a HABTM flush saving (i.e remove & recreate all associations)
	 *
	 * @param object $entity The entity.
	 * @param object $relTo The destination relation.
	 * @param object $relVia The middle relation.
	 * @param array $foreignKeys The foreign keys.
	 * @param array $options Saving options.
	 * @return boolean
	 */
	protected function _habtmFlush($entity, $relTo, $relVia, &$foreignKeys, array &$options = array()) {
		$return = true;
		$to = $relTo->to();
		$middle = $relVia->to();
		$return &= $middle::remove($foreignKeys);
		foreach ($entity as $relEntity) {
			$relEntity->save(null, $options);
			$keys = $to::key($relEntity);
			$foreignKeys2 = $relTo->foreignKey($keys);
			$habtm = $middle::create($foreignKeys + $foreignKeys2);
			$return &= $habtm->save(null, $options);
		}
		return $return;
	}

	public function embed(&$collection, $options = [])
	{
		$keys = $this->key();
		list($formKey, $toKey) = each($keys);

		$related = [];

		if ($this->type() === 'belongsTo') {

			$indexes = $this->_index($collection, $formKey);
			$related = $this->_find(array_keys($indexes), $options);

			$fieldName = $this->fieldName();
			$indexes = $this->_index($related, $toKey);
			$this->_cleanup($collection);

			foreach ($collection as $index => $source) {
				if (is_object($source)) {
					$value = $source->{$formKey};
					if (isset($indexes[$value])) {
						$source->{$fieldName} = $related[$indexes[$value]];
					}
				} else {
					$value = $source[$formKey];
					if (isset($indexes[$value])) {
						$collection[$index][$fieldName] = $related[$indexes[$value]];
					}
				}
			}

		} elseif ($this->type() === 'hasMany') {

			$indexes = $this->_index($collection, $formKey);
			$related = $this->_find(array_keys($indexes), $options);

			$fieldName = $this->fieldName();

			$this->_cleanup($collection);

			foreach ($collection as $index => $entity) {
				if (is_object($entity)) {
					$entity->{$fieldName} = [];
				} else {
					$collection[$index][$fieldName] = [];
				}
			}

			foreach ($related as $index => $entity) {
				if (is_object($entity)) {
					$value = $entity->{$toKey};
					if (isset($indexes[$value])) {
						$source = $collection[$indexes[$value]];
						$source->{$fieldName}[] = $entity;
					}
				} else {
					$value = $entity[$toKey];
					if (isset($indexes[$value])) {
						$collection[$indexes[$value]][$fieldName][] = $entity;
					}
				}
			}

		} elseif ($this->type() === 'hasOne') {

			$indexes = $this->_index($collection, $formKey);
			$related = $this->_find(array_keys($indexes), $options);
			$fieldName = $this->fieldName();
			$this->_cleanup($collection);
			foreach ($related as $index => $entity) {
				if (is_object($entity)) {
					$value = $entity->{$toKey};
					if (isset($indexes[$value])) {
						$source = $collection[$indexes[$value]];
						$source->{$fieldName} = $entity;
					}
				} else {
					$value = $entity[$toKey];
					if (isset($indexes[$value])) {
						$collection[$indexes[$value]][$fieldName] = $entity;
					}
				}
			}

		} elseif ($this->type() === 'hasAndBelongsToMany') {

			$from = $this->from();
			$viaRel = $from::relations($this->via());
			$viaFieldname = $viaRel->fieldName();
			$pivot = $viaRel->embed($collection, $options);

			$viaKeys = $viaRel->key();
			list($viaKeyFrom, $viaKeyTo) = each($viaKeys);

			$indexes = $this->_index($pivot, $toKey);
			$related = [];

			if ($indexes) {
				$to = $this->to();
				$related = $to::find('all', $options + ['conditions' => [
					'id' => array_keys($indexes)
				]]);
			}

			$indexes = $this->_index($related, 'id');

			$fieldName = $this->fieldName();
			$this->_cleanup($collection);

			foreach ($collection as $index => $entity) {
				if (is_object($entity)) {
					$entity->{$fieldName} = [];
				} else {
					$collection[$index][$fieldName] = [];
				}
			}

			foreach ($collection as $index => $entity) {
				if (is_object($entity)) {
					$middle = $entity->$viaFieldname;
					foreach ($middle as $key => $value) {
						$entity->{$fieldName}[] = $related[$indexes[$value->$toKey]];
					}
				} else {
					$middle = $entity[$viaFieldname];
					foreach ($middle as $key => $value) {
						$entity[$fieldName][] = $related[$indexes[$value->$toKey]];
					}
				}
			}

		} else {
			throw new Exception("Error {$this->type()} is unsupported ");
		}
		return $related;
	}

	/**
	 * Gets all entities attached to a collection en entities.
	 *
	 * @param  mixed  $id An id or an array of ids.
	 * @return object     A collection of items matching the id/ids.
	 */
	protected function _find($id, $options = [])
	{
		if ($this->link() !== static::LINK_KEY) {
			throw new SourceException("This relation is not based on a foreign key.");
		}
		if ($id === []) {
			return [];
		}
		$to = $this->to();

		return $to::find('all', $options + ['conditions' => [
			current($this->key()) => $id
		]]);
	}

	/**
	 * Indexes a collection.
	 *
	 * @param  mixed  $collection An collection to extract index from.
	 * @param  string $name       The field name to build index for.
	 * @return array              An array of indexes where keys are `$name` values and
	 *                            values the correcponding index in the collection.
	 */
	protected function _index($collection, $name)
	{
		$indexes = [];
		foreach ($collection as $key => $entity) {
			if (is_object($entity)) {
				$indexes[$entity->{$name}] = $key;
			} else {
				$indexes[$entity[$name]] = $key;
			}
		}
		return $indexes;
	}

	/**
	 * Unsets the relationship attached to a collection en entities.
	 *
	 * @param  mixed  $collection An collection to "clean up".
	 */
	public function _cleanup($collection)
	{
		$name = $this->name();
		foreach ($collection as $index => $entity) {
			if (is_object($entity)) {
				unset($entity->{$name});
			} else {
				unset($entity[$name]);
			}
		}
	}
}

?>
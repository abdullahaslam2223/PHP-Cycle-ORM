<?php

namespace PhpCycleOrm\Lib\ORM;

use Cycle\ORM;
use Cycle\ORM\Iterator;
use Cycle\ORM\Select;
use Cycle\Database\Exception\DatabaseException;
use src\Lib\Types\Enums\SortOrder;

abstract class Record
{
    /** @var ORM\ORMInterface */

    private static ORM\ORMInterface $orm;

    /** @var array */
    private array $data = [];

    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->__setData($data);
    }
    /**
     * Set data from array
     *
     * @param array $data
     */
    public function __setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get data as array
     *
     * @return array
     */
    public function __getData(): array
    {
        return $this->data;
    }

    /**
     * Get a value from data array
     *
     * @param string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        return empty($this->data[$name]) ? null: $this->data[$name];
    }

    /**
     * Set a value
     *
     * @param string $name
     * @param mixed $value
     */
    public function __set(string $name, $value)
    {
        $this->data[$name] = $value;
    }


    public function save(bool $saveChildren = true): ORM\Transaction\StateInterface
    {
        $manager = new ORM\EntityManager(self::getORM());

        try {
            return $manager->persist($this, $saveChildren)->run();
        } catch (DatabaseException $e) {
            sleep(1);
            // retry
            return $manager->persist($this, $saveChildren)->run();
        }

    }

    /**
     * Delete a record
     */

     public function delete(): ORM\Transaction\StateInterface
    {
        $manager = new ORM\EntityManager(self::getORM());

        return $manager->delete($this)->run();
    }

    public static function find(): ORM\RepositoryInterface
    {
        return self::getORM()->getRepository(static::class);
    }

    /**
     * Get ORM Select
     *
     * @return \Cycle\ORM\Select
     */
    public static function select(
        array $columns = null,
        array $filters=null,
        int $offset=0,
        int $limit=1000,
        ?string $sort_by = null,
        ?SortOrder $sort_order = SortOrder::ASC
    ): Select {
        $qb = self::getORM()->getRepository(static::class)->select();

        if(is_array($filters)) {
            foreach($filters as $key => $val) {
                if ($key === array_key_first($filters)) {
                    $qb->where($key, $val);
                }else {
                    $qb->andWhere($key, $val);
                }
            }    
        }
        if(is_array($filters)) {
            $qb->columns($columns);
        }
        if($sort_by) {
            $qb->orderBy($sort_by, $sort_order->value);
        }
        $qb->offset($offset * $limit)->limit($limit);
        return $qb;
    }

    /**
     * Get ORM Select
     *
     * @return \Cycle\ORM\Select
     */
    public static function selectWith(?string $select_list = '*'): Select {
        return self::select()->scope(new NotDeletedConstrain());
    }

    /**
     * Get ORM interface
     *
     * @return ORM\ORMInterface
     */

     public static function getORM(): ORM\ORMInterface
    {
        return self::$orm;
    }

    /**
     * Set ORM interface
     *
     * @param ORM\ORMInterface $orm
     */

     public static function setORM(ORM\ORMInterface $orm): void
    {
        self::$orm = $orm;
    }
    

}

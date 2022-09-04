<?php

namespace App\TTAlgo;

class Instructor  implements Comparable
{
    const TOLERANCE = 0.0001;
    private $id,$name;

    /**
     * @param $id
     * @param $name
     */
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    public function compareTo($value) {
//        if (!$value instanceof Fuzzy) {
//            throw new RoomException('Can only compare to other Room values');
//        }

        $diff = $this->id - $value->id;

        if ($diff > self::TOLERANCE) {
            return 1;
        }
        elseif ($diff < -self::TOLERANCE) {
            return -1;
        }

        return 0;
    }
}

<?php

namespace App\TTAlgo;

class Room implements Comparable
{
    const TOLERANCE = 0.0001;
    public $number,$seatCapacity;

    /**
     * @param $number
     * @param $seatCapacity
     */
    public function __construct($id,$number, $seatCapacity)
    {
        $this->id = $id;
        $this->number = $number;
        $this->seatCapacity = $seatCapacity;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number): void
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getSeatCapacity()
    {
        return $this->seatCapacity;
    }

    /**
     * @param mixed $seatCapacity
     */
    public function setSeatCapacity($seatCapacity): void
    {
        $this->seatCapacity = $seatCapacity;
    }

    public function __toString()
    {
        return $this->number;
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

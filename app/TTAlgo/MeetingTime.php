<?php

namespace App\TTAlgo;

class MeetingTime
{
    public $id,$time;

    /**
     * @param $id
     * @param $time
     */
    public function __construct($id, $time)
    {
        $this->id = $id;
        $this->time = $time;
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
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time): void
    {
        $this->time = $time;
    }

    public function __toString()
    {
        return $this->time;
    }

    public function meetingDay()
    {
        return substr($this->time,0,2);
    }

}

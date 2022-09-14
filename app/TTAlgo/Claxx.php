<?php

namespace App\TTAlgo;

class Claxx
{

    private $id,$dept,$course,$instructor,$meetingTime,$room;

    /**
     * @param $id
     * @param $course
     * @param $instructor
     * @param $meetingTime
     * @param $room
     */
    public function __construct($id, Course $course)
    {
        $this->id = $id;
        $this->course = $course;
    }

    public function __toString()
    {
        return implode(',',
            [
            $this->getCourse()->name,$this->getCourse()->number,
            $this->meetingTime->getId(),$this->getRoom()->getNumber()
            ]
        );
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

    public function getRefinedId()
    {
        $idX = explode(".",$this->course->number);
        return $idX[0];
    }


    /**
     * @return mixed
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * @param mixed $course
     */
    public function setCourse($course): void
    {
        $this->course = $course;
    }

    /**
     * @return mixed
     */
    public function getInstructor()
    {
        return $this->instructor;
    }

    /**
     * @param mixed $instructor
     */
    public function setInstructor($instructor): void
    {
        $this->instructor = $instructor;
    }

    /**
     * @return mixed
     */
    public function getMeetingTime()
    {
        return $this->meetingTime;
    }

    public function meetingDay()
    {
        return $this->meetingTime->meetingDay();
    }

    public function sameDay(Claxx $obj)
    {
        return $this->meetingDay() == $obj->meetingDay() && $this->sameRefinedId($obj);
    }

    public function sameRefinedId(Claxx $obj)
    {
        return $this->getRefinedId() == $obj->getRefinedId();
    }

    /**
     * @param mixed $meetingTime
     */
    public function setMeetingTime($meetingTime): void
    {
        $this->meetingTime = $meetingTime;
    }

    /**
     * @return mixed
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @param mixed $room
     */
    public function setRoom($room): void
    {
        $this->room = $room;
    }

}

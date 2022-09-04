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

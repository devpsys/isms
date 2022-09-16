<?php

namespace App\TTAlgo;

class Data
{

    public $rooms,$meeting_times,$instructors,$courses,$numberOfClasses;

    public function __construct($instructors,$meeting_times,$rooms,$classes,$days)
    {

        $this->rooms = [];$this->meeting_times = [];$this->instructors = [];

        foreach ($rooms as $room){
            $this->rooms[] = new Room($room->id,$room->class_name,$room->capacity);
        }
//        $days = [];
        foreach ($meeting_times as $meeting_time){
            foreach ($days as $day){
                $this->meeting_times[] = new MeetingTime($day.$meeting_time->id,$day.$meeting_time->time_from.'-'.$meeting_time->time_to);
            }
        }

        foreach ($instructors as $instructor){
            $this->instructors[] = new Instructor($instructor->id,$instructor->fullname);
        }
        foreach ($classes as $class){
            $this->courses[] =  new Course($class->id, $class->class_name, $class->teachers ,50);
        }
//        dd($this->rooms);
    }

    public function __initiate()
    {

    }

    /**
     * @return array
     */
    public function getRooms(): array
    {
        return $this->rooms;
    }

    /**
     * @return array
     */
    public function getMeetingTimes(): array
    {
        return $this->meeting_times;
    }

    /**
     * @return array
     */
    public function getInstructors(): array
    {
        return $this->instructors;
    }

    /**
     * @return array
     */
    public function getCourses(): array
    {
        return $this->courses;
    }

    /**
     * @return int
     */
    public function getNumberOfClasses(): int
    {
        return $this->numberOfClasses;
    }

}

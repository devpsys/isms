<?php

namespace App\TTAlgo;

class Schedule
{
    public  $_data,$_classes,$_noOfConflicts,$_fitness,$_classNumb,$_isFitnessChaanged;

    /**
     * @param $_data
     * @param $_classes
     * @param $_noOfConflicts
     * @param $_fitness
     * @param $_classNumb
     * @param $_isFitnessChaanged
     */
    public function __construct($_data)
    {
        $this->_data = $_data;
        $this->_classes = [];
        $this->_numbOfConflicts = 0;
        $this->_fitness = -1;
        $this->_classNumb = 0;
        $this->_isFitnessChaanged = true;
    }

    public function __init()
    {
        $courses_ = $this->_data->getCourses();
//        dd($courses_);
        $meetingTimes = $this->_data->getMeetingTimes();
        $rooms = $this->_data->getRooms();
        $instructors = $this->_data->getInstructors();
        $i=0;
        foreach ($courses_ as $course){
            $i++;
            $newClass  = new Claxx($this->_classNumb,$course);
            $this->_classNumb++;
            $newClass->setMeetingTime($meetingTimes[random_int(0,count($meetingTimes)-1)]);
            $newClass->setRoom($rooms[random_int(0,count($rooms)-1)]);
            $newClass->setInstructor($instructors[random_int(0,count($instructors)-1)]);
            $this->_classes[] = $newClass;
        }
//        return $this->_classes;
        return $this;

    }

    public function getClasses()
    {
        $this->_isFitnessChaanged =TRUE;
        return $this->_classes;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * @return mixed
     */
    public function getNoOfConflicts()
    {
        return $this->_noOfConflicts;
    }

    /**
     * @return int
     */
    public function getFitness(): int
    {
        if($this->_isFitnessChaanged){
            $this->_fitness = $this->calculate_fitness();
            $this->_isFitnessChaanged = False;
        }
        return $this->_fitness;
    }

    /**
     * @return int
     */
    public function getClassNumb(): int
    {
        return $this->_classNumb;
    }

    /**
     * @return bool
     */
    public function isIsFitnessChaanged(): bool
    {
        return $this->_isFitnessChaanged;
    }

    private function calculate_fitness()
    {
        $this->_noOfConflicts = 0;
        $classes = $this->getClasses();

        for($i=0;$i<count($classes);$i++){
            if($classes[$i]->getRoom()->getSeatCapacity() < $classes[$i]->getCourse()->getMaxNumbOfStudents()){
                $this->_noOfConflicts++;
            }
            for ($j=$i;$j<count($classes);$j++){
                if($classes[$i]->getMeetingTime()==$classes[$j]->getMeetingTime() && $classes[$i]->getId()!=$classes[$j->getId()]){
                    if($classes[$i]->getRoom()->compareTo($classes[$j]->getRoom())) {
                        $this->_noOfConflicts++;
                    }
                    if($classes[$i]->getInstructor()->compareTo($classes[$j]->getInstructor())){
                        $this->_noOfConflicts++;
                    }
                }
            }
        }
        return 1/((1.0*$this->_numbOfConflicts)+1);

    }

    public function toString()
    {
        $str = "";

        foreach ($this->_classes as $c){
            $str .= $c.",{$this->_numbOfConflicts}|";
        }
        return $str;
    }


}

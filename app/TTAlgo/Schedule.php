<?php

namespace App\TTAlgo;

class Schedule
{
    public $_data, $_classes, $_noOfConflicts, $_fitness, $_classNumb, $_isFitnessChaanged, $timeDict;

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
        $this->_numbOfConflicts = 0;
        $courses_ = $this->_data->getCourses();
        $meetingTimes = $this->_data->getMeetingTimes();
        $this->timeDict = [];

        foreach ($meetingTimes as $mts) {
            $this->timeDict[substr($mts, 0, 2)]['entries'] = [];
            $this->timeDict[substr($mts, 0, 2)]['times'][] = $mts;
        }
//        dd($this->timeDict);
        $rooms = $this->_data->getRooms();
        $instructors = $this->_data->getInstructors();
        $i = 0;
        foreach ($courses_ as $course) {
            $i++;
            $newClass = new Claxx($this->_classNumb, $course);
            $this->_classNumb++;
            $newClass->setMeetingTime($this->goodMeetingTime($this->_classNumb, $meetingTimes));
            $newClass->setRoom($rooms[random_int(0, count($rooms) - 1)]);
            $newClass->setInstructor($instructors[random_int(0, count($instructors) - 1)]);
            $this->_classes[] = $newClass;
        }
//        return $this->_classes;
        return $this;

    }

    public function goodMeetingTime($classNum, $meetingTimes)
    {
        $list = [];
//        dd($this->timeDict);
        foreach ($this->timeDict as $tm) {
//            dd($tm);
            try {
                if (!in_array($classNum,
                    $tm['entries'])) {
                    $list = array_merge($list, $tm['times']);
                }
            } catch (\Exception $e) {
//                dd($tm);
            }
        }
        $time = $list[random_int(0, count($list) - 1)];
        $this->timeDict[substr($time->time, 0, 2)] = $classNum;
        $i = 0;
        foreach ($meetingTimes as $mt) {
            if ($mt->getTime() == $time->getTime()) {
                return $meetingTimes[$i];
            }
            $i++;
        }
        return $meetingTimes[0];
    }

    public function getClasses()
    {
        $this->_isFitnessChaanged = TRUE;
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
        if ($this->_isFitnessChaanged) {
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

    public function calculate_fitness()
    {
        $this->_noOfConflicts = 0;
        $classes = $this->getClasses();

        for ($i = 0; $i < count($classes); $i++) {
            if ($classes[$i]->getRoom()->getSeatCapacity() < $classes[$i]->getCourse()->getMaxNumbOfStudents()) {
                $this->_noOfConflicts++;
            }
            for ($j = $i; $j < count($classes); $j++) {
                if ($classes[$i]->getMeetingTime() == $classes[$j]->getMeetingTime() && $classes[$i]->getId() != $classes[$j]->getId()) {
                    if ($classes[$i]->getRoom()->compareTo($classes[$j]->getRoom())) {
                        $this->_noOfConflicts++;
                    }
                    if ($classes[$i]->getInstructor()->compareTo($classes[$j]->getInstructor())) {
                        $this->_noOfConflicts++;
                    }
                }
            }
        }
        return 1 / ((1.0 * $this->_numbOfConflicts) + 1);

    }

    public function toString()
    {
        $str = "";

        foreach ($this->_classes as $c) {
            $str .= $c . ",{$this->_numbOfConflicts}|";
        }
        return $str;
    }


}

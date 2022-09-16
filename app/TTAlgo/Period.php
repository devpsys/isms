<?php

namespace App\TTAlgo;

class Period implements Comparable
{

    public $start_time,$subject,$class,$day,$teacher;

    /**
     * @param $start_time
     * @param $subject
     * @param $class
     * @param $day
     * @param $teacher
     */
    public function __construct( $subject, $class, $teacher)
    {
        $this->subject = $subject;
        $this->class = $class;
        $this->teacher = $teacher;
        $this->day = null;
        $this->start_time = null;
    }


    public function find(&$box,&$classMaps,&$teacherMaps,$timings,$days)
    {
        $found = 0;
        for ($i=0;$i<count($days);$i++){
            for($j=0;$j<count($timings);$j++){
                if(
                    $box[$i][$j] ==null
                    && !isset($teacherMaps[$this->teacher][$days[$i]][$timings[$j]])
                    && !isset($classMaps[$this->class][$days[$i]])
                    && !isset($classMaps[$this->class][$days[$i]][$timings[$j]])
                ){
                    $this->setDay($days[$i]);
                    $this->setStartTime($timings[$j]);
                    $box[$i][$j] = $this;
                    $teacherMaps[$this->teacher][$days[$i]][$timings[$j]] = 1;
                    $classMaps[$this->class][$days[$i]][$timings[$j]] = 1;
                    $found = 1;
                    break;
                }else{
//                    dd($teacherMaps);

                }
            }
            if($found) break;
        }
//        dd($box);

    }

    /**
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->start_time;
    }

    /**
     * @param mixed $start_time
     */
    public function setStartTime($start_time): void
    {
        $this->start_time = $start_time;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param mixed $class
     */
    public function setClass($class): void
    {
        $this->class = $class;
    }

    /**
     * @return mixed
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param mixed $day
     */
    public function setDay($day): void
    {
        $this->day = $day;
    }

    /**
     * @return mixed
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * @param mixed $teacher
     */
    public function setTeacher($teacher): void
    {
        $this->teacher = $teacher;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param mixed $length
     */
    public function setLength($length): void
    {
        $this->length = $length;
    }


    public function compareTo($other)
    {
        // TODO: Implement compareTo() method.
    }
}

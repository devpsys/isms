<?php

namespace App\TTAlgo;

class Course
{

    public $number;
    public $name;
    public $instructors;
    public $maxNumbOfStudents;

    /**
     * @param $number
     * @param $name
     * @param $instructors
     * @param $maxNumbOfStudents
     */
    public function __construct($number, $name, $instructors, $maxNumbOfStudents)
    {
        $this->number = $number;
        $this->name = $name;
        $this->instructors = $instructors;
        $this->maxNumbOfStudents = $maxNumbOfStudents;
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

    /**
     * @return mixed
     */
    public function getInstructors()
    {
        return $this->instructors;
    }

    /**
     * @param mixed $instructors
     */
    public function setInstructors($instructors): void
    {
        $this->instructors = $instructors;
    }

    /**
     * @return mixed
     */
    public function getMaxNumbOfStudents()
    {
        return $this->maxNumbOfStudents;
    }

    /**
     * @param mixed $maxNumbOfStudents
     */
    public function setMaxNumbOfStudents($maxNumbOfStudents): void
    {
        $this->maxNumbOfStudents = $maxNumbOfStudents;
    }

    public function __toString()
    {
        return $this->name;
    }


}

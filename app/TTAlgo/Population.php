<?php

namespace App\TTAlgo;

class Population
{

    public $size,$data,$schedules;

    /**
     * @param $size
     * @param $data
     * @param $schedules
     */
    public function __construct($size, $data)
    {
        $this->size = $size;
        $this->data = $data;
        $this->schedules = [];

        for($i=0;$i<$size;$i++){
            $sc = new Schedule($data);
            $this->schedules[] = $sc->__init();
        }
    }

    /**
     * @return array
     */
    public function getSchedules(): array
    {
//        $arr = [];
//        foreach ($this->schedules as $sh){
//            $arr []=$sh;
//        }
        return $this->schedules;
    }




}

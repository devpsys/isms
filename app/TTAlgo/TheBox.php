<?php

namespace App\TTAlgo;

class TheBox
{

    public $container,$class_time_map,$teacher_time_map,$class_day_map;
    public $timings,$classes,$days,$box;

    public function __construct($data,$timings,$days,$classes)
    {
        $this->timings = $timings;
        $this->days = $days;
        $this->classes = $classes;
        $this->container = $data;
    }


    public function __init()
    {

        $i=0;
//        dd($this->container);
        $c = count($this->container);
        $noOfDays  = count($this->days);
        $noOfTimes  = count($this->timings);
        for ($i=0;$i<$noOfDays;$i++){
            for ($j=0;$j<$noOfTimes;$j++){
                $this->box[$i][$j] = null;
            }
        }
//        dd($this->box);
        for ($k=0;$k<$c;$k++){
            $cls = explode(".",$this->container[$k%$c]->class);
            $period = new Period($this->container[$k]->subject,$cls[0],$this->container[$k]->teacher);
            $period->find($this->box,$this->class_time_map,$this->teacher_time_map,$this->timings,$this->days);
        }

    }

    public function randomCheckedIndex(Period $period)
    {
        $noOfDays  = count($this->days)-1;
        $noOfTimes  = count($this->timings)-1;
        $indexD = random_int(0,$noOfDays);
        $indexT = random_int(0,$noOfTimes);
        $free = true;
        $iteration = 0;
        $it = 0;
        $assigned = 0;

        do{

            for($i=$indexD;$i<$noOfDays+$indexD;$i++){
                if(isset($this->class_time_map[$period->class][$i%($noOfDays+1)]) && count($this->class_time_map[$period->class][$i%($noOfDays+1)])< ($noOfTimes+1)){
                    $indexD = $i;
                    break;
                }
            }
            $iteration++;
            $teacher = isset($this->teacher_time_map[$period->teacher][($indexD%($noOfDays+1))][$indexT%($noOfTimes+1)]);
            $class = isset($this->class_time_map[$period->class][($indexD%($noOfDays+1))][$indexT%($noOfTimes+1)]);


            if( !$teacher && !$class && !isset($this->class_time_map[$period->class][$indexD%($noOfDays+1)])){
                $this->teacher_time_map[$period->teacher][$indexD%($noOfDays+1)][$indexT%($noOfTimes+1)] = 1;
                $this->class_time_map[$period->class][$indexD%($noOfDays+1)][$indexT%($noOfTimes+1)] = 1;
                $period->setStartTime($this->timings[$indexT%($noOfTimes+1)]);
                $period->setDay($this->days[$indexD%($noOfDays+1)]);
                $this->box[] = $period;
                $free = false;
                $assigned =1;
//                print("[".$indexD%($noOfDays+1).",".$indexD%($noOfDays+1)."]");
            }else{
                if($it==$noOfTimes+1){
                    $indexD++;
                    $indexT = 0;
                }else
                    $indexT++;
            }
            if($iteration>=$noOfTimes*$noOfDays*2){
                $free = false;
            }
        }while($free);
        return $assigned?$assigned:$this->randomCheckedIndex($period);
    }
}

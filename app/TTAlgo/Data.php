<?php

namespace App\TTAlgo;

class Data
{
    const ROOMS = [["R1", 25], ["R2", 45], ["R3", 35], ["R4", 35], ["R5", 35]];

    const MEETING_TIMES = [
        ["MO1", "MO 04:15 - 04:45"],
        ["MO2", "MO 04:45 - 05:15"],
        ["MO3", "MO 05:15 - 05:45"],
        ["TU1", "TU 04:15 - 04:45"],
        ["TU2", "TU 04:45 - 05:15"],
        ["TU3", "TU 05:15 - 05:45"],
        ["WE1", "WE 04:15 - 04:45"],
        ["WE2", "WE 04:45 - 05:15"],
        ["WE3", "WE 05:15 - 05:45"],
        ["SA", "SA 04:15 - 04:45"],
        ["SA", "SA 04:45 - 05:15"],
        ["SA", "SA 05:15 - 05:45"],
        ["SU", "SU 04:15 - 04:45"],
        ["SU", "SU 04:45 - 05:15"],
        ["SU", "SU 05:15 - 05:45"],
    ];
    const INSTRUCTORS = [
        ["I1", "Dr James Web"],
        ["I2", "Mr. Mike Brown"],
        ["I3", "Dr Steve Day"],
        ["I4", "Mrs Jane Doe"]];
    public $rooms,$meeting_times,$instructors,$courses,$numberOfClasses;

    public function __construct()
    {
        $this->rooms = [];$this->meeting_times = [];$this->instructors = [];

        foreach (range(0,count(self::ROOMS)-1) as $i){
            $this->rooms[] = new Room($i,self::ROOMS[$i][0],self::ROOMS[$i][1]);
        }
        foreach (range(0,count(self::MEETING_TIMES)-1) as $i){
            $this->meeting_times[] = new MeetingTime(self::MEETING_TIMES[$i][0],self::MEETING_TIMES[$i][1]);
        }
        foreach (range(0,count(self::INSTRUCTORS)-1) as $i){
            $this->instructors[] = new Instructor(self::INSTRUCTORS[$i][0],self::INSTRUCTORS[$i][1]);
        }
        $ints_perm = [[0,1],[0,1,2],[0,1],[2,3],[3],[0,2],[1,3]];
        for ($i=0;$i<7;$i++){
            $cs = [];
            foreach ($ints_perm[$i] as $inst){
                $cs[] = self::INSTRUCTORS[$inst];
            }
            $this->courses[] = new Course("C".$i+1,mt_rand(111,999)."k",$cs,20);
        }
//        (float)rand() / (float)getrandmax()
        $this->numberOfClasses = 0;
//        dd($this->courses);
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

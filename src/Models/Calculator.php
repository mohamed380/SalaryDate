<?php 

namespace App\Models;

class Calculator {

    public const SUNDAY = 'Sunday';
    public const SATURDAY = 'Saturday';

    public static function process(array $row){

        if( empty($row[File::SALARY_DATE_INDEX]) ){
            $row[File::SALARY_DATE_INDEX] = self::getSalaryDate($row[File::MONTH_INDEX]);
        }
        
        if( empty($row[File::BOUNS_DATE_INDEX]) ){
            $row[File::BOUNS_DATE_INDEX] = self::getBounsDate($row[File::MONTH_INDEX]);
        }

        return $row;
    }

    private static function getSalaryDate(string $month)
    {
        $date = date('Y') ."-". date('m',strtotime($month)) . "-" . date('t', strtotime($month));
        $day = date('l', strtotime($date));

        if ( $day ==  self::SUNDAY){
            $date = date('Y-m-d', strtotime($date. '+ 1 days'));
        }

        if ( $day == self::SATURDAY ){
            $date = date('Y-m-d', strtotime($date. '+ 2 days'));
        }
        
        return $date;
    }

    private static function getBounsDate(string $month)
    {
        $date = date('Y') ."-".  date('m',strtotime($month)) . "-15";
        $day = date('l', strtotime($date));

        if ( in_array($day, [self::SATURDAY, self::SUNDAY]) ){

            $date =  date('Y-m-d', strtotime($date. ' next Wednesday')); // get next wednesday

        }

        return $date;
    }


}
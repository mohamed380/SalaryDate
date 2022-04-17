<?php 

namespace App\Models;

use DateTime;

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
        $date = new DateTime($month);
        $endDateFormated = $date->format('Y-m-t');
        $endDate = new DateTime($endDateFormated);
        $day = ($endDate)->format('l');
        if ($day ==  self::SUNDAY) {
            $endDate = $endDate->add(new \DateInterval('P1D'));
        }elseif ($day == self::SATURDAY) {
            $endDate = $endDate->add(new \DateInterval('P2D'));
        }
        return $endDate->format('Y-m-d');
    }

    private static function getBounsDate(string $month)
    {
        $date = new DateTime("$month-15");
        $day = $date->format('l');
        if (in_array($day, [self::SATURDAY, self::SUNDAY])) {
            $date =  $date->modify('next Wednesday'); // get next wednesday
        }
        return $date->format('Y-m-d');
    }


}
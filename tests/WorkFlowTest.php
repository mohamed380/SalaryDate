<?php

namespace Tests;

use App\Models\Calculator;
use App\Models\File;
use PHPUnit\Framework\TestCase;

class WorkFlowTest extends TestCase{

    /** @test */

    public function works_fine_with_valid_file()
    {
        $argv = [0=> 'Main.php', 1 =>  __DIR__.DIRECTORY_SEPARATOR.'months.csv'];
        $argc = 2;
        require_once('./Main.php');

        $filePointer = fopen($argv[1], 'r');

        while (($row = fgetcsv($filePointer)) && $row !== FALSE) {

            if($row[File::MONTH_INDEX] !== File::MONTH) { // ignore headers
                $salayDay = date('l', strtotime($row[File::SALARY_DATE_INDEX]));
                $this->assertNotContains($salayDay, [Calculator::SATURDAY, Calculator::SUNDAY]);
                $bounsDay = date('l', strtotime($row[File::SALARY_DATE_INDEX]));
                $this->assertNotContains($bounsDay, [Calculator::SATURDAY, Calculator::SUNDAY]);
            }
            
        }

        fclose($filePointer);
    }

    /** @test */

    public function throws_exception_with_invalid_file_structre()
    {
        $this->expectExceptionMessage('File structre is not valid');
        $file = new File(__DIR__.DIRECTORY_SEPARATOR.'invalidStrcutre.csv');
    }


    /** @test */

    public function throws_exception_with_not_found_file()
    {
        $path = __DIR__.DIRECTORY_SEPARATOR.'notFound.csv';
        $this->expectExceptionMessage("File '$path' not found!");
        $file = new File($path);
    }

    /** @test */

    public function throws_exception_with_invalid_extension()
    {
        $path = __DIR__.DIRECTORY_SEPARATOR.'file.txt';
        $this->expectExceptionMessage("File extension is not supported");
        $file = new File($path);
    }
}

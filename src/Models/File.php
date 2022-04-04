<?php 

namespace App\Models;

use App\Traits\validation;

class File{

    use Validation;

    public const CSV = 'csv';
    public const MONTH = 'month';
    public const SALARY_DATE = 'salary_date';
    public const BOUNS_DATE = 'bouns_date';
    public const MONTH_INDEX = 0;
    public const SALARY_DATE_INDEX = 1;
    public const BOUNS_DATE_INDEX = 2;
    private string $error = '';
    private string $filePath = '';

    public function __construct(string $path)
    {        
        if(!$this->validate($path)){
            throw new \Exception($this->error);
        }

        $this->filePath = $path;
    }

    public function process()
    {
        $file = fopen($this->filePath, 'r');
        $updates = [];

        while (($row = fgetcsv($file)) && $row !== FALSE) {

            if($row[self::MONTH_INDEX] !== self::MONTH) { // ignore headers
                $updates[] = Calculator::process($row);
            }else{
                $updates[0] = $row;
            }
            
        }
        
        fclose($file);

        $this->updateContent($updates);
    }

    private function updateContent($lines): void
    {
        $file = fopen($this->filePath, 'w');

        foreach ($lines as  $line) {
            fputcsv($file, $line);
        }

        fclose($file);
    }

}
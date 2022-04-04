<?php

namespace App\Traits;

use App\Models\File;

trait Validation{

    private function validate(string $path): bool
    {
        if($this->exists($path)){
            if($this->extension($path)){
                if($this->staructre($path)){
                    return true;
                }
            }
        }
        
        return false;
    }

    private function exists(string $path): bool
    {
        if(!file_exists($path)){
            $this->error = "File '$path' not found!";
            return false;
        }

        return true;
    }

    private function extension(string $path): bool
    {
        $extnsion = pathinfo($path, PATHINFO_EXTENSION);
        
        if ($extnsion !== File::CSV){
            $this->error = "File extension is not supported";
            return false;
        }

        return true;
    }

    private function staructre(string $path): bool
    {
        $file = fopen($path, 'r');
        $header = fgetcsv($file);
        fclose($file);
        
        if($header === FALSE){

            $this->error = "Empty file given";
            return false;
        
        }

        if( !(
                ( ($header[File::MONTH_INDEX] ?? null) == File::MONTH) &&
                ( ($header[File::SALARY_DATE_INDEX] ?? null) == File::SALARY_DATE) &&
                ( ($header[File::BOUNS_DATE_INDEX] ?? null) == File::BOUNS_DATE)
            )
        ){
            $this->error = "File structre is not valid";
            return false;
        }

        return true;
    }
}
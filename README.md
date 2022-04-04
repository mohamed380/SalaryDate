## About the Project

Small command-line utility to help a fictional
company determine the dates they need to pay salaries to their sales
department.

## Input

Path of csv file.

## Output

Updated given file with the dates that employees will be paied

## How the Algorithm Works

- Check if given file is existing, csv, well structured file
- Read file content and loop through rows or lines
- Update salary date and bouns date columns according to requiremnts
- Update file content

## Examples

```
month: January 

result : salary date => 31/01/2022, bouns date => 19/01/2022

```

## How to Install the Project

    git clone https://github.com/mohamed380/SalaryDate.git
    cd SalaryDate
    composer install
    composer dump-autoload
    ./vendor/bin/phpunit tests

## How to use
    > navigate to project folder and run
    php Main.php #pathOfFile

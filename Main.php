<?php

require __DIR__.'/vendor/autoload.php';

use App\Models\File;

if( $argc <= 1 ){
    echo 'file path required';
    return;
}

try {

    $file = new File($argv[1]);
    $file->process();
    echo "\n\e[0;32;40mDone!, Check file path!\e[0m\n";

} catch (\Exception $exception) {

    echo "\n\e[1;31;40m". $exception->getMessage() . "\e[0m\n";

}

?>
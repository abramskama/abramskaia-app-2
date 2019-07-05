<?php
namespace App;
require __DIR__ . '/vendor/autoload.php';

if(isset($argv[1])) {
    switch ($argv[1]) {
        case 'schedule':

            $env = getenv();
            $firstStartDelay = $env['FIRST_START_DELAY'];
            $schedulePeriod = $env['SCHEDULE_PERIOD'];

            echo '[ Info ] Delay between executions:'.$schedulePeriod;
            echo '[ Info ] Press [CTRL+C] to stop';

            sleep($firstStartDelay);

            $injector = include(__DIR__.'/src/Dependencies.php');
            $city = $injector->make('App\Models\City');

            while(1) {
                for($i = 1; $i <= $schedulePeriod; $i++) {
                    sleep(1);
                }
                $city->addOfferCounts();
                echo '[ Info ] Schedule runned';
            }

            break;
        case 'init':
            echo '[ Info ] Init started';

            $injector = include(__DIR__.'/src/Dependencies.php');
            $city = $injector->make('App\Models\City');
            $city->loadCities();
            echo '[ Info ] Init completed';
            exit();
            break;
    }
}

echo '[ Error ] No such action';

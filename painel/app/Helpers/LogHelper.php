<?php

namespace App\Helpers;

use App\Models\Log;
use App\Repositories\LogRepository;

class LogHelper
{
    private LogRepository $logRepository;

    public function __construct(LogRepository $logRepository){
        $this->logRepository = $logRepository;
    }

    public static function write($message, $type) 
    {
        $logsEnabled = env('ALL_LOGS', 'true');

        if ($logsEnabled) {
            $dataEntry = array(
                "message" => $message,
                "type" => $type
            );

            $entity = new Log();
            $entity->fill($dataEntry);
            $entity->save();
        } 
    }
}
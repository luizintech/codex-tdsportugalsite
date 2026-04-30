<?php 

namespace App\Enums;

abstract class LogType {
    const Error = 1;
    const Warn = 2;
    const Info = 3;
    const Fatal = 4;
}
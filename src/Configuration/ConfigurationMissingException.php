<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 03.12.18
 * Time: 18:03.
 */

namespace DaSi\TwigCli\Configuration;

use Throwable;

class ConfigurationMissingException extends \Exception
{
    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

<?php
namespace EasyGit;

class Exception extends \Exception
{
    public function __construct ($message, \Exception $previousException=null)
    {
        parent::__construct($message, 500, $previousException);
    }
}
?>

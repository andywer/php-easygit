<?php
namespace EasyGit;

class GitException extends Exception
{
    public function __construct ($commandString, $errorMessage, \Exception $previousException=null)
    {
        parent::__construct("Git invocation failed: $commandString. Error: $errorMessage", $previousException);
    }
}
?>

<?php
namespace EasyGit\tests\units;

use \mageekguy\atoum;
use \EasyGit;
use \EasyGit\tests\Helper;

require_once __DIR__ . "/../../EasyGit.php";
require_once __DIR__ . "/../Helper.php";

class Command extends atoum\test
{
    public function testRun ()
    {
        $command = new EasyGit\Command("/tmp", "echo 'test'");
        $output = $command->run();
        
        $this->assert("Test command should echo \"test\"")
            ->string($output)->isEqualTo("test");
        
        $exceptionCatched = false;
        try {
            $command = new EasyGit\Command("/tmp", "exit 1");
            $command->run();
        } catch (EasyGit\GitException $e) {
            $exceptionCatched = true;
        }
        
        if(!$exceptionCatched) {
            $this->fail("Command instance should throw a GitException if the status code is not equal to zero");
        }
    }
}
?>

<?php
namespace EasyGit;

class Command
{
    private $workingDirPath;
    
    private $command;
    private $arguments;
    
    
    public function __construct ($workingDirPath, $command, $arguments=array())
    {
        $this->workingDirPath = $workingDirPath;
        $this->command = $command;
        $this->arguments = $arguments;
    }
    
    public function run ()
    {
        $commandString = $this->buildCommandString();
        $returnCode = $this->shellExecute($commandString, $stdout, $stderr);
        
        if($returnCode != 0) {
            throw new GitException($commandString, trim($stderr));
        }
        
        return trim($stdout);
    }
    
    private function buildCommandString ()
    {
        $commandString = escapeshellcmd($this->command);
        
        foreach($this->arguments as $argument) {
            $commandString .= " " . escapeshellarg($argument);
        }
        
        return trim($commandString);
    }
    
    private function shellExecute ($commandString, &$stdout="", &$stderr="")
    {
        $proc = proc_open(
            $commandString,
            array(
                0 => array("pipe", "r"),
                1 => array("pipe", "w"),
                2 => array("pipe", "w")
            ),
            $pipes,
            $this->workingDirPath
        );
        
        if (!is_resource($proc)) {
            throw new Exception("Cannot execute '$commandString' in '{$this->workingDirPath}'.");
        }
        
        // STDIN
        fclose($pipes[0]);
        
        // STDOUT
        $stdout = stream_get_contents($pipes[1]);
        fclose($pipes[1]);
        
        // STDERR
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[2]);
        
        return proc_close($proc);
    }
}
?>

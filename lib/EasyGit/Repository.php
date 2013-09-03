<?php
namespace EasyGit;

class Repository
{
    private $dirPath;
    
    private $dateFormat = "iso";
    private $logFormat  = "'%H|%T|%an|%ae|%ad|%cn|%ce|%cd|%s'";
    
    
    protected function __construct ($dirPath)
    {
        $this->dirPath = $dirPath;
    }
    
    public static function open ($dirPath)
    {
        $repo = new Repository($dirPath);
        $repo->ensureValidGitRepo();
        
        return $repo;
    }
    
    public static function create ($dirPath)
    {
        if(!is_dir($dirPath)) {
            FSUtils::mkdir($dirPath);
        }
        
        $repo = new Repository($dirPath);
        $repo->git('init');
        $repo->ensureValidGitRepo();
        
        return $repo;
    }
    
    public static function cloneFromUrl ($url, $dirPath)
    {
        $command = new Command(getcwd(), 'git', array('clone', $url, $dirPath));
        $command->run();
        
        return self::open($dirPath);
    }
    
    public function getDirPath ()
    {
        return $this->dirPath;
    }
    
    public function getCurrentBranch ()
    {
        $output = $this->git('branch');
        $lines = $this->splitIntoLines($output);
        
        foreach($lines as $line) {
            if($line[0] == '*') {
                return trim(substr($line, 1));
            }
        }
        
        throw new Exception("Cannot get the current branch.");
    }
    
    public function getBranches ()
    {
        $output = $this->git('branch');
        $lines = $this->splitIntoLines($output);
        
        array_walk($lines, function(&$line) {
            $line = trim( preg_replace('/^\*/', '', $line) );
        });
        return array_filter($lines);
    }
    
    public function getTags ()
    {
        $output = $this->git('branch');
        $lines = $this->splitIntoLines($output);
        
        return array_filter($lines);
    }
    
    public function git ($gitCommand, $arguments=array())
    {
        $gitCommandSplitted = explode(" ", $gitCommand);
        $gitCommand = array_shift($gitCommandSplitted);
        $arguments = array_merge($gitCommandSplitted, $arguments);
        
        array_unshift($arguments, $gitCommand);
        $command = new Command($this->dirPath, 'git', $arguments);
        
        return $command->run();
    }
    
    protected function ensureValidGitRepo ()
    {
        try {
            if(!file_exists("{$this->dirPath}/.git")) {
                throw new Exception("{$this->dirPath}/.git does not exist.");
            }
            
            $this->git('status');
        } catch(Exception $e) {
            throw new Exception("Directory seems not to be a valid git repository: {$this->dirPath}", $e);
        }
    }
    
    private function splitIntoLines ($string)
    {
        return explode("\n", $string);
    }
}
?>

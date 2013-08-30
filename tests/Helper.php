<?php
namespace EasyGit\tests;

use \EasyGit\FSUtils;

require_once __DIR__ . "/../EasyGit.php";

class Helper
{
    private static $testRepoPath = null;
    
    public static function getTestRepoPath ()
    {
        if(self::$testRepoPath) {
            return self::$testRepoPath;
        }
        
        self::$testRepoPath = self::generateTestDirectoryPath();
        if(is_dir(self::$testRepoPath)) {
            FSUtils::remove(self::$testRepoPath);
        }
        
        self::setupTestRepo(self::$testRepoPath);
        return self::$testRepoPath;
    }
    
    public static function createTestDirectory ()
    {
        $dirPath = self::generateTestDirectoryPath();
        FSUtils::mkdir($dirPath);
        
        return $dirPath;
    }
    
    public static function generateTestDirectoryPath ()
    {
        return "/tmp/" . uniqid("easygit-test-");
    }
    
    public static function removeTestDirectory ($dirPath)
    {
        FSUtils::remove($dirPath);
    }
    
    
    private static function setupTestRepo ($dirPath)
    {
        if(!is_dir($dirPath)) {
            FSUtils::mkdir($dirPath);
        }
        
        $cwd = getcwd();
        chdir($dirPath);
        
        exec("git init");
        exec("touch test");
        exec("git add .");
        exec("git commit -m 'Initial commit.'");
        
        chdir($cwd);
    }
}
?>

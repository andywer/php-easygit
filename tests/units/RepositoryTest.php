<?php
namespace EasyGit\tests\units;

use \mageekguy\atoum;
use \EasyGit;
use \EasyGit\tests\Helper;

require_once __DIR__ . "/../../EasyGit.php";
require_once __DIR__ . "/../Helper.php";

class Repository extends atoum\test
{
    public function testOpen ()
    {
        $dirPath = Helper::getTestRepoPath();
        $repo = EasyGit\Repository::open($dirPath);
        
        $this->assertGitRepository($repo, $dirPath);
    }
    
    public function testCreate ()
    {
        $dirPath = Helper::createTestDirectory();
        $repo = EasyGit\Repository::create($dirPath);
        
        $this->assertGitRepository($repo, $dirPath);
        
        $this->assert("Git repository should have been created: $dirPath")
            ->boolean(is_dir("$dirPath/.git"))->isTrue();
        
        Helper::removeTestDirectory($dirPath);
    }
    
    public function testCloneFromUrl ()
    {
        $dirPath = Helper::generateTestDirectoryPath();
        $repo = EasyGit\Repository::cloneFromUrl("https://github.com/heroku/node-js-sample.git", $dirPath);
        
        $fileName = "README.md";
        $this->assert("$fileName file should be present in cloned repository: $dirPath")
            ->boolean(is_file("$dirPath/$fileName"))->isTrue();
        
        Helper::removeTestDirectory($dirPath);
    }
    
    public function testGetCurrentBranch ()
    {
        $repo = EasyGit\Repository::open( Helper::getTestRepoPath() );
        $repo->git('checkout -f master');
        
        $branchName = $repo->getCurrentBranch();
        $this->assert("Current branch should equal 'master'")
            ->string($branchName)->isEqualTo("master");
    }
    
    public function testGetBranches ()
    {
        $repo = EasyGit\Repository::open( Helper::getTestRepoPath() );
        $branches = $repo->getBranches();
        
        $this->assert("Should return the master branch.")
            ->array($branches)->contains("master");
        
        foreach($branches as $branch) {
            $this->assert("Expecting a valid branch name: $branch")
                ->integer(preg_match('/^[\w-]+$/', $branch))->isGreaterThan(0);
        }
    }
    
    public function testGit ()
    {
        $repo = EasyGit\Repository::open( Helper::getTestRepoPath() );
        $output = $repo->git('status');
        
        $this->assert("Expected git status output like '# On branch XXXXX...'")
            ->string($output)->match('/^# On branch [\w-]+/');
    }
    
    private function assertGitRepository ($repo, $directoryPath)
    {
        $this->assert("Expected a valid Repository instance")
            ->object($repo)->isInstanceOf('EasyGit\\Repository');
        
        $this->assert("Repository::getDirPath() should return '$directoryPath'")
            ->string($repo->getDirPath())->isEqualTo($directoryPath);
    }
}
?>

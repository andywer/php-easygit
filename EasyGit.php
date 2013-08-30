<?php
    $easyGitClasses = array(
        'Exception',
        'GitException',
        'FSUtils',
        'Command',
        'Repository'
    );
    
    foreach($easyGitClasses as $className) {
        require_once "lib/EasyGit/$className.php";
    }
?>

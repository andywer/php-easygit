<?php
namespace EasyGit;

class FSUtils
{
    public static function copy ($filePathFrom, $filePathTo)
    {
        $status = copy($filePathFrom, $filePathTo);
        if(!$status) {
            throw new Exception("Cannot copy file: $filePathFrom => $filePathTo");
        }
    }
    
    /** Copies a file or directory (recursively). */
    public static function cp ($from, $to)
    {
        if(is_dir($from)) {
            if(!is_dir($to)) {
                self::mkdir($to);
            }
            
            $files = scandir($from);
            foreach($files as $file) {
                if($file == "." || $file == "..") {
                    continue;
                }
                
                $filePath = "$from/$file";
                if($filePath != $to) {
                    self::cp($filePath, "$to/$file");
                }
            }
        } else {
            self::copy($from, $to);
        }
    }
    
    public static function mkdir ($dirPath)
    {
        $status = @mkdir($dirPath);
        if(!$status) {
            throw new Exception("Cannot create directory: $dirPath");
        }
    }
    
    public static function rmdir ($dirPath)
    {
        $status = @rmdir($dirPath);
        if(!$status) {
            throw new Exception("Cannot remove directory: $dirPath");
        }
    }
    
    /** Removes a file or directory (recursively). */
    public static function remove ($path)
    {
        if(is_dir($path)) {
            $files = scandir($path);
            foreach($files as $file) {
                if($file == "." || $file == "..") {
                    continue;
                }
                
                self::remove("$path/$file");
            }
            self::rmdir($path);
        } else {
            $status = @unlink($path);
            if(!$status) {
                throw new Exception("Cannot remove file: $path");
            }
        }
    }
}
?>

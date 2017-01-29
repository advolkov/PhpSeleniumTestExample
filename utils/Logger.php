<?php

class Logger
{
    private $path_to_log_file;

    public function __construct($path_to_log_file)
    {
        $this->path_to_log_file = $path_to_log_file;
    }

    public function writeMsg($msg)
    {
        $msg = "[" . date("M d H:i:s." . str_pad(microtime() * 1e6, 6, "0", STR_PAD_LEFT)) . "]: $msg\n";
        $this->saveLogToFile($msg);
    }

    private function saveLogToFile($msg)
    {
        if (!is_dir(dirname($this->path_to_log_file))) {
            $this->createLogDir(dirname($this->path_to_log_file));
        }
        file_put_contents($this->path_to_log_file, $msg, FILE_APPEND);
    }

    private function createLogDir($dir_path)
    {
        $created = mkdir($dir_path, $mode = 0777, true);
        if (!$created) {
            throw new Exception("Unable to create dir: $dir_path");
        }
    }
}

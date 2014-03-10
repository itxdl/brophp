<?php

namespace brophp\brolog\handler;
use  brophp\brolog\handle\ProcessInterface;

class FileHandle
{
    private static $path = './log';
    private static $handle;
    private static $file;
    private $record;
    
    public function __construct($path='./log')
    {
        self::$path = $path;
        if(!is_dir($path)){
            @mkdir($path);
        }
    }
    
    public static function write($record)
    {
        self::$file = rtrim(self::$path,'/').'/'.$record['level_name'].date('Y-m-d',$record['datatime']).'.log';
        self::$handle = fopen(self::$file,'a');
        if (is_writable(self::$file)) {

            if (!self::$handle) {
                throw new \Exception('无法打开日志文件');
            }
            
            $record = json_encode ($record);
            
            if (fwrite(self::$handle, $record) === FALSE) {
                 throw new \Exception('写入日志到失败');
            }

            return true;

          

        } else {
            throw new \Exception('日志文件不可写');
        }     
    }
    
    public function __destruct()
    {
      fclose(self::$handle);
    }
}
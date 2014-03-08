<?php

/**
 *
 *
 *
 */
 
namespace brophp\brolog;
 
use brophp\brolog\hander\LoggerInterface;

/**
 *
 *
 *
 */
 
class Logger extends LoggerInterface
{
    /**
     * 详细的debug信息
     */ 
    const DEBUG = 100;
    
    /**
     * 需要记录的事件
     *
     * 例:用户登录
     */
    const INFO = 200;
	 
    /**
     * 不正常的信息
     *
     */
    const WANRING = 300;
	 
	/**
     * 运行错误
     */
    const ERROR = 400;
	 
    /**
     * 危机情况
     */
    const CRITICAL = 500;
	 
    /**
     * 必须马上处理
     */ 
    const ALERT = 550;
    
    protected static $levels = array(
        100 => 'DEBUG',
        200 => 'INFO',
        300 => 'WARNING',
        400 => 'ERROR',
        500 => 'CRITICAL',
        550 => 'ALERT',
        600 => 'EMERGENCY',
    );
    
    /**
     * 处理日志方式
     */
    private $processors;
    
    /**
     * @param mix $processors 日志处理方法,如果一种处理方法则传一个处理对像,如果使用多种处理方法则传一个数组数组的值为对象
     */
    public function __construct($processors)
    {
        if(is_object($processors)){
            $this -> processors = $processors;
        }else{
            throw new Exception('参数必须为对像');
        }
        
        if(is_array($processors)){
            foreach($processors as $value){
                if(is_object($processors)){
                    $this -> processors = $processors;
                }else{
                    throw new Execption('参数必须为对像');
                }
            }
        }
    }
    
    /**
     * 得到日志级别的名字
     *
     * @param integer $level
     * @return string
     */
    public static function getLevelName($level)
    {
        return self::$levels[$level];
    }
    
    /**
     * 增加日志记录
     *
     * @param integer $level 日志的级别
     * @param string $message 日志信息
     * @param array $context 日志环境
     * @return Boolean 日志是否已经被处理
     */
    public function addRecord($level, $message, array $context = array())
    {
        $record = array(
            'message'    => (string) $message;
            'context'    => $context;
            'level'      => $level;
            'level_name' => self::getLevelName($level);
            'datatime'   => time();
            'extra'      => array(),
        );
        
        if(is_array($this -> processors)){
            foreach($this -> processors as $processor){
                $record = call_user_func($processor, $record);
            }
        }else{
            $record = call_user_func($this -> $processor, $record);
        }
        
        return true;
    }
        
    /**
     * 增加ALERT级别的日志
     *
     * @param string $message 日志信息
     * @param array $context 日志环境
     * @return Boolean 日志是否已经被处理
     */
    public function alert($message, array $context = array())
    {
        return $this -> addRecord(self::ALERT, $message, $context);
    }
    
    /**
     * 增加DEBUG级别的日志
     *
     * @param string $message 日志信息
     * @param array $context 日志环境
     * @return Boolean 日志是否已经被处理
     */
    public function debug($message, array $context = array())
    {
        return $this -> addRecord(self::DEBUG, $message, $context);
    }
    
    /**
     * 增加INFO级别的日志
     *
     * @param string $message 日志信息
     * @param array $context 日志环境
     * @return Boolean 日志是否已经被处理
     */
    public function info($message, array $context = array())
    {
        return $this -> addRecord(self::INFO, $message, $content);
    }
    
    /**
     * 增加提示级别的日志
     *
     * @param string $message 日志信息
     * @param array $context 日志环境
     * @return Boolean 日志是否已经被处理
     */
    public function notice($message, array $context = array())
    {
        return $this->addRecord(self::NOTICE, $message, $context);
    }
    
    /**
     * 增加警告级别的日志
     *
     * @param string $message 日志信息
     * @param array $context 日志环境
     * @return Boolean 日志是否已经被处理
     */
    public function warning($message, array $context = array())
    {
        return $this->addRecord(self::WARNING, $message, $context);
    }
    
    /**
     * 增加错误级别的日志
     *
     * @param string $message 日志信息
     * @param array $context 日志环境
     * @return Boolean 日志是否已经被处理
     */
    public function error($message, array $context = array())
    {
        return $this->addRecord(self::ERROR, $message, $context);
    }
    
    /**
     * 增加危机级别的日志
     *
     * @param string $message 日志信息
     * @param array $context 日志环境
     * @return Boolean 日志是否已经被处理
     */
    public function critical($message, array $context = array())
    {
        return;
    }
    
    /**
     * 增加系统错误级别的日志
     *
     * @param string $message 日志信息
     * @param array $context 日志环境
     * @return Boolean 日志是否已经被处理
     */
    public function emergency($message, array $context = array())
    {
        return $this->addRecord(self::EMERGENCY, $message, $context);
    }
    
    /**
     * 增加任意级别的日志
     *
     * @param string $level 日志级别
     * @param string $message 日志信息
     * @param array $context 日志环境
     * @return Boolean 日志是否已经被处理
     */
    public function log($level, $message, array $context = array())
    {
        if(is_string($level) && defined(__CLASS__.'::'.strtoupper($level))){
            $level = constant(__CLASS__.'::'.strtoupper($level));
        }
        
        return $this -> addRecord($level, $message, $context);
    } 
 }
<?php
/**
 *
 *
 *
 */
 
namespace brophp\brolog;
use brophp\brolog\handle\LoggerInterface;

/**
 *
 *
 *
 */
 
class Logger
{
    /**
     * ��ϸ��debug��Ϣ
     */ 
    const DEBUG = 100;
    
    /**
     * ��Ҫ��¼���¼�
     *
     * ��:�û���¼
     */
    const INFO = 200;
	 
    /**
     * ����������Ϣ
     *
     */
    const WANRING = 300;
	 
	/**
     * ���д���
     */
    const ERROR = 400;
	 
    /**
     * Σ�����
     */
    const CRITICAL = 500;
	 
    /**
     * �������ϴ���
     */ 
    const ALERT = 550;
    
    const EMERGENCY = 600;
    
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
     * ������־��ʽ
     */
    private $processors;
    
    /**
     * @param mix $processors ��־������,���һ�ִ�������һ���������,���ʹ�ö��ִ�������һ�����������ֵΪ����
     */
    public function __construct($processors)
    {
        if(is_object($processors)){
            $this -> processors = $processors;
        }else if(is_array($processors)){
            foreach($processors as $value){
               if(is_obiect($value)){
                   $this -> processors = $value;
               }else{
                    throw new \Exception('���������ֵ����Ϊ���ڵ�����,������ʵ��ProcessInterface�е�write����');
               }
           }
        }else{
            throw new \Exception('��������Ϊ���ڵ�����,������ʵ��ProcessInterface�е�write����');
        }
    }
    
    /**
     * �õ���־���������
     *
     * @param integer $level
     * @return string
     */
    public static function getLevelName($level)
    {
        return self::$levels[$level];
    }
    
    /**
     * ������־��¼
     *
     * @param integer $level ��־�ļ���
     * @param string $message ��־��Ϣ
     * @param array $context ��־����
     * @return Boolean ��־�Ƿ��Ѿ�������
     */
    public function addRecord($level, $message, array $context = array())
    {
        $record = array(
            'message'    => (string) $message,
            'context'    => $context,
            'level'      => $level,
            'level_name' => self::getLevelName($level),
            'datatime'   => time(),
            'extra'      => array(),
        );
        
        if(is_array($this -> processors)){
            foreach($this -> processors as $processors){
                $record = call_user_func(array($processors,'write'), $record);
            }
        }else{
            $record = call_user_func(array($this -> processors,'write'), $record);
        }
        if($record){
            return true;
        }else{
            return false;
        }
    }
        
    /**
     * ����ALERT�������־
     *
     * @param string $message ��־��Ϣ
     * @param array $context ��־����
     * @return Boolean ��־�Ƿ��Ѿ�������
     */
    public function alert($message, array $context = array())
    {
        return $this -> addRecord(self::ALERT, $message, $context);
    }
    
    /**
     * ����DEBUG�������־
     *
     * @param string $message ��־��Ϣ
     * @param array $context ��־����
     * @return Boolean ��־�Ƿ��Ѿ�������
     */
    public function debug($message, array $context = array())
    {
        return $this -> addRecord(self::DEBUG, $message, $context);
    }
    
    /**
     * ����INFO�������־
     *
     * @param string $message ��־��Ϣ
     * @param array $context ��־����
     * @return Boolean ��־�Ƿ��Ѿ�������
     */
    public function info($message, array $context = array())
    {
        return $this -> addRecord(self::INFO, $message, $content);
    }
    
    /**
     * ������ʾ�������־
     *
     * @param string $message ��־��Ϣ
     * @param array $context ��־����
     * @return Boolean ��־�Ƿ��Ѿ�������
     */
    public function notice($message, array $context = array())
    {
        return $this->addRecord(self::NOTICE, $message, $context);
    }
    
    /**
     * ���Ӿ��漶�����־
     *
     * @param string $message ��־��Ϣ
     * @param array $context ��־����
     * @return Boolean ��־�Ƿ��Ѿ�������
     */
    public function warning($message, array $context = array())
    {
        return $this->addRecord(self::WARNING, $message, $context);
    }
    
    /**
     * ���Ӵ��󼶱����־
     *
     * @param string $message ��־��Ϣ
     * @param array $context ��־����
     * @return Boolean ��־�Ƿ��Ѿ�������
     */
    public function error($message, array $context = array())
    {
        return $this->addRecord(self::ERROR, $message, $context);
    }
    
    /**
     * ����Σ���������־
     *
     * @param string $message ��־��Ϣ
     * @param array $context ��־����
     * @return Boolean ��־�Ƿ��Ѿ�������
     */
    public function critical($message, array $context = array())
    {
        return;
    }
    
    /**
     * ����ϵͳ���󼶱����־
     *
     * @param string $message ��־��Ϣ
     * @param array $context ��־����
     * @return Boolean ��־�Ƿ��Ѿ�������
     */
    public function emergency($message, array $context = array())
    {
        return $this->addRecord(self::EMERGENCY, $message, $context);
    }
    
    /**
     * �������⼶�����־
     *
     * @param string $level ��־����
     * @param string $message ��־��Ϣ
     * @param array $context ��־����
     * @return Boolean ��־�Ƿ��Ѿ�������
     */
    public function log($level, $message, array $context = array())
    {
        if(is_string($level) && defined(__CLASS__.'::'.strtoupper($level))){
            $level = constant(__CLASS__.'::'.strtoupper($level));
        }
        
        return $this -> addRecord($level, $message, $context);
    } 
 }

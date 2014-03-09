<?php

namespace borphp\brolog\handle;

interface ProcessInterface
{
    /**
     * 写入日志接口
     *
     * @param array $record
     * @return void
     */
    abstract protected function write(array $record);
}
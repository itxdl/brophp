<?php

namespace borphp\brolog\handle;

interface ProcessInterface
{
    /**
     * д����־�ӿ�
     *
     * @param array $record
     * @return void
     */
    abstract protected function write(array $record);
}
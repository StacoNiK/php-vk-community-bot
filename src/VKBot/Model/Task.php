<?php namespace VKBot\Model;

class Task
{
    public $id = 0;
    public $data = [];
    public $timestamp = 0;
    public $status = 0;

    public function __construct($id, $data, $timestamp, $status)
    {
        $this->id = $id;
        $this->data = $data;
        $this->timestamp = $timestamp;
        $this->status = $status;
    }
}
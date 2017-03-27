<?php namespace VKBot;

class Queue
{
    protected $database = false;
    protected $table_name = 'queue';

    public function __construct(Database\Database $db)
    {
        $this->database = $db;
    }

    public function add($data)
    {
        $json = json_encode($data);
        $this->database->query("INSERT INTO `".$this->table_name."` SET `data` = ?, `timestamp` = ?, `status` = ?", $json, time(), 0);
    }

    public function getTask()
    {
        $result = $this->database->query("SELECT * FROM `".$this->table_name."` WHERE `status` = 0 LIMIT 1");
        if ($result->rowCount() > 0) {
            $item = $result->fetch(\PDO::FETCH_OBJ);
            $task = new Task($item->id, json_decode($item->data, true), $item->timestamp, $item->status);
            return $task;
        }
        return false;
    }

    public function setDoneTask($task_id)
    {
        $this->setTaskStatus($task_id, 2);
    }

    public function setWorkedTask($task_id)
    {
        $this->setTaskStatus($task_id, 1);
    }

    protected function setTaskStatus($task_id, $status)
    {
        $this->database->query("UPDATE `".$this->table_name."` SET `status` = ? WHERE `id` = ?", $status, $task_id);
    }
}
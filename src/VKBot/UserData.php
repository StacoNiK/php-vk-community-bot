<?php namespace VKBot;

class UserData
{
    protected $database = false;
    protected $table_name = 'users';

    public function __construct(Database\Database $db)
    {
        $this->database = $db;
    }

    public function exists($vk_id)
    {
        $result = $this->database->query("SELECT * FROM `".$this->table_name."` WHERE `vk_id` = ?  LIMIT 1", $vk_id);
        if ($result->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public function add($vk_id, $data, $state)
    {
        $json = json_encode($data);
        $last_activity = time();
        $this->database->query("INSERT INTO `".$this->table_name."` SET `vk_id` = ?, `data` = ?, `state` = ?, `last_activity` = ?", $vk_id, $json, $state, $last_activity);
    }

    public function setByVkId($vk_id, $key, $value)
    {
        $this->database->query("UPDATE `".$this->table_name."` SET `".$key."` = ? WHERE `vk_id` = ?  LIMIT 1", $value, $vk_id);
    }

    public function getByVkId($vk_id)
    {
        $result = $this->database->query("SELECT * FROM `".$this->table_name."` WHERE `vk_id` = ?  LIMIT 1", $vk_id);
        $data = $result->fetch(PDO::FETCH_OBJ);
        return $data;
    }
}
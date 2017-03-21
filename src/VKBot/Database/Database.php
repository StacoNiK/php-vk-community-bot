<?php namespace VKBot\Database;

class Database
{
    protected $database;

    public function __construct($host, $user, $password, $name)
    {
        $dsn = "mysql:host=".$host.";dbname=".$name.";charset=utf8";
        try {
            $this->database = new \PDO($dsn, $user, $password);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getDatabase()
    {
        return $this;
    }

    public function query()
    {
        $arg_list = func_get_args();
        $count = func_num_args();
        for ($i = 1; $i < $count; $i++) {
            $arg_list[$i-1] = $arg_list[$i];
        }
        unset($arg_list[$count-1]);
        $q = $this->database->prepare(func_get_arg(0));
        $q->execute($arg_list);
        return $q;
    }

    public function aQuery($query, $data) //запрос с массивом параметров
    {
        $q = $this->database->prepare($query);
        $i = 1;
        foreach ($data as $value) {
            $q->bindValue($i, $value);
            ++$i;
        }
        $q->execute();
        return $q;
    }
}
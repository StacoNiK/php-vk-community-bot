<?php namespace VKBot;

class ActionList
{
    protected $items = [];
    protected $count = 0;

    public function __construct($array = [])
    {
        if (is_array($array)) {
            foreach ($array as $item) {
                if (!is_array($item)) {
                    continue;
                }
                if (!array_key_exists(0, $item) || !array_key_exists(1, $item)) {
                    continue;
                }
                ++$this->count;
                $this->items[] = [
                        "number" => $this->count,
                        "key" => $item[0],
                        "name" => $item[0],
                    ];
            }
        }
    }

    public function addItem($key, $name)
    {
        ++$this->iterator;
        $items[] = [
                "number" => $this->count,
                "key" => $key,
                "name" => $name
            ];
    }

    public function getListText()
    {
        $i = 0;
        $str_arr = [];
        foreach ($this->items as $item) {
            ++$i;
            $str_arr[] = $item['number'].'. '.$item['name'];
        }
        return implode("\n", $str_arr);
    }

    public function runAction($number, \VKBot\Model\User $user, $message = '')
    {
        $key = $this->getKeyByNumber($number);
        if (!$key) {
            return false;
        }
        $method = 'action'.ucfirst($key);
        if (!method_exists($this, $method)) {
            return false;
        }
        call_user_func_array([$this, $method], [$user, $message]);
        return true;
    }

    protected function getKeyByNumber($number) 
    {
        foreach ($this->items as $item) {
            if ($item['number'] == $number) {
                return $item['key'];
            }
        }
        return false;
    }
}
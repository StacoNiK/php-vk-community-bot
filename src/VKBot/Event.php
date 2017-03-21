<?php namespace VKBot;

class Event
{
    protected $confirmation_token = '';
    protected $on_message_listener = false;

    public function __construct($confirmation_token = '')
    {
        $this->confirmation_token = $confirmation_token;
    }

    public function getEvent()
    {
        $data = json_decode(file_get_contents('php://input'));
        if (!property_exists($data, 'type')) {
            return false;
        }

        $result = false;
        switch ($data->type) { 
            case 'message_new':
                $this->onBeforeEventMessage($data->object);
                if ($this->on_message_listener) {
                    $this->on_message_listener($data->object);
                }
                $result = $this->onMessage($data->object);
                break;
            case 'message_allow':
                $result = $this->onMessageAllow($data->object->user_id);
                break;
            case 'message_deny':
                $result = $this->onMessageDeny($data->object->user_id);
                break;
            case 'confirmation':
                echo $this->confirmation_token;
                break;
        }
        return $result;
    }

    public function setOnMessageListener($listener)
    {
        $this->on_message_listener = $listener;
    }

    protected function onMessage($message)
    {
        
    }

    protected function onMessageAllow($user_id, $key = '')
    {

    }

    protected function onMessageDeny($user_id)
    {

    }

    protected function onBeforeEventMessage($message)
    {
        \VKBot\CommandManager::searchCommandOnText($message);
    }
} 
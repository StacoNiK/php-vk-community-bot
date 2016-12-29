<?php namespace VKBot;

class CommandManager
{
    protected static $commands = [];

    public static function addCommand(\VkBot\Command $command_obj)
    {
        self::$commands[] = $command_obj;
    }

    public static function searchCommandOnMessage($message)
    {
        $text = $message->body;
        foreach (self::$commands as $command) {
            $names = self::getAllNames($command);
            foreach ($names as $name) {
                if (strpos($text, '/'.$name) !== false) {
                    self::runCommand($command, $message);
                    break;
                }
            }
        }
    }

    protected static function getAllNames($command)
    {
        $names = $command->aliases;
        $names[] = $command->name;
        return $names;
    }

    protected static function runCommand($command, $message)
    {
        $command->execute($message);
        return true;
    }
}
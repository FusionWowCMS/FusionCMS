<?php

interface Emulator
{
    public function getExpansions();
    public function getExpansionName($id);
    public function getExpansionId($name);
    public function sendCommand($command);
    public function hasConsole();
    public function hasStats();
    public function sendItems($character, $subject, $body, $items);
    public function sendMail($character, $subject, $body);
    public function getTable($name);
    public function getColumn($table, $name);
    public function getQuery($name);
    public function getAllColumns($table);
    public function encrypt($username, $password);
    public function __construct($config);
}

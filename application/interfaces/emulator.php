<?php

interface Emulator
{
    public function sendCommand($command, $realm = false);
    public function hasConsole();
    public function hasStats();
    public function hasTotp();
    public function sendItems($character, $subject, $body, $items);
    public function sendMail($character, $subject, $body);
    public function getTable($name);
    public function getColumn($table, $name);
    public function getQuery($name);
    public function getAllColumns($table);
    public function __construct($config);
}

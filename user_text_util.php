<?php

include_once __DIR__.'/core.php';

$sepMap = [
    'comma' => ',',
    'semicolon' => ';',
];
$taskMap = [
    'countAverageLineCount' => TaskCountAverageLine::class,
    'replaceDates' => TaskReplaceDates::class,
];

$cliParams = parseArgs($argv);
if (count($cliParams) != 2) {
    throw new InvalidArgumentException("Неверное кол-во параметров. Вызов: $argv[0] separator task");
}
if (!isset($sepMap[$cliParams[0]])) {
    throw new InvalidArgumentException('Неверный параметр разделителя');
}
if (!isset($taskMap[$cliParams[1]])) {
    throw new InvalidArgumentException('Указанная задача не найдена');
}
$sep = $sepMap[$cliParams[0]];
$taskClass = $taskMap[$cliParams[1]];

$peopleFile = __DIR__.'/people.csv';
if (!file_exists($peopleFile)) {
    throw new \Exception('Файл с пользователями не найден');
}

$People = new People();
foreach (file($peopleFile) as $line) {
    $data = str_getcsv($line, $sep);
    if (count($data) >= 2) {
        $user = $People->createUser($data[0], $data[1]);
        $user->loadTexts();
    }
}

if ($People->countUsers() > 0) {
    $Task = new $taskClass();
    $People->accept($Task);
    echo $Task->getLabel().PHP_EOL;
    echo $Task->getText();
} else {
    echo 'Не удалось найти пользователей в файле';
}
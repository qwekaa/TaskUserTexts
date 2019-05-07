<?php

/**
 * Класс задачи для подсчета среднего кол-ва строк в файлах
 */
class TaskCountAverageLine extends Task
{
    public function process(User $user)
    {
        $lines = [];
        foreach ($user->getTexts() as $text) {
            $lines[] = $this->countLines($text);
        }
        $this->text.= $user->getName().': '.(!empty($lines) ? array_sum($lines)/count($lines) : 0).PHP_EOL;
    }
    
    protected function countLines($text)
    {
        return count(preg_split('/\n/', $text));
    }

    public function getLabel()
    {
        return 'Среднее количество строк:';
    }

}
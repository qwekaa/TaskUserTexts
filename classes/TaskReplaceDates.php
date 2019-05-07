<?php

/**
 * Класс задачи для замены даты из формата dd/mm/yy на даты в формате mm-dd-yyyy
 * и запись вывода в output_texts
 */
class TaskReplaceDates extends Task
{
    public function process(User $user)
    {
        $match = [];
        $stat = 0;
        foreach ($user->getTexts() as $file_name => $text) {
            preg_match_all('/\d{2}\/\d{2}\/\d{2}/', $text, $match);
            if (empty($match[0])) {
                continue;
            }
            $replace = [];
            foreach ($match[0] as $v) {
                $time = strtotime($v);
                if ($time == false) {
                    $newDate = $v;
                } else {
                    $newDate = date('m-d-Y', $time);
                    $stat++;
                }
                $replace[$v] = $time == false ? $v : date('m-d-Y', $time);
            }
            $this->put_content($file_name, str_replace(array_keys($replace), array_values($replace), $text));
        }
        $this->text.= $user->getName().': '. $stat.PHP_EOL;
    }
    
    
    protected function put_content($file_name, $content)
    {
        if (!file_exists(__DIR__.'/output_texts')) {
            mkdir(__DIR__.'/output_texts');
        }
        file_put_contents(__DIR__."/output_texts/$file_name", $content);
    }
    
    public function getLabel()
    {
        return 'Заменить даты и поместить тексты в output_texts:';
    }
}
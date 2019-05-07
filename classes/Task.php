<?php

/**
 * 
 */
abstract class Task
{
    protected $text = '';
    
    /**
     * Метод для выполнения задачи
     * @param User $user
     */
    abstract public function process(User $user);
    
    /**
     * Получить метку/краткое описание задачи
     */
    abstract public function getLabel();

    /**
     * Результат выполнения в тектовом виде
     * 
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}
<?php

/**
 * Класс содержит данные о пользователе и его файлах
 */
class User
{
    private $id;
    
    private $name;
    
    private $texts;
    
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function addText($text, $filename)
    {
        $this->texts[$filename] = $text;
    }
    
    public function getTexts()
    {
        $this->loadTexts();
        return $this->texts;
    }

    public function loadTexts()
    {
        if (is_null($this->texts)) {
            $this->texts = [];
            $files = glob(__DIR__."/../texts/$this->id-*.txt");
            foreach ($files as $file) {
                $this->texts[basename($file)] = file_get_contents($file);
            }
        }
    }
}
<?php

namespace Karamel\Localization;
class Lang
{
    public static $instance;
    private $content;

    public function __construct()
    {
        $this->content = [
            'files' => [],
            'keys' => []
        ];
    }

    public static function getInstance()
    {
        if (self::$instance == null)
            self::$instance = new Lang();
        return self::$instance;
    }

    public function get($key, $replace = [])
    {
        $data = explode(".", $key);
        if (count($data) < 2)
            return null;

        $this->LOAD($data[0]);
        if (!isset($this->content['keys'][$data[1]]))
            return null;

        return str_replace(array_keys($replace), array_values($replace), $this->content['keys'][$data[1]]);
    }

    public function LOAD($file)
    {
        if (in_array($file, $this->content['files']))
            return null;

        $lang = [];
        ob_start();
        require_once KM_LANG_FILES . '/' . env('DEF_LANGUAGE', 'en') . '/' . $file . '.php';
        ob_end_clean();

        if (!is_array($lang))
            return null;

        if (count($lang) == 0)
            return null;

        foreach ($lang as $key => $value)
            $this->content['keys'][$key] = $value;

        $this->content['files'][] = $file;
        return null;
    }
}
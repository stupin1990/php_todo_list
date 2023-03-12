<?php

namespace Src\Core;

class View
{
    /**
     * @var array variables from $_REQUEST arrays
     */
    private array $request = [];

    /**
     * Render template with layout
     * @param string $template_name
     * @param array $data
     * @param string $layout
     * 
     * @return void
     */
    public function render(string $template_name, $data = [], string $layout = 'main') : void
    {
        if (!isset($data['title'])) {
            $data['title'] = Config::TITLE;
        }

        $url = explode('?', $_SERVER['REQUEST_URI']);
        $url = $url[0];
        $params = preg_replace("/([\&]{0,1}page\=[0-9]{1,}[\&]{0,1})|([\&]{0,1}success\=[0-9]{1,}[\&]{0,1})/", '', $_SERVER['QUERY_STRING']);
        $url .= ($params ? "?{$params}&" : '?');
        $data['url'] = $url;

        foreach ($data as $key => $val) {
            $$key = $val;
        }

        include_once __DIR__ . '/../Views/Layouts/' . $layout . '.php';
    }

    /**
     * Render only view without layout
     * @param string $template_name
     * @param array $data
     * 
     * @return void
     */
    public function renderPartial(string $template_name, $data = []) : void
    {
        foreach ($data as $key => $val) {
            $$key = $val;
        }

        include_once __DIR__ . '/../Views/' . $template_name . '.php';
    }

    /**
     * Check for undefined values in $_REQUEST array
     * @param mixed $name
     * 
     * @return [type]
     */
    public function __get($name)
    {
        if (isset($this->request[$name])) {
            return $this->request[$name];
        }

        $this->request[$name] = '';
        if (isset($_REQUEST[$name])) {
            $this->request[$name] = htmlentities($_REQUEST[$name]);
        }

        return $this->request[$name];
    }
}

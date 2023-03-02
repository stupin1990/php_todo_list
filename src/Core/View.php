<?php

namespace Src\Core;

class View
{
    public function render(string $template_name, $data = [], string $layout = 'main')
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

    public function renderPartial(string $template_name, $data = [])
    {
        foreach ($data as $key => $val) {
            $$key = $val;
        }

        include_once __DIR__ . '/../Views/' . $template_name . '.php';
    }
}
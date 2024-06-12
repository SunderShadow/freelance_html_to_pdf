<?php

namespace Tools;

class View
{
    public string $templateDir = __DIR__ . '/pages/';

    public function view(string $filename, ...$params)
    {
        if (count($params) === 1 && is_array($params[0])) {
            $params = $params[0];
        }

        extract($params);
        require $this->templateDir . '/' . $filename . '.php';
    }

    public function viewWithoutRender(string $filename, ...$params): string
    {
        if (count($params) === 1 && is_array($params[0])) {
            $params = $params[0];
        }
        ob_start();
        $this->view($filename, $params);
        return ob_get_clean();
    }
}
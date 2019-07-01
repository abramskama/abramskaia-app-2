<?php declare(strict_types = 1);

namespace App\Template;

class FrontendTwigRenderer implements FrontendRenderer
{
    private $renderer;

    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function render($template, $data = []) : string
    {
        $data;
        return $this->renderer->render($template, $data);
    }
}
<?php declare(strict_types = 1);

namespace App\Template;

interface FrontendRenderer extends Renderer
{
    public function render($template, $data = []) : string;
}
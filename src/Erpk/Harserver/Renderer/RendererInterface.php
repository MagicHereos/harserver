<?php
namespace Erpk\Harserver\Renderer;

interface RendererInterface
{
    public function render($response, $viewModel);
}

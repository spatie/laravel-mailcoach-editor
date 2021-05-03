<?php

namespace Spatie\MailcoachEditor;

abstract class Renderer
{
    public function __construct(protected array $data)
    {
    }

    abstract public function render(): string;
}

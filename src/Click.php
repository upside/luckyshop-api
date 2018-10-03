<?php
namespace luckyShopApi;

class Click
{
    public $click;

    public function __construct($click)
    {
        $this->click = is_array($click) ? implode($click) : $click;
    }
}
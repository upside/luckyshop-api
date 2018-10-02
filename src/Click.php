<?php
/**
 * Created by PhpStorm.
 * User: upside
 * Date: 02.10.18
 * Time: 22:51
 */

namespace luckyshopApi;


class Click
{
    public $click;

    public function __construct($click)
    {
        $this->click = is_array($click) ? implode($click) : $click;
    }

}
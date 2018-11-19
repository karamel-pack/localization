<?php
function __($key, $replace = [])
{
    return \Karamel\Localization\Lang::getInstance()->get($key, $replace);
}

function trans($key, $replace = [])
{
    return __($key, $replace);
}
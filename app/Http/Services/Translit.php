<?php
namespace Anticafe\Http\Services;

class Translit
{

    private static $translit = array(

    "А" => "A",
    "Б" => "B",
    "В" => "V",
    "Г" => "G",
    "Д" => "D",
    "Е" => "E",
    "Ё" => "E",
    "Ж" => "ZH",
    "З" => "Z",
    "И" => "I",
    "Й" => "I",
    "К" => "K",
    "Л" => "L",
    "М" => "M",
    "Н" => "N",
    "О" => "O",
    "П" => "P",
    "Р" => "R",
    "С" => "S",
    "Т" => "T",
    "У" => "U",
    "Ф" => "F",
    "Х" => "H",
    "Ц" => "C",
    "Ч" => "CH",
    "Ш" => "SH",
    "Щ" => "SH",
    "Ъ" => "'",
    "Ы" => "Y",
    "Ъ" => "'",
    "Э" => "E",
    "Ю" => "U",
    "Я" => "YA",
    "а" => "a",
    "б" => "b",
    "в" => "v",
    "г" => "g",
    "д" => "d",
    "е" => "e",
    "ё" => "e",
    "ж" => "zh",
    "з" => "z",
    "и" => "i",
    "й" => "i",
    "к" => "k",
    "л" => "l",
    "м" => "m",
    "н" => "n",
    "о" => "o",
    "п" => "p",
    "р" => "r",
    "с" => "s",
    "т" => "t",
    "у" => "u",
    "ф" => "f",
    "х" => "h",
    "ц" => "c",
    "ч" => "ch",
    "ш" => "sh",
    "щ" => "sh",
    "ъ" => "'",
    "ы" => "y",
    "ъ" => "'",
    "э" => "e",
    "ю" => "u",
    "я" => "ya",
    );

    public static function toTranslit($text)
    {
        return strtr($text, static::$translit); // транслитерация. Переменная $word получит значение 'prochee'
    }

    public static function reverseTraslit($text)
    {
        return strtr($text, array_flip(static::$translit));
    }

}
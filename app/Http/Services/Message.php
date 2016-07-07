<?php
/**
 * Created by PhpStorm.
 * User: scrobot91
 * Date: 07.07.2016
 * Time: 15:16
 */

namespace Anticafe\Http\Services;


class Message
{
    public $text;
    public $badge = 1;
    public $sound = 'example.aiff';
    public $actionLocKey = 'Action button title!';
    public $locKey = 'localized key';
    public $locArgs = [];
    public $launchImage = 'image.jpg';

    /**
     * Message constructor.
     * @param $text
     * @param string $actionLocKey
     */
    public function __construct($text, $actionLocKey)
    {
        $this->text = $text;
        $this->actionLocKey = $actionLocKey;
    }


    public function attrs()
    {
        return [
            'badge' => $this->badge,
            'sound' => $this->sound,

            'actionLocKey' => $this->actionLocKey,
            'locKey' => $this->locKey,
            'locArgs' => $this->locArgs,
            'launchImage' => $this->launchImage,
        ];
    }

}
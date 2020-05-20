<?php

namespace app\components\utility;

use Yii;
use yii\helpers\Url;

class FormatApiResponse
{
    /**
     * Add base url host to file path
     *
     * @param string $path
     * @return string
     */
    public static function addHost($path)
    {
        return Url::base(true) . '/' . $path;
    }

    /**
     * Get video code from youtube url
     *
     * @param string $url
     * @return string
     */
    public static function getYoutubeEmbedCode($url)
    {
        $youtube_id = null;
        $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
        $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';

        if (preg_match($longUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }

        if (preg_match($shortUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }
        return $youtube_id ;
    }

    /**
     * Sort array of arrays by order param
     *
     * @param array $array
     * @return array
     */
    public static function sortByOrder($array)
    {
        usort($array, function ($a, $b) {
            if ($a['order'] == $b['order']) {
                return 0;
            }
            return ($a['order'] < $b['order']) ? -1 : 1;
        });
        return $array ;
    }
    
}

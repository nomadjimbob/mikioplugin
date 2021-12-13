<?php
if (!defined('DOKU_INC')) define('DOKU_INC', dirname(__FILE__) . '/../../../');
require_once(DOKU_INC . 'inc/init.php');

class CarouselRenderer extends Doku_Renderer
{
    public function getFormat()
    {
        return 'xhtml';
    }
};

$core = new syntax_plugin_mikioplugin_core();
$renderer = new CarouselRenderer();

if (isset($_GET['id'])) {
    $content = rawWiki($_GET['id']);
    preg_match('/<carousel[^-item].*?>.*?<\/carousel>/s', $content, $matches);
    if (count($matches) > 0) {
        preg_match('/<[^\/].*?>/s', $matches[0], $tags);
        foreach ($tags as $tag) {
            preg_match_all('/([^\r\n\t\f\v<>= \'"]+)(?:=(["\'])?((?:.(?!\2?\s+(?:\S+)=|\2))+[^>])\2?)?/', $tag, $attributes);

            if (count($attributes) > 0) {
                $tagName = $attributes[1][0];
                $tagAttribs = array();

                for ($i = 1; $i < count($attributes[1]); $i++) {
                    $value = $attributes[3][$i];
                    if (strlen($value) == 0) {
                        $value = true;
                    }

                    $tagAttribs[$attributes[1][$i]] = $value;
                }

                $core->syntaxRender($renderer, $tagName, '', $tagAttribs);
            }
        }

        echo '<html lang=en><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"><link type="text/css" rel="stylesheet" href="assets/external.css"/><link type="text/css" rel="stylesheet" href="css.php?css=/assets/variables.less,/assets/styles.less"/><script src="../../scripts/jquery/jquery.min.js"></script><script src="script.js"></script></head><body id="dokuwiki__content">';
        echo $renderer->doc;
        echo '</body></html>';
    } else {
        die('No carousels where found on the page');
    }
} else {
    die('No page id was set in the url');
}


/*
<carousel slide start dynamic-prefix="IMAGINED THING" dynamic=engagement:grumpus:grumpuslandonline:rrldev:thewell>

Array
(
    [0] => Array
        (
            [0] => carousel
            [1] => slide
            [2] => start
            [3] => dynamic-prefix="IMAGINED THING"
            [4] => dynamic=engagement:grumpus:grumpuslandonline:rrldev:thewell
        )

    [1] => Array
        (
            [0] => carousel
            [1] => slide
            [2] => start
            [3] => dynamic-prefix
            [4] => dynamic
        )

    [2] => Array
        (
            [0] => 
            [1] => 
            [2] => 
            [3] => "
            [4] => 
        )

    [3] => Array
        (
            [0] => 
            [1] => 
            [2] => 
            [3] => IMAGINED THING
            [4] => engagement:grumpus:grumpuslandonline:rrldev:thewell
        )

)

*/
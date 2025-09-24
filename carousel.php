<?php
if (!defined('DOKU_INC')) define('DOKU_INC', __DIR__ . '/../../../');
require_once(DOKU_INC . 'inc/init.php');

$core = new syntax_plugin_mikioplugin_core();
$renderer = new Doku_Renderer_xhtml();

if (isset($_GET['id'])) {
    $content = rawWiki($_GET['id']);
    preg_match_all('/<carousel[^-item].*?>.*?<\/carousel>/s', $content, $matches);

    $carousel_index = 0;
    if (isset($_GET['carousel'])) {
        $carousel_index = $_GET['carousel'];
        if ($carousel_index > count($matches[0])) {
            die('The page does not have ' . $carousel_index . ' carousels');
        }

        $carousel_index--;
    } else {
        if (count($matches[0]) <= 0) {
            die('No carousels where found on the page');
        }
    }

    preg_match_all('/<[^\/].*?>/s', $matches[0][$carousel_index], $tags);
    foreach ($tags[0] as $tag) {
        preg_match_all('/([^\r\n\t\f\v<>= \'"]+)(?:=(["\'])?((?:.(?!\2?\s+(?:\S+)=|\2))+[^>])\2?)?/', $tag, $attributes);

        if (count($attributes) > 0) {
            $tagName = $attributes[1][0];
            $tagAttribs = array();
            $count = count($attributes[1]);

            for ($i = 1; $i < $count; $i++) {
                $value = $attributes[3][$i];
                if (strlen($value) == 0) {
                    $value = true;
                }

                $tagAttribs[$attributes[1][$i]] = $value;
            }

            if (strcasecmp($tagName, 'carousel') == 0) {
                $core->syntaxRender($renderer, $tagName, '', $tagAttribs, MIKIO_LEXER_ENTER);
            } else if (strcasecmp($tagName, 'carousel-item') == 0) {
                $core->syntaxRender($renderer, $tagName, '', $tagAttribs, MIKIO_LEXER_SPECIAL);
            }
        }
    }

    $core->syntaxRender($renderer, 'carousel', '', $tagAttribs, MIKIO_LEXER_EXIT);

    echo '<html lang=en><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"><link type="text/css" rel="stylesheet" href="assets/external.css"/><link type="text/css" rel="stylesheet" href="css.php?css=/assets/variables.less,/assets/styles.less"/></head><body id="dokuwiki__content">';
    echo $renderer->doc;
    echo '<script src="../../scripts/jquery/jquery.min.js"></script><script src="script.js"></script>';
    echo '</body></html>';
} else {
    die('No page id was set in the url');
}

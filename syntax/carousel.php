<?php

/**
 * Mikio Syntax Plugin: Carousel
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN', DOKU_INC . 'lib/plugins/');
require_once(__DIR__ . '/core.php');

class syntax_plugin_mikioplugin_carousel extends syntax_plugin_mikioplugin_core
{
    public $tag                 = 'carousel';
    public $hasEndTag           = true;
    public $options             = array(
        'transition'    => array(
            'type'     => 'choice',
            'data'     => array('slide', 'fade'),
            'default'  => ''
        ),
        'indicators'    => array(
            'type'     => 'choice',
            'data'     => array('true', 'false', 'circle'),
            'default'  => 'true'
        ),
        'controls'      => array('type'     => 'boolean',   'default'   => 'true'),
        'start'         => array('type'     => 'boolean',   'default'   => 'false'),
        'cover'         => array('type'     => 'boolean',   'default'   => 'false'),
        'control-color' => array('type'     => 'color',     'default'   => '#fff'),
        'control-outline-color' => array('type'     => 'color',     'default'   => ''),
        'control-outline-width' => array('type'     => 'multisize',     'default'   => ''),
        'dynamic' => array('type' => 'text', 'default' => ''),
        'dynamic-prefix' => array('type' => 'text', 'default' => ''),
        'dynamic-start' => array('type' => 'number', 'default' => '-1'),
        'dynamic-count' => array('type' => 'number', 'default' => '-1'),
    );

    public function __construct()
    {
        $this->addCommonOptions('height');
    }


    public function render_lexer_enter(Doku_Renderer $renderer, $data)
    {
        $classes = $this->buildClass($data, array('transition'));
        $styles = $this->buildStyle(array('height' => $data['height'] ?? ''), TRUE);

        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'carousel' . ($data['cover'] ? ' ' . $this->classPrefix . 'image-cover' : '') . $classes . '" data-auto-start="' . ($data['start'] ? 'true' : 'false') . '"' . $styles . '>';
        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'carousel-inner">';

        if (strlen($data['dynamic']) > 0) {
            global $conf;

            $namespace = $data['dynamic'];
            if (substr($namespace, -1) === ':') {
                $namespace = substr($namespace, 0, -1);
            }

            $path = str_replace(':', '/', $namespace);

            $pages = array();
            $count = count($pages);

            search($pages, $conf['datadir'] . '/' . $path, 'search_allpages', array('depth' => 1, 'skipacl' => true));

            for ($i = 0; $i < $count; $i++) {
                $page = $pages[$i];
                if ($data['dynamic-start'] == -1 || $data['dynamic-start'] <= ($i + 1)) {
                    if ($data['dynamic-start'] != -1 && $data['dynamic-count'] != -1 && $data['dynamic-start'] + $data['dynamic-count'] >= $i) {
                        break;
                    }

                    $item_data = array();

                    $page_id = $namespace . ':' . $page['id'];
                    preg_match('/{{([^>|}]+(\.jpg|\.gif|\.png))\|?.*}}/', rawWiki($page_id), $image_matches);
                    if (count($image_matches) > 1) {
                        $item_data['image'] = $image_matches[1];
                    }

                    $item_data['title'] = (strlen($data['dynamic-prefix']) > 0 ? $data['dynamic-prefix'] . ' ' : '') . p_get_first_heading($page_id);
                    $item_data['url'] = $page_id;

                    $this->syntaxRender($renderer, 'carouselitem', '', $item_data, MIKIO_LEXER_SPECIAL);
                }
            }
        }
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data)
    {
        $renderer->doc .= '</div>';

        if ($data['controls'] === TRUE) {
            $svg_styles = $this->buildStyle(array('fill' => $data['control-color'] ?? '', 'stroke' => $data['control-outline-color'] ?? '', 'stroke-width' => $data['control-outline-width'] ?? ''), TRUE);

            $renderer->doc .= '<a href="#" class="' . $this->elemClass . ' ' . $this->classPrefix . 'carousel-control ' . $this->classPrefix . 'carousel-control-prev" role="button"><svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 8 8"' . $svg_styles . '><path d="M5.25 0l-4 4 4 4 1.5-1.5L4.25 4l2.5-2.5L5.25 0z"/></svg></a>';
            $renderer->doc .= '<a href="#" class="' . $this->elemClass . ' ' . $this->classPrefix . 'carousel-control ' . $this->classPrefix . 'carousel-control-next" role="button"><svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 8 8"' . $svg_styles . '><path d="M2.75 0l-1.5 1.5L3.75 4l-2.5 2.5L2.75 8l4-4-4-4z"/></svg></a>';
        }

        if (strcasecmp($data['indicators'], 'false') != 0) {
            $renderer->doc .= '<ul class="' . $this->elemClass . ' ' . $this->classPrefix . 'carousel-indicators' . (strcasecmp($data['indicators'], 'circle') == 0 ? ' ' . $this->classPrefix . 'carousel-indicators-circle' : '') . '"></ul>';
        }

        $renderer->doc .= '</div>';
    }
}

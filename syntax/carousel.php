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
require_once(dirname(__FILE__) . '/core.php');

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
        'indicators'    => array('type'     => 'boolean',   'default'   => 'true'),
        'controls'      => array('type'     => 'boolean',   'default'   => 'true'),
        'start'         => array('type'     => 'boolean',   'default'   => 'false'),
        'cover'         => array('type'     => 'boolean',   'default'   => 'false'),
        'control-color' => array('type'     => 'color',     'default'   => '#fff'),
        'control-outline-color' => array('type'     => 'color',     'default'   => ''),
        'control-outline-width' => array('type'     => 'multisize',     'default'   => ''),
    );

    public function __construct()
    {
        $this->addCommonOptions('height');
    }


    public function render_lexer_enter(Doku_Renderer $renderer, $data)
    {
        $classes = $this->buildClass($data, array('transition'));
        $styles = $this->buildStyle(array('height' => $data['height']), TRUE);

        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'carousel' . ($data['cover'] ? ' ' . $this->classPrefix . 'image-cover' : '') . $classes . '" data-auto-start="' . ($data['start'] ? 'true' : 'false') . '"' . $styles . '>';
        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'carousel-inner">';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data)
    {
        $renderer->doc .= '</div>';

        if ($data['controls'] === TRUE) {
            $svg_styles = $this->buildStyle(array('fill' => $data['control-color'], 'stroke' => $data['control-outline-color'], 'stroke-width' => $data['control-outline-width']), TRUE);

            $renderer->doc .= '<a href="#" class="' . $this->elemClass . ' ' . $this->classPrefix . 'carousel-control ' . $this->classPrefix . 'carousel-control-prev" role="button"><svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 8 8"' . $svg_styles . '><path d="M5.25 0l-4 4 4 4 1.5-1.5L4.25 4l2.5-2.5L5.25 0z"/></svg></a>';
            $renderer->doc .= '<a href="#" class="' . $this->elemClass . ' ' . $this->classPrefix . 'carousel-control ' . $this->classPrefix . 'carousel-control-next" role="button"><svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 8 8"' . $svg_styles . '><path d="M2.75 0l-1.5 1.5L3.75 4l-2.5 2.5L2.75 8l4-4-4-4z"/></svg></a>';
        }

        if ($data['indicators'] === TRUE) {
            $renderer->doc .= '<ul class="' . $this->elemClass . ' ' . $this->classPrefix . 'carousel-indicators"></ul>';
        }

        $renderer->doc .= '</div>';
    }
}

<?php
/**
 * Mikio Syntax Plugin: Carousel Item
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(__DIR__.'/core.php');
 
class syntax_plugin_mikioplugin_carouselitem extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'carousel-item';
    public $requires_tag        = 'carousel';
    public $hasEndTag           = false;
    public $options             = array(
        'active'                    => array('type' => 'boolean',   'default'   => 'false'),
        'image'                     => array('type' => 'media',     'default'   => ''),
        'title'                     => array('type' => 'text',      'default'   => ''),
        'text'                      => array('type' => 'text',      'default'   => ''),
        'url'                       => array('type' => 'url',       'default'   => ''),
        'background-color'         => array('type' => 'color',     'default'   => ''),
        'placeholder-text'          => array('type' => 'text',      'default'   => ''),
        'placeholder-text-color'   => array('type' => 'color',     'default'   => ''),
        'placeholder-color'        => array('type' => 'color',     'default'   => ''),
        'delay'                     => array('type' => 'float',    'default'   =>'4.5'),
    );
    
    public function __construct() {
        $this->options['placeholder-color']['default'] = $this->callMikioOptionDefault('placeholder', 'color');
        $this->options['placeholder-text-color']['default'] = $this->callMikioOptionDefault('placeholder', 'text-color');
    }

    
    public function render_lexer_special(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClass($data, array('active'), '');

        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'carousel-item' . $classes . '"' . ($data['delay'] != '' ? ' data-interval="' . $data['delay'] . '"' : '') . '>';
        

        if(!empty($data['image'])) {
            $renderer->doc .= '<img src="' . $data['image'] . '">';
        } else {
            if(!empty($data['placeholder-text'])) {
                $this->syntaxRender($renderer, 'placeholder', '', array('text' => $data['placeholder-text'] ?? '', 'color' => $data['placeholder-color'] ?? '', 'text-color' => $data['placeholder-text-color'] ?? ''));
            }
        }
        
        if($data['title'] != '' || $data['text'] != '') {
            $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'carousel-caption">';

            if(!empty($data['title'])) {
                $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'carousel-caption-title">' . ($data['url'] != '' ? '<a href="' . $data['url'] . '">' : '') . $data['title'] . ($data['url'] != '' ? '</a>' : '') . '</div>';
            }

            if(!empty($data['text'])) {
                $renderer->doc .= '<p>' . $data['text'] . '</p>';
            }

            $renderer->doc .= '</div>';
        }
        
        $renderer->doc .= '</div>';
    }

}
?>
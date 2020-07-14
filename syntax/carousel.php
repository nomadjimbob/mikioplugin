<?php
/**
 * Mikio Syntax Plugin: Carousel
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_carousel extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'carousel';
    public $hasEndTag           = true;
    public $options             = array(
        'transition'    => array('type'     => 'choice',
                                 'data'     => array('slide', 'fade'),
                                 'default'  => ''),
        'indicators'    => array('type'     => 'boolean',   'default'   => 'true'),
        'controls'      => array('type'     => 'boolean',   'default'   => 'true'),
        'start'         => array('type'     => 'boolean',   'default'   => 'false'),
    );
    
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClass($data, array('transition'));

        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'carousel' . $classes . '" data-auto-start="' . ($data['start'] ? 'true' : 'false') . '">';
        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'carousel-inner">';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</div>';
      
        if($data['controls'] === TRUE) {
            $renderer->doc .= '<a href="#" class="' . $this->elemClass . ' ' . $this->classPrefix . 'carousel-control ' . $this->classPrefix . 'carousel-control-prev" role="button"></a>';
            $renderer->doc .= '<a href="#" class="' . $this->elemClass . ' ' . $this->classPrefix . 'carousel-control ' . $this->classPrefix . 'carousel-control-next" role="button"></a>';
        }

        if($data['indicators'] === TRUE) {
            $renderer->doc .= '<ul class="' . $this->elemClass . ' ' . $this->classPrefix . 'carousel-indicators"></ul>';
        }

        $renderer->doc .= '</div>'; 
    }
}
?>
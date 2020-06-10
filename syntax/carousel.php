<?php
/**
 * Mikio Syntax Plugin: Carousel
 *
 * Syntax:  <CAROUSEL [slide] [fade] [controls] [indicators=]></CAROUSEL>
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_carousel extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'carousel';
    public $options             = array('slide', 'fade', 'indicators', 'indicator-active', 'controls');
    
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClassString($data, array('slide', 'fade'), array('carousel-' => 'fade'));

        $this->values['id'] = 'carousel_'.rand(0, 32767);

        $renderer->doc .= '<div class="carousel ' . $classes . '" data-ride="carousel" id="' . $this->values['id'] . '"' . $this->buildStyleString($data) . '>';
                
        if(array_key_exists('indicators', $data) && $data['indicators'] > 0) {
            $indicatorActive = 0;
            if(array_key_exists('indicator-active', $data)) $indicatorActive = intval($data['indicator-active']);

            $renderer->doc .= '<ol class="carousel-indicators">';
            for($i = 0; $i < intval($data['indicators']); $i++) {
                $renderer->doc .= '<li data-target="#' . $this->values['id'] . '" data-slide-to="' . $i . '"' . ($i == $indicatorActive ? ' class="active"' : ''). '></li>';
            }
            $renderer->doc .= '</ol>';
        }

        $renderer->doc .= '<div class="carousel-inner">';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</div>';
      
        if(array_key_exists('controls', $this->values) && $this->values['controls'] != false) {
            $id = $this->values['id'];

            $renderer->doc .= '<a class="carousel-control-prev" href="#' . $id . '" role="button" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span></a><a class="carousel-control-next" href="#' . $id . '" role="button" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span></a>';
        }

        $renderer->doc .= '</div>'; 
    }
}
?>
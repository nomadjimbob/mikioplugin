<?php
/**
 * Mikio Syntax Plugin: BOX
 *
 * Syntax:  <BOX [round=]></BOX>
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_box extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'box';
    public $options             = array('round');
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClassString($data);
        
        $style = '';
        if(array_key_exists('round', $data)) {
            if($data['round'] != '' && $data['round'] !== true) {
                if(is_numeric($data['round'])) {
                    $style = 'border-radius:'.$data['round'].'px';
                } else {
                    $style = 'border-radius:'.$data['round'];
                }
            } else if($data['round'] === true) {
                $style = 'border-radius:10px';
            }
        }

        $renderer->doc .= '<div class="box ' . $classes . '"' . $this->buildStyleString($data, null, $style) . '>';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</div>'; 
    }
}
?>
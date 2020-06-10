<?php
/**
 * Mikio Syntax Plugin: Alert
 *
 * Syntax:  <ALERT [primary|secondary|success|danger|warning|info|light|dark] [dismissible]></ALERT>
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_alert extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'alert';
    public $defaults            = array('type' => 'primary');
    public $options             = array(
        'type' => array('primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'),
        'dismissible'
    );
    
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClassString($data, array('type', 'dismissible'), 'alert-');

        $renderer->doc .= '<div class="alert ' . $classes . '" role="alert"' . $this->buildStyleString($data) . '>';

        if(isset($data['dismissible']) && $data['dismissible'] == true) {
            $renderer->doc .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        }
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '</div>'; 
    }
}
?>
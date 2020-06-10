<?php
/**
 * Mikio Syntax Plugin: Icon
 *
 * Syntax:  <ICON>
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_icon extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'icon';
    public $noEndTag            = true;
    public $privateOptions      = true;
    
    
    public function render_lexer_special(Doku_Renderer $renderer, $data) {

        $icon = $this->getFirstArrayKey($data);

        if(is_string($icon)) {
            if(substr($icon, 0, 3) != 'fa-') $icon = 'fa-' . $icon;
        } else {
            $icon = '';
        }

        $renderer->doc .= '<i class="fa ' . $icon . '"></i>';
    }
}
?>
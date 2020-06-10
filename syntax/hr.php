<?php
/**
 * Mikio Syntax Plugin: HR
 *
 * Syntax:  <HR> or ----
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_hr extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'hr';
    public $noEndTag            = true;
    

    public function connectTo($mode) {
        $this->Lexer->addSpecialPattern('----', $mode, 'plugin_mikioplugin_'.$this->getPluginComponent());
        parent::connectTo($mode);
    }


    public function render_lexer_special(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClassString($data);
        
        $renderer->doc .= '<hr class="' . $classes . '"' . $this->buildStyleString($data) . '>';
    }
}
?>
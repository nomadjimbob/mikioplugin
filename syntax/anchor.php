<?php
/**
 * Mikio Syntax Plugin: Anchor
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

require_once(__DIR__.'/core.php');
 
class syntax_plugin_mikioplugin_anchor extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'anchor';
    public $hasEndTag           = false;
    public $options             = array(
        'id'        => array('type' => 'text',  'default'   => ''),
    );
    
    public function getType() { return 'substition'; }
    public function getPType() { return 'normal'; }

    public function render_lexer_special(Doku_Renderer $renderer, $data) {
        if(!empty($data['id'])) {
            $renderer->doc .= '<a id="' . $data['id'] . '"></a>';
        }
    }
}
?>
<?php
/**
 * Mikio Syntax Plugin: Set Attr
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(__DIR__.'/core.php');

class syntax_plugin_mikioplugin_setattr extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'setattr';
    public $hasEndTag           = false;
    public $attrs               = null;

    public function __construct() {
        $this->attrs = array();
    }

    public function getType() { return 'substition'; }
    public function getPType() { return 'normal'; }

    public function render_lexer_special(Doku_Renderer $renderer, $data) {
        if(array_key_exists('name', $data)) {
            $a = $data;
            unset($a['name']);

            if(!is_array($this->attrs)) $this->attrs = array();

            $this->attrs[$data['name']] = $a;
        }

        $renderer->doc .= '';
    }

    public function mikioCall($data) {
        if(is_array($this->attrs) && array_key_exists($data, $this->attrs)) {
            return $this->attrs[$data];
        }

        return array();
    }
}
?>
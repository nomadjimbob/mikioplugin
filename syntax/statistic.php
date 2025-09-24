<?php
/**
 * Mikio Syntax Plugin: Statistic
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */ 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(__DIR__.'/core.php');
 
class syntax_plugin_mikioplugin_statistic extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'statistic';
    public $hasEndTag           = false;
    public $options             = array(
        'title'     => array('type'     => 'text',    'default'   => ''),
        'number'    => array('type'     => 'number',  'default'   => ''),
        'below'     => array('type'     => 'boolean', 'default'   => 'false')
    );

    public function __construct() {

    }
    
    
    public function render_lexer_special(Doku_Renderer $renderer, $data) {
        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'statistic">';
        if($data['below']) $renderer->doc .= number_format($data['number']);
        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'statistic-title">' . $data['title'] . '</div>';
        if(!$data['below']) $renderer->doc .= number_format($data['number']);
        $renderer->doc .= '</div>';
    }
}
?>
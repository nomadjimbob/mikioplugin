<?php
/**
 * Mikio Syntax Plugin: Progress Bar
 *
 * Syntax:  <PROGRESSBAR [width=] [height=] [striped] [animated] [text=]>
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(dirname(__FILE__).'/core.php');
 
class syntax_plugin_mikioplugin_progressbar extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'progressbar';
    public $noEndTag            = true;
    public $options             = array(
        'width',
        'height',
        'striped',
        'animated',
        'text',
        'type' => array('primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark')
    );
        //, 'outline-primary', 'outline-secondary', 'outline-success', 'outline-danger', 'outline-warning', 'outline-info', 'outline-light', 'outline-dark'),
    
    
    public function render_lexer_special(Doku_Renderer $renderer, $data) {
        $barClasses = $this->buildClassString($data, array('type', 'striped', 'animated'), array('bg-' => 'type', 'progress-bar-' => array('striped', 'animated')));

        $width = 0;
        if(array_key_exists('width', $data) && $data['width'] != '') {
            $width = $data['width'];
            if(substr($width, -1) == '%') $width = substr($width, 0, -1);
        }

        $height = '';
        if(array_key_exists('height', $data) && $data['height'] != false) {
            $height = $data['height'];

        }

        $renderer->doc .= '<div class="progress"'. ($height != '' ? ' style="height:' . $height . ';"' : '' ) . '><div class="progress-bar ' . $barClasses . '" role="progressbar" style="width:' . $width . '%" aria-valuenow="' . $width . '" aria-valuemin="0" aria-valuemax="100">' . (array_key_exists('text', $data) && $data['text'] != '' ? $data['text'] : '') . '</div></div>';
    }
}
?>
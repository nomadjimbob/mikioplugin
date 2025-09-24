<?php
/**
 * Mikio Syntax Plugin: Progress Bar
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(__DIR__.'/core.php');
 
class syntax_plugin_mikioplugin_progressbar extends syntax_plugin_mikioplugin_core {
    public $tag                 = 'progressbar';
    public $hasEndTag           = false;
    public $options             = array(
        'width'     => array('type'     => 'number',    'default'   => '0'),
        // 'height'    => array('type'     => 'size',      'default'   => '1em'),
        'striped'   => array('type'     => 'boolean',   'default'   => 'false'),
        'animated'  => array('type'     => 'boolean',   'default'   => 'false'),
        'text'      => array('type'     => 'text',      'default'   => ''),
        // 'type'      => array('type'     => 'choice',
        //                      'data'     => array('primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'),
        //                      'default'  => 'primary'),
    );

    public function __construct() {
        $this->addCommonOptions('height type');
        $this->options['type']['default'] = 'primary';
        $this->options['height']['default'] = '1.5em';
    }
    
    
    public function render_lexer_special(Doku_Renderer $renderer, $data) {
        $classes = $this->buildClass($data, array('striped', 'animated'));
        $styles = $this->buildStyle(array('height' => $data['height'] ?? ''), TRUE);

        $renderer->doc .= '<div class="' . $this->elemClass . ' mikiop-progress"' . $styles . '>';
        $renderer->doc .= '<div class="' . $this->elemClass . ' mikiop-progress-bar ' . $classes . '" role="progressbar" style="width:' . $data['width'] . '%" aria-valuenow="' . $data['width'] . '" aria-valuemin="0" aria-valuemax="100">' . $data['text'] . '</div>';
        $renderer->doc .= '</div>';
    }
}
?>
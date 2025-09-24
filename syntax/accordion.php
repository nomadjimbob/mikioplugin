<?php

/**
 * Mikio Syntax Plugin: Accordion
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN', DOKU_INC . 'lib/plugins/');
require_once(__DIR__ . '/core.php');

class syntax_plugin_mikioplugin_accordion extends syntax_plugin_mikioplugin_core
{
    public $tag                 = 'accordion';
    public $hasEndTag           = true;
    public $options             = array(
        'autoclose'   => array('type'     => 'boolean',   'default'   => 'false'),
    );

    public function __construct()
    {
        $this->addCommonOptions('shadow');
    }

    public function render_lexer_enter(Doku_Renderer $renderer, $data)
    {
        $classes = $this->buildClass($data, array('autoclose'));

        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'accordian' . $classes . '">';
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data)
    {
        $renderer->doc .= '</div>';
    }
}

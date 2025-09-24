<?php

/**
 * Mikio Syntax Plugin: HR
 *
 * @link        http://github.com/nomadjimbob/mikioplugin
 * @license     GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author      James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN', DOKU_INC . 'lib/plugins/');
require_once(__DIR__ . '/core.php');

class syntax_plugin_mikioplugin_hr extends syntax_plugin_mikioplugin_core
{
    public $tag                 = 'hr';
    public $hasEndTag           = false;


    public function connectTo($mode)
    {
        $this->Lexer->addSpecialPattern('----[\r\n]', $mode, 'plugin_mikioplugin_' . $this->getPluginComponent());
        parent::connectTo($mode);
    }


    public function render_lexer_special(Doku_Renderer $renderer, $data)
    {
        $classes = $this->buildClass($data);

        $renderer->doc .= '<hr class="' . $this->elemClass . ' ' . $this->classPrefix . 'hr">';
    }
}

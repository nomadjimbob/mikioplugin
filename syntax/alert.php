<?php
/**
 * Mikio Syntax Plugin: Alert
 *
 * @link    http://github.com/nomadjimbob/mikioplugin
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author  James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) { die();
}
if (!defined('DOKU_PLUGIN')) { define('DOKU_PLUGIN', DOKU_INC.'lib/plugins/');
}
require_once __DIR__.'/core.php';
 
class syntax_plugin_mikioplugin_alert extends syntax_plugin_mikioplugin_core
{
    public $tag                 = 'alert';
    public $hasEndTag           = true;
    public $options             = array(
        'dismissible'   => array('type'     => 'boolean',   'default'   => 'false'),
        'icon'          => array('type'     => 'text',      'default'   => ''),
    );
    
    public function __construct()
    {
        $this->addCommonOptions('type shadow width align text-align');
        $this->options['type']['default'] = 'primary';
    }
    
    public function getAllowedTypes()
    {
        return array('formatting', 'substition', 'disabled', 'container', 'protected'); 
    }
    public function getPType()
    {
        return 'normal'; 
    }    

    public function render_lexer_enter(Doku_Renderer $renderer, $data)
    {
        $classes = $this->buildClass($data, array('dismissible'));
        $styles = $this->buildStyle(array('width' => $data['width'] ?? ''), true);

        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'alert ' . $classes . '" role="alert"' . $styles . '>';

        if(!empty($data['icon'])) {
            $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'alert-icon">';
            $this->syntaxRender($renderer, 'icon', '', array_flip(explode(' ', $data['icon'])), MIKIO_LEXER_SPECIAL);
            $renderer->doc .= '</div>';
        }

        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'alert-content">';

        if($data['dismissible'] == true) {
            $renderer->doc .= '<a href="#" class="' . $this->elemClass . ' ' . $this->classPrefix . 'alert-close">&times;</a>';
        }
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data)
    {
        $renderer->doc .= '</div></div>'; 
    }
}
?>
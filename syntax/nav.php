<?php
/**
 * Mikio Syntax Plugin: Nav
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

class syntax_plugin_mikioplugin_nav extends syntax_plugin_mikioplugin_core
{
    public $tag                 = 'nav';
    public $hasEndTag           = true;
    public $options             = array(
        'icon'         => array('type'     => 'text',      'default'   => ''),
        'title'         => array('type'     => 'text',      'default'   => ''),
    );

    public function __construct()
    {
        $this->addCommonOptions('text-color height width');
    }
    
    public function getAllowedTypes()
    {
        return array('container'); 
    }
    
    public function render_lexer_enter(Doku_Renderer $renderer, $data)
    {
        $classes = $this->buildClass($data, array('overlay', 'horizontal'));
        $styles = $this->buildStyle(array('height' => $data['height'] ?? '', 'width' => $data['width'] ?? ''), true);

        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'nav' . $classes . '"' . $styles . '>';

        if($data['title'] != '' || $data['icon'] != '') {
            $renderer->doc .= '<div class="' . $this->classPrefix . 'nav-title">';
            if(!empty($data['icon'])) {
                $renderer->doc .= '<div class="' . $this->classPrefix . 'nav-icon">';
                $this->syntaxRender($renderer, 'icon', '', array_flip(explode(' ', $data['icon'])), MIKIO_LEXER_SPECIAL);
                $renderer->doc .= '</div>';
            }
            $renderer->doc .= $data['title'] . '</div>';
        }
    }

    public function render_lexer_exit(Doku_Renderer $renderer, $data)
    {
        $renderer->doc .= '</div>'; 
    }
}
?>
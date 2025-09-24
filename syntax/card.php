<?php
/**
 * Mikio Syntax Plugin: Card
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
 
class syntax_plugin_mikioplugin_card extends syntax_plugin_mikioplugin_core
{
    public $tag                 = 'card';
    public $hasEndTag           = true;
    public $options             = array(
        'image'                         => array('type' => 'media',     'default'   => ''),
        'image-cover'                   => array('type' => 'boolean',   'default'   => 'false'),
        'image-height'                  => array('type' => 'size',      'default'   => ''),
        'overlay'                       => array('type' => 'boolean',   'default'   => 'false'),
        'title'                         => array('type' => 'text',      'default'   => ''),
        'title-text-align'              => array('type' => 'choice',    'data'      => array(
            'left' => array('text-left'), 'center' => array('text-center'), 'right' => array('text-right')
        )),
        'title-text-color'              => array('type' => 'text',      'default'   => ''),
        'subtitle'                      => array('type' => 'text',      'default'   => ''),
        'subtitle-text-align'           => array('type' => 'choice',    'data'      => array(
            'left' => array('text-left'), 'center' => array('text-center'), 'right' => array('text-right')
        )),
        'subtitle-text-color'           => array('type' => 'text',      'default'   => ''),
        'no-body'                       => array('type' => 'boolean',   'default'   => 'false'),
        'header'                        => array('type' => 'text',      'default'   => ''),
        'header-text-align'             => array('type' => 'choice',    'data'      => array(
            'left' => array('text-left'), 'center' => array('text-center'), 'right' => array('text-right')
        )),
        'header-text-color'             => array('type' => 'text',      'default'   => ''),
        'footer'                        => array('type' => 'text',      'default'   => ''),
        'footer-text-align'             => array('type' => 'choice',    'data'      => array(
            'left' => array('text-left'), 'center' => array('text-center'), 'right' => array('text-right')
        )),
        'footer-text-color'             => array('type' => 'text',      'default'   => ''),
        'placeholder-text'              => array('type' => 'text',      'default'   => ''),
        'placeholder-color'             => array('type' => 'text',      'default'   => ''),
        'placeholder-text-color'        => array('type' => 'text',      'default'   => ''),
        'placeholder-height'            => array('type' => 'size',      'default'   => ''),
        'footer-image'                  => array('type' => 'media',     'default'   => ''),
        'footer-image-cover'            => array('type' => 'boolean',   'default'   => 'false'),
        'footer-placeholder-text'       => array('type' => 'text',      'default'   => ''),
        'footer-placeholder-color'      => array('type' => 'text',      'default'   => ''),
        'footer-placeholder-text-color' => array('type' => 'text',      'default'   => ''),
        'horizontal'                    => array('type' => 'boolean',   'default'   => 'false'),
        'footer-small'                  => array('type' => 'boolean',   'default'   => 'false'),
    );
    

    public function __construct()
    {
        $this->addCommonOptions('type shadow width height text-align vertical-align text-color align');
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
        $classes = $this->buildClass($data, array('overlay', 'horizontal'));
        $styles = $this->buildStyle(array('height' => $data['height'] ?? '', 'width' => $data['width'] ?? ''), true);

        $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'card' . $classes . '"' . $styles . '>';

        if($data['horizontal']) { $renderer->doc .= '<div class="' . $this->elemClass . ' ' . $this->classPrefix . 'card-horizontal-image">';
        }
        if(!empty($data['placeholder-text'])) {
            $this->syntaxRender($renderer, 'placeholder', '', $this->arrayRemoveEmpties(array('text' => $data['placeholder-text'] ?? '', 'color' => $data['placeholder-color'] ?? '', 'text-color' => $data['placeholder-text-color'] ?? '', 'height' => $data['placeholder-height'] ?? '')));
        } elseif(!empty($data['image'])) {
            $style = '';
            if(!empty($data['image-height'])) {
                $style = 'height:' . $data['image-height'] . ';';
            }
            $renderer->doc .= '<img src="' . $data['image'] . '" class="' . $this->elemClass . ' ' . $this->classPrefix . 'card-image' . ($data['image-cover'] ? ' ' . $this->classPrefix . 'image-cover' : '') . '" style="' . $style . '">';
        }
        if($data['horizontal']) { $renderer->doc .= '</div><div class="' . $this->elemClass . ' ' . $this->classPrefix . 'card-horizontal-body">';
        }
        
        if(!empty($data['header'])) {
            $this->syntaxRender($renderer, 'cardheader', $data['header'], $this->arrayRemoveEmpties(array('text-align' => $data['header-text-align'] ?? '', 'text-color' => $data['header-text-color'] ?? '')));
        }

        if($data['no-body'] == false) { $this->syntaxRender($renderer, 'cardbody', '', $this->arrayRemoveEmpties(array('vertical-align' => $data['vertical-align'] ?? '', 'text-color' => $data['text-color'] ?? '')), MIKIO_LEXER_ENTER);
        }
        
        if(!empty($data['title'])) {
            $this->syntaxRender($renderer, 'cardtitle', $data['title'], $this->arrayRemoveEmpties(array('text-align' => $data['title-text-align'] ?? '', 'text-color' => $data['title-text-color'] ?? '')));
        }

        if(!empty($data['subtitle'])) {
            $this->syntaxRender($renderer, 'cardsubtitle', $data['subtitle'], $this->arrayRemoveEmpties(array('text-align' => $data['subtitle-text-align'] ?? '', 'text-color' => $data['subtitle-text-color'] ?? '')));
        }
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data)
    {
        if($data['no-body'] == false) { $this->syntaxRender($renderer, 'cardbody', '', null, MIKIO_LEXER_EXIT);
        }

        if(!empty($data['footer'])) {
            $this->syntaxRender($renderer, 'cardfooter', $data['footer'], $this->arrayRemoveEmpties(array('small' => $data['footer-small'] ?? '', 'text-align' => $data['footer-text-align'] ?? '', 'text-color' => $data['footer-text-color'] ?? '')));
        }

        if(!empty($data['footer-placeholder-text'])) {
            $this->syntaxRender($renderer, 'placeholder', '', $this->arrayRemoveEmpties(array('text' => $data['footer-placeholder-text'] ?? '', 'color' => $data['footer-placeholder-color'] ?? '', 'text-color' => $data['footer-placeholder-text-color'] ?? '')));
        } elseif(!empty($data['footer-image'])) {
            $renderer->doc .= '<img src="' . $data['footer-image'] . '" class="' . $this->elemClass . ' ' . $this->classPrefix . 'card-image' . ($data['footer-image-cover'] ? ' ' . $this->classPrefix . 'image-cover' : '') .'">';
        }
        
        if($data['horizontal']) { $renderer->doc .= '</div>';
        }
        $renderer->doc .= '</div>'; 
    }
}
?>
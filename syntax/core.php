<?php
/**
 * Mikio Core Syntax Plugin
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     James Collins <james.collins@outlook.com.au>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

 
class syntax_plugin_mikioplugin_core extends DokuWiki_Syntax_Plugin {
    public $pattern_entry       = '';
    public $pattern_exit        = '';
    public $tag                 = '';
    public $noEndTag            = false;
    public $defaults            = array();
    public $options             = array();
    public $values              = array();
    public $incClasses          = array('shadow', 'shadow-none', 'shadow-sm', 'shadow-lg', 'w-25', 'w-50', 'w-75', 'w-100', 'w-auto', 'h-25', 'h-50', 'h-75', 'h-100', 'h-auto', 'text-left', 'text-center', 'text-right', 'text-justify', 'text-wrap', 'text-nowrap', 'text-truncate', 'text-break', 'text-lowercase', 'text-uppercase', 'text-capitalize', 'font-weight-bold', 'font-weight-bolder', 'font-weight-normal', 'font-weight-light', 'font-weight-lighter', 'font-italic', 'text-monospace', 'text-reset', 'text-muted', 'text-decoration-none', 'text-primary', 'text-secondary', 'text-success', 'text-danger', 'text-warning', 'text-info', 'text-light'. 'text-dark', 'text-body', 'text-white', 'text-black', 'text-white-50', 'text-black-50', 'bg-primary', 'bg-secondary', 'bg-success', 'bg-danger', 'bg-warning', 'bg-info', 'bg-light', 'bg-dark', 'bg-white', 'bg-transparent', 'border', 'border-top', 'border-right', 'border-bottom', 'border-left', 'border-0', 'border-top-0', 'border-right-0', 'border-bottom-0', 'border-left-0', 'border-primary', 'border-secondary', 'border-success', 'border-danger', 'border-warning', 'border-info', 'border-light', 'border-dark', 'border-white', 'rounded', 'rounded-top', 'rounded-right', 'rounded-bottom', 'rounded-left', 'rounded-circle', 'rounded-pill', 'rounded-0', 'rounded-sm', 'rounded-lg', 'clearfix', 'align-baseline', 'align-top', 'align-middle', 'align-bottom', 'align-text-top', 'align-text-bottom', 'sm-1', 'sm-2', 'sm-3', 'sm-4', 'sm-5', 'sm-6', 'sm-7', 'sm-8', 'sm-9', 'sm-10', 'sm-11', 'sm-12', 'md-1', 'md-2', 'md-3', 'md-4', 'md-5', 'md-6', 'md-7', 'md-8', 'md-9', 'md-10', 'md-11', 'md-12', 'lg-1', 'lg-2', 'lg-3', 'lg-4', 'lg-5', 'lg-6', 'lg-7', 'lg-8', 'lg-9', 'lg-10', 'lg-11', 'lg-12');
    public $incOptions          = array('width', 'min-width', 'max-width', 'height', 'min-height', 'max-height', 'overflow', 'tooltip', 'tooltip-html', 'tooltop-left', 'tooltip-top', 'tooltip-right', 'tooltip-bottom', 'tooltip-html-top', 'tooltip-html-left', 'tooltip-html-right', 'tooltip-html-bottom');


    function __construct() {
        if(count($this->incClasses) > 0) {
            $this->options = array_merge($this->options, $this->incClasses, $this->incOptions);
        }
    }

    public function getType() {
        return 'formatting';
    }
    
    
    public function getAllowedTypes() { return array('formatting', 'substition', 'disabled'); }   
    public function getSort(){ return 32; }


    public function connectTo($mode) {
        if($this->pattern_entry == '' && $this->tag != '') {
            if($this->noEndTag) {
                $this->pattern_entry = '<(?:' . strtoupper($this->tag) . '|' . strtolower($this->tag) . ').*?>';
            } else {
                $this->pattern_entry = '<(?:' . strtoupper($this->tag) . '|' . strtolower($this->tag) . ').*?>(?=.*?</(?:' . strtoupper($this->tag) . '|' . strtolower($this->tag) . ')>)';
            }
        }

        if($this->pattern_entry != '') {
            if($this->noEndTag) {
                $this->Lexer->addSpecialPattern($this->pattern_entry, $mode, 'plugin_mikioplugin_'.$this->getPluginComponent());
            } else {
                $this->Lexer->addEntryPattern($this->pattern_entry, $mode, 'plugin_mikioplugin_'.$this->getPluginComponent());
            }
        }
    }
    
    
    public function postConnect() {
        if(!$this->noEndTag) {
            if($this->pattern_exit == '' && $this->tag != '') {
                $this->pattern_exit = '</(?:' . strtoupper($this->tag) . '|' . strtolower($this->tag) . ')>';
            }

            if($this->pattern_exit != '') {
                $this->Lexer->addExitPattern($this->pattern_exit, 'plugin_mikioplugin_'.$this->getPluginComponent());
            }
        }
    }
   
    public function handle($match, $state, $pos, Doku_Handler $handler){
        switch($state) {
            case DOKU_LEXER_ENTER:
            case DOKU_LEXER_SPECIAL:
                $optionlist = preg_split('/\s(?=([^"]*"[^"]*")*[^"]*$)/', substr($match, strlen($this->tag) + 1, -1));
                
                $options = array();
                foreach($optionlist as $item) {
                    $i = strpos($item, '=');
                    if($i !== false) {
                        $value = substr($item, $i + 1);

                        if(substr($value, 0, 1) == '"') $value = substr($value, 1);
                        if(substr($value, -1) == '"') $value = substr($value, 0, -1);
                        
                        $options[substr($item, 0, $i)] = $value;
                    } else {
                        $options[$item] = true;
                    }
                }

                $options_clean = $this->cleanOptions($options);

                $this->values = $options_clean;

                return array($state, $options_clean);

            case DOKU_LEXER_UNMATCHED:
                return array($state, $match);
            
            case DOKU_LEXER_EXIT:
                return array($state, '');
        }
    
        return array();
    }


    public function cleanOptions($options) {
        $options_clean = array();

        foreach($this->options as $item => $value) {
            if(is_string($value)) {
                if(array_key_exists($value, $options)) {
                    $options_clean[$value] = $options[$value];
                } else {
                    $options_clean[$value] = false;
                }
            } else if(is_array($value)) {
                foreach($value as $avalue) {
                    if(array_key_exists($avalue, $options)) {
                        $options_clean[$item] = $avalue;
                    }
                }
            }
        }

        foreach($this->defaults as $item => $value) {
            if(array_key_exists($item, $options_clean) == false) {
                $options_clean[$item] = $value;
            }
        }

        return $options_clean;
    }
   

    public function render_lexer_enter(Doku_Renderer $renderer, $data) {

    }


    public function render_lexer_unmatched(Doku_Renderer $renderer, $data) {
        $renderer->doc .= $renderer->_xmlEntities($data);
    }


    public function render_lexer_exit(Doku_Renderer $renderer, $data) {

    }


    public function render_lexer_special(Doku_Renderer $renderer, $data) {

    }


    public function render($mode, Doku_Renderer $renderer, $data) {
        if($mode == 'xhtml'){
            list($state,$match) = $data;

            switch ($state) {
                case DOKU_LEXER_ENTER:
                    $this->render_lexer_enter($renderer, $match);
                    return true;

                case DOKU_LEXER_UNMATCHED :  
                    $this->render_lexer_unmatched($renderer, $match);
                    return true;
    
                case DOKU_LEXER_EXIT :
                    $this->render_lexer_exit($renderer, $match);
                    return true;

                case DOKU_LEXER_SPECIAL:
                    $this->render_lexer_special($renderer, $match);
                    return true;
            }
    
            return true;
        }

        return false;
    }


    public function buildClassString($options=null, $classes=null, $prefix='') {
        $s = array();

        if($options != null) {
            if($classes != null) {
                foreach($classes as $item) {
                    if(array_key_exists($item, $options) && $options[$item] !== false) {
                        $classname = $item;
                        
                        if(is_string($options[$item])) {
                            $classname = $options[$item];
                        }

                        if(is_string($prefix)) {
                            $classname = $prefix . $classname;
                        } else if(is_array($prefix)) {
                            foreach($prefix as $pitem => $pvalue) {
                                if(is_string($pvalue)) {
                                    if($pvalue == $item) {
                                        if(is_string($options[$item])) {
                                            $classname = $pitem . $options[$item];
                                        } else {
                                            $classname = $pitem . $item;
                                        }
                                    }
                                }

                                if(is_array($pvalue)) {
                                    foreach($pvalue as $ppitem) {
                                        if($ppitem == $item) {
                                            if(is_string($options[$item])) {
                                                $classname = $pitem . $options[$item];
                                            } else {
                                                $classname = $pitem . $item;
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        $s[] = $classname;
                    }
                }
            }

            foreach($this->incClasses as $item => $value) {
                if(array_key_exists($value, $options) && $options[$value] == true) {
                    $pre = substr($value, 0, 3);
                    if($pre == 'sm-' || $pre == 'md-' || $pre == 'lg-') $value = 'col-' . $value;
                    
                    $s[] = $value;
                }
            }
        }

        $s = ' ' . implode(' ', $s);
        return $s;
    }

    public function buildStyleString($options, $ignore=null, $append='') {
        $s = array();

        if($options != null) {
            foreach($options as $item => $value) {
                if($value != false && ($ignore == null || (is_string($ignore) && $ignore != $item) || (is_array($ignore) && in_array($item, $ignore) == false))) {
                    switch($item) {
                        case 'width':
                            $s[] = 'width:' . $value;
                            break;
                        case 'height':
                            $s[] = 'height:' . $value;
                            break;
                        case 'min-width':
                            $s[] = 'min-width:' . $value;
                            break;
                        case 'min-height':
                            $s[] = 'min-height:' . $value;
                            break;
                        case 'max-width':
                            $s[] = 'max-width:' . $value;
                            break;
                        case 'max-height':
                            $s[] = 'max-height:' . $value;
                            break;
                        case 'overflow':
                            $s[] = 'overflow:' . $value;
                            break;
                    }    
                }
            }
        }

        $s = implode(';', $s) . $append;

        if($s != '') $s = ' style="' . $s . '" ';

        return $s;
    }

    public function buildTooltipString($options) {
        $dataPlacement = 'top';
        $dataHtml = false;
        $title = '';

        if($options != null) {
            if(array_key_exists('tooltip-html-top', $options) && $options['tooltip-html-top'] != '') {
                $title = $options['tooltip-html-top'];
                $dataPlacement = 'top';
            }

            if(array_key_exists('tooltip-html-left', $options) && $options['tooltip-html-left'] != '') {
                $title = $options['tooltip-html-left'];
                $dataPlacement = 'left';
            }

            if(array_key_exists('tooltip-html-bottom', $options) && $options['tooltip-html-bottom'] != '') {
                $title = $options['tooltip-html-bottom'];
                $dataPlacement = 'bottom';
            }

            if(array_key_exists('tooltip-html-right', $options) && $options['tooltip-html-right'] != '') {
                $title = $options['tooltip-html-right'];
                $dataPlacement = 'right';
            }

            if(array_key_exists('tooltip-top', $options) && $options['tooltip-top'] != '') {
                $title = $options['tooltip-top'];
                $dataPlacement = 'top';
            }

            if(array_key_exists('tooltip-left', $options) && $options['tooltip-left'] != '') {
                $title = $options['tooltip-left'];
                $dataPlacement = 'left';
            }

            if(array_key_exists('tooltip-bottom', $options) && $options['tooltip-bottom'] != '') {
                $title = $options['tooltip-bottom'];
                $dataPlacement = 'bottom';
            }

            if(array_key_exists('tooltip-right', $options) && $options['tooltip-right'] != '') {
                $title = $options['tooltip-right'];
                $dataPlacement = 'right';
            }

            if(array_key_exists('tooltip-html', $options) && $options['tooltip-html'] != '') {
                $title = $options['tooltip-html'];
                $dataPlacement = 'top';
            }

            if(array_key_exists('tooltip', $options) && $options['tooltip'] != '') {
                $title = $options['tooltip'];
                $dataPlacement = 'top';
            }
        }

        if($title != '') {
            return ' data-toggle="tooltip" data-placement="' . $dataPlacement . '" ' . ($dataHtml == true ? 'data-html="true" ' : '') . 'title="' . $title . '" ';
        }

        return '';
    }

    public function getMediaFile($str) {
        $i = strpos($str, '?');
        if($i !== false) $str = substr($str, 0, $i);
     
        $str = preg_replace('/[^\da-zA-Z:_.]+/', '', $str);

        return(tpl_getMediaFile(array($str), false));
    }


    public function getLink($str) {
        $i = strpos($str, '://');
        if($i !== false) return $str;

        return wl($str);
    }


    public function setAttr(&$attrList, $attr, $data, $newAttrName='', $newAttrVal='') {
        if(array_key_exists($attr, $data) && $data[$attr] !== false) {
            $value = $data[$attr];

            if($newAttrName != '') $attr = $newAttrName;
            if($newAttrVal != '') {
                $newAttrVal = str_replace('%%VALUE%%', $value, $newAttrVal);
                if(strpos($newAttrVal, '%%MEDIA%%') !== false) {
                    $newAttrVal = str_replace('%%MEDIA%%', $this->getMediaFile($value), $newAttrVal);
                }

                $value = $newAttrVal;
            }

            $attrList[$attr] = $value;
        }
    }

    
    public function listAttr($attrName, $attrs) {
        $s = '';
        
        if(count($attrs) > 0) {
            foreach($attrs as $item => $value) {
                $s .= $item . ':' . $value . ';';
            }

            $s = $attrName . '="' . $s . '" ';
        }

        return $s;
    }


    public function syntaxRender(Doku_Renderer $renderer, $className, $text, $data=null) {
        $class = new $className;

        if(!is_array($data)) $data = array();

        $data = $class->cleanOptions($data);
        $class->values = $data;

        if($class->noEndTag) {
            $class->render_lexer_special($renderer, $data);
        } else {
            $class->render_lexer_enter($renderer, $data);
            $renderer->doc .= $text;
            $class->render_lexer_exit($renderer, null);    
        }
    }
}
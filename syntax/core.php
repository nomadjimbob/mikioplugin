<?php

/**
 * Mikio Core Syntax Plugin
 *
 * @link    http://github.com/nomadjimbob/mikioplugin
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author  James Collins <james.collins@outlook.com.au>
 */
if (!defined('DOKU_INC')) { die();
}
if (!defined('DOKU_PLUGIN')) { define('DOKU_PLUGIN', DOKU_INC . 'lib/plugins/');
}

require_once __DIR__.'/../disabled-tags.php';

define('MIKIO_LEXER_AUTO', 0);
define('MIKIO_LEXER_ENTER', 1);
define('MIKIO_LEXER_EXIT', 2);
define('MIKIO_LEXER_SPECIAL', 3);

class syntax_plugin_mikioplugin_core extends DokuWiki_Syntax_Plugin
{
    public $pattern_entry       = '';
    public $pattern             = '';
    public $pattern_exit        = '';
    public $tag                 = '';
    public $requires_tag        = '';
    public $hasEndTag           = true;
    public $options             = array();

    protected $tagPrefix          = ''; //'mikio-';
    protected $classPrefix        = 'mikiop-';
    protected $elemClass          = 'mikiop';

    private $values              = array();


    function __construct()
    {
    }

    public function isDisabled()
    {
        global $mikio_disabled_tags;

        if (isset($mikio_disabled_tags) === true) {
            if(array_key_exists($this->tag, $mikio_disabled_tags) === true && $mikio_disabled_tags[$this->tag] === true) {
                return true;
            }

            // check requirements
            if($this->requires_tag !== '') {
                if(array_key_exists($this->requires_tag, $mikio_disabled_tags) === true && $mikio_disabled_tags[$this->requires_tag] === true) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getType()
    {
        return 'formatting';
    }
    public function getAllowedTypes()
    {
        return array('formatting', 'substition', 'disabled', 'paragraphs');
    }
    // public function getAllowedTypes() { return array('formatting', 'substition', 'disabled'); }
    public function getSort()
    {
        return 32;
    }
    public function getPType()
    {
        return 'stack';
    }


    public function connectTo($mode)
    {
        if($this->isDisabled() == true) {
            return;
        }

        if ($this->pattern_entry == '' && $this->tag != '') {
            if ($this->hasEndTag) {
                $this->pattern_entry = '<(?i:' . $this->tagPrefix . $this->tag . ')(?=[ >])(?:".*?"|.*?)*?>(?=.*?</(?i:' . $this->tagPrefix . $this->tag . ')>)';
            } else {
                $this->pattern_entry = '<(?i:' . $this->tagPrefix . $this->tag . ')(?:".*?"|.*?)*?>';
            }
        }

        if ($this->pattern_entry != '') {
            if ($this->hasEndTag) {
                $this->Lexer->addEntryPattern($this->pattern_entry, $mode, 'plugin_mikioplugin_' . $this->getPluginComponent());
            } else {
                $this->Lexer->addSpecialPattern($this->pattern_entry, $mode, 'plugin_mikioplugin_' . $this->getPluginComponent());
            }
        }
    }


    public function postConnect()
    {
        if ($this->hasEndTag) {
            if ($this->pattern_exit == '' && $this->tag != '') {
                $this->pattern_exit = '</(?i:' . $this->tagPrefix . $this->tag . ')>';
            }

            if ($this->pattern_exit != '') {
                $this->Lexer->addExitPattern($this->pattern_exit, 'plugin_mikioplugin_' . $this->getPluginComponent());
            }
        }
    }

    public function handle($match, $state, $pos, Doku_Handler $handler)
    {
        if($this->isDisabled() != true) {
            switch ($state) {
            case DOKU_LEXER_ENTER:
            case DOKU_LEXER_SPECIAL:
                $match_fix = preg_replace('/\s*=\s*/', '=', trim(substr($match, strlen($this->tagPrefix . $this->tag) + 1, -1)));
                $optionlist = preg_split('/\s(?=([^"]*"[^"]*")*[^"]*$)/', $match_fix);

                $options = array();
                foreach ($optionlist as $item) {
                    $i = strpos($item, '=');
                    if ($i !== false) {
                        $value = substr($item, $i + 1);

                        if (substr($value, 0, 1) == '"') { $value = substr($value, 1);
                        }
                        if (substr($value, -1) == '"') { $value = substr($value, 0, -1);
                        }

                        $options[substr($item, 0, $i)] = $value;
                    } else {
                        $options[$item] = true;
                    }
                }

                if (count($this->options) > 0) {
                    $options_clean = $this->cleanOptions($options);
                } else {
                    $options_clean = $options;
                }

                $this->values = $options_clean;

                return array($state, $options_clean);

            case DOKU_LEXER_MATCHED:
                return array($state, $match);

            case DOKU_LEXER_UNMATCHED:
                return array($state, $match);

            case DOKU_LEXER_EXIT:
                return array($state, $this->values);
            }
        }

        return array();
    }


    /*
    * clean element options to only supported attributes, setting defaults if required
    *
    * @param $options   options passed to element
    * @return           array of options supported with default set
    */
    protected function cleanOptions($data, $options = null)
    {
        $optionsCleaned = array();

        if ($options == null) { $options = $this->options;
        }

        // Match DokuWiki passed options to syntax options
        foreach ($data as $optionKey => $optionValue) {
            foreach ($options as $syntaxKey => $syntaxValue) {
                if (strcasecmp($optionKey, $syntaxKey) == 0) {
                    if (array_key_exists('type', $options[$syntaxKey])) {
                        $type = $options[$syntaxKey]['type'];

                        switch ($type) {
                        case 'boolean':
                            $optionsCleaned[$syntaxKey] = filter_var($optionValue, FILTER_VALIDATE_BOOLEAN);
                            break;
                        case 'number':
                            $optionsCleaned[$syntaxKey] = filter_var($optionValue, FILTER_VALIDATE_INT);
                            break;
                        case 'float':
                            $optionsCleaned[$syntaxKey] = filter_var($optionValue, FILTER_VALIDATE_FLOAT);
                            break;
                        case 'text':
                            $optionsCleaned[$syntaxKey] = $optionValue;
                            break;
                        case 'size':
                            $s = strtolower($optionValue);
                            $i = '';
                            if (substr($s, -3) == 'rem') {
                                $i = substr($s, 0, -3);
                                $s = 'rem';
                            } elseif (substr($s, -2) == 'em') {
                                $i = substr($s, 0, -2);
                                $s = 'em';
                            } elseif (substr($s, -2) == 'px') {
                                $i = substr($s, 0, -2);
                                $s = 'px';
                            } elseif (substr($s, -1) == '%') {
                                $i = substr($s, 0, -1);
                                $s = '%';
                            } else {
                                if ($s != 'auto') {
                                    $i = filter_var($s, FILTER_VALIDATE_INT);
                                    if ($i == '') { $i = '1';
                                    }
                                    $s = 'rem';
                                }
                            }

                            $optionsCleaned[$syntaxKey] = $i . $s;
                            break;
                        case 'multisize':
                            $val = '';
                            $parts = explode(' ', $optionValue);
                            foreach ($parts as &$part) {
                                $s = strtolower($part);
                                $i = '';
                                if (substr($s, -3) == 'rem') {
                                    $i = substr($s, 0, -3);
                                    $s = 'rem';
                                } elseif (substr($s, -2) == 'em') {
                                    $i = substr($s, 0, -2);
                                    $s = 'em';
                                } elseif (substr($s, -2) == 'px') {
                                    $i = substr($s, 0, -2);
                                    $s = 'px';
                                } elseif (substr($s, -2) == 'fr') {
                                    $i = substr($s, 0, -2);
                                    $s = 'fr';
                                } elseif (substr($s, -1) == '%') {
                                    $i = substr($s, 0, -1);
                                    $s = '%';
                                } else {
                                    if ($s != 'auto') {
                                        $i = filter_var($s, FILTER_VALIDATE_INT);
                                        if ($i === '') { $i = '1';
                                        }
                                        if ($i != 0) {
                                            $s = 'rem';
                                        } else {
                                            $s = '';
                                        }
                                    }
                                }

                                $part = $i . $s;
                            }

                            $optionsCleaned[$syntaxKey] = implode(' ', $parts);
                            break;
                        case 'color':
                            if (strlen($optionValue) == 3 || strlen($optionValue) == 6) {
                                preg_match('/([[:xdigit:]]{3}){1,2}/', $optionValue, $matches);
                                if (count($matches) > 1) {
                                    $optionsCleaned[$syntaxKey] = '#' . $matches[0];
                                } else {
                                    $optionsCleaned[$syntaxKey] = $optionValue;
                                }
                            } else {
                                $optionsCleaned[$syntaxKey] = $optionValue;
                            }
                            break;
                        case 'url':
                            $optionsCleaned[$syntaxKey] = $this->buildLink($optionValue);
                            break;
                        case 'media':
                            $optionsCleaned[$syntaxKey] = $this->buildMediaLink($optionValue);
                            break;
                        case 'choice':
                            if (array_key_exists('data', $options[$syntaxKey])) {
                                foreach ($options[$syntaxKey]['data'] as $choiceKey => $choiceValue) {
                                    if (strcasecmp($optionValue, $choiceKey) == 0) {
                                        $optionsCleaned[$syntaxKey] = $choiceKey;
                                        break;
                                    }

                                    if (is_array($choiceValue)) {
                                        foreach ($choiceValue as $choiceItem) {
                                            if (strcasecmp($optionValue, $choiceItem) == 0) {
                                                $optionsCleaned[$syntaxKey] = $choiceKey;
                                                break 2;
                                            }
                                        }
                                    } else {
                                        if (strcasecmp($optionValue, $choiceValue) == 0) {
                                            $optionsCleaned[$syntaxKey] = $choiceValue;
                                            break;
                                        }
                                    }
                                }
                            }
                            break;
                        case 'set':
                            if (array_key_exists('option', $options[$syntaxKey]) && array_key_exists('data', $options[$syntaxKey])) {
                                $optionsCleaned[$options[$syntaxKey]['option']] = $options[$syntaxKey]['data'];
                            }
                            break;
                        }
                    }

                    break;
                }
            }
        }

        $customStyles = [];

        foreach ($data as $optionKey => $optionValue) {
            if (!array_key_exists($optionKey, $optionsCleaned)) {
                if($optionValue === true && $this->customStyleExists($optionKey)) {
                    $customStyles[] = $optionKey;
                }

                foreach ($options as $syntaxKey => $syntaxValue) {
                    if (array_key_exists('type', $options[$syntaxKey])) {
                        if (array_key_exists('data', $options[$syntaxKey]) && is_array($options[$syntaxKey]['data'])) {
                            foreach ($options[$syntaxKey]['data'] as $choiceKey => $choiceValue) {
                                if (is_array($choiceValue)) {
                                    if (in_array($optionKey, $choiceValue)) {
                                        $optionsCleaned[$syntaxKey] = $choiceKey;
                                    }
                                } else {
                                    if (strcasecmp($choiceValue, $optionKey) == 0) {
                                        $optionsCleaned[$syntaxKey] = $choiceValue;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if(array_key_exists('type', $options) === true
            && array_key_exists('type', $optionsCleaned) === false
            && count($customStyles) > 0
        ) {
                $optionsCleaned['type'] = $customStyles[0];
        }

        // Add in syntax options that are missing
        foreach ($options as $optionKey => $optionValue) {
            if (!array_key_exists($optionKey, $optionsCleaned)) {
                if (array_key_exists('default', $options[$optionKey])) {
                    switch ($options[$optionKey]['type']) {
                    case 'boolean':
                        $optionsCleaned[$optionKey] = filter_var($options[$optionKey]['default'], FILTER_VALIDATE_BOOLEAN);
                        break;
                    case 'number':
                        $optionsCleaned[$optionKey] = filter_var($options[$optionKey]['default'], FILTER_VALIDATE_INT);
                        break;
                    default:
                        $optionsCleaned[$optionKey] = $options[$optionKey]['default'];
                        break;
                    }
                }
            }
        }

        return $optionsCleaned;
    }

    /* Lexer renderers */
    protected function render_lexer_enter(Doku_Renderer $renderer, $data)
    {
    }
    protected function render_lexer_unmatched(Doku_Renderer $renderer, $data)
    {
        $renderer->doc .= $renderer->_xmlEntities($data);
    }
    protected function render_lexer_exit(Doku_Renderer $renderer, $data)
    {
    }
    protected function render_lexer_special(Doku_Renderer $renderer, $data)
    {
    }
    protected function render_lexer_match(Doku_Renderer $renderer, $data)
    {
    }

    /* Renderer */
    public function render($mode, Doku_Renderer $renderer, $data)
    {
        if ($mode == 'xhtml' && $this->isDisabled() != true) {
            list($state, $match) = $data;

            switch ($state) {
            case DOKU_LEXER_ENTER:
                $this->render_lexer_enter($renderer, $match);
                return true;

            case DOKU_LEXER_UNMATCHED:
                $this->render_lexer_unmatched($renderer, $match);
                return true;

            case DOKU_LEXER_MATCHED:
                $this->render_lexer_match($renderer, $match);
                return true;

            case DOKU_LEXER_EXIT:
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

    /*
    * return a class list with mikiop- prefix
    * 
    * @param $options       options of syntax element. Options with key 'class'=true are automatically added
    * @param $classes       classes to build from options as array
    * @param $inclAttr      include class="" in the return string
    * @param $optionsTemplate   allow a different options template instead of $this->options (for findTags)
    * @return               a string of classes from options/classes variable
    */
    public function buildClass($options = null, $classes = null, $inclAttr = false, $optionsTemplate = null)
    {
        $s = array();

        if (is_array($options)) {
            if ($classes == null) { $classes = array();
            }
            if ($optionsTemplate == null) { $optionsTemplate = $this->options;
            }

            foreach ($optionsTemplate as $key => $value) {
                if (array_key_exists('class', $value) && $value['class'] == true) {
                    $classes[] = $key;
                }
            }

            foreach ($classes as $class) {
                if (array_key_exists($class, $options) && $options[$class] !== false && $options[$class] != '') {
                    $prefix = $this->classPrefix;

                    if (array_key_exists($class, $optionsTemplate) && array_key_exists('prefix', $optionsTemplate[$class])) {
                        $prefix .= $optionsTemplate[$class]['prefix'];
                    }

                    if (array_key_exists($class, $optionsTemplate) && array_key_exists('classNoSuffix', $optionsTemplate[$class]) && $optionsTemplate[$class]['classNoSuffix'] == true) {
                        $s[] = $prefix . $class;
                    } else {
                        $s[] = $prefix . $class . ($options[$class] !== true ? '-' . $options[$class] : '');
                    }
                }
            }
        }

        $s = implode(' ', $s);
        if ($s != '') { $s = ' ' . $s;
        }

        if ($inclAttr) { $s = ' classes="' . $s . '"';
        }

        return $s;
    }




    /*
    * build style string
    *
    * @param $list          style list as key => value. Empty values are not included
    * @param $inclAttr      include style="" in the return string
    * @return               style list string
    */
    public function buildStyle($list, $inclAttr = false)
    {
        $s = '';

        if (is_array($list) && count($list) > 0) {
            // expand text-decoration
            if(array_key_exists('text-decoration', $list)) {
                // Define the possible values for each property
                $decorations = array('underline', 'overline', 'line-through');
                $styles = array('solid', 'double', 'dotted', 'dashed', 'wavy');
                // Split the shorthand string into parts
                $parts = explode(' ', $list['text-decoration']);
                    
                // Initialize the variables to hold the property values
                $decoration = '';
                $style = '';
                $color = '';
                $thickness = '';
                
                // Process each part of the shorthand string
                foreach ($parts as $part) {
                    if (in_array($part, $decorations)) {
                        $decoration = $part;
                    } elseif (in_array($part, $styles)) {
                        $style = $part;
                    } elseif (preg_match('/^\d+(px|em|rem|%)$/', $part)) {
                        $thickness = $part;
                    } elseif (preg_match('/^#[0-9a-fA-F]{6}$|^[a-zA-Z]+$/', $part)) {
                        $color = $part;
                    }
                }

                // Build the completed style string
                unset($list['text-decoration']);
                if ($decoration) { $list['text-decoration'] = trim($decoration);
                }
                if ($style) { $list['text-decoration-style'] = trim($style);
                }
                if ($color) { $list['text-decoration-color'] = trim($color);
                }
                if ($thickness) { $list['text-decoration-thickness'] = trim($thickness);
                }
            }

            foreach ($list as $key => $value) {
                if ($value != '') {
                    $s .= $key . ':' . $value . ';';
                }
            }
        }

        if ($s != '' && $inclAttr) {
            $s = ' style="' . $s . '"';
        }

        return $s;
    }


    public function buildTooltipString($options)
    {
        $dataPlacement = 'top';
        $dataHtml = false;
        $title = '';

        if ($options != null) {
            if (array_key_exists('tooltip-html-top', $options) && $options['tooltip-html-top'] != '') {
                $title = $options['tooltip-html-top'];
                $dataPlacement = 'top';
            }

            if (array_key_exists('tooltip-html-left', $options) && $options['tooltip-html-left'] != '') {
                $title = $options['tooltip-html-left'];
                $dataPlacement = 'left';
            }

            if (array_key_exists('tooltip-html-bottom', $options) && $options['tooltip-html-bottom'] != '') {
                $title = $options['tooltip-html-bottom'];
                $dataPlacement = 'bottom';
            }

            if (array_key_exists('tooltip-html-right', $options) && $options['tooltip-html-right'] != '') {
                $title = $options['tooltip-html-right'];
                $dataPlacement = 'right';
            }

            if (array_key_exists('tooltip-top', $options) && $options['tooltip-top'] != '') {
                $title = $options['tooltip-top'];
                $dataPlacement = 'top';
            }

            if (array_key_exists('tooltip-left', $options) && $options['tooltip-left'] != '') {
                $title = $options['tooltip-left'];
                $dataPlacement = 'left';
            }

            if (array_key_exists('tooltip-bottom', $options) && $options['tooltip-bottom'] != '') {
                $title = $options['tooltip-bottom'];
                $dataPlacement = 'bottom';
            }

            if (array_key_exists('tooltip-right', $options) && $options['tooltip-right'] != '') {
                $title = $options['tooltip-right'];
                $dataPlacement = 'right';
            }

            if (array_key_exists('tooltip-html', $options) && $options['tooltip-html'] != '') {
                $title = $options['tooltip-html'];
                $dataPlacement = 'top';
            }

            if (array_key_exists('tooltip', $options) && $options['tooltip'] != '') {
                $title = $options['tooltip'];
                $dataPlacement = 'top';
            }
        }

        if ($title != '') {
            return ' data-toggle="tooltip" data-placement="' . $dataPlacement . '" ' . ($dataHtml == true ? 'data-html="true" ' : '') . 'title="' . $title . '" ';
        }

        return '';
    }

    /*
    * convert the URL to a DokuWiki media link (if required)
    *
    * @param $url   url to parse
    * @return       url string
    */
    public function buildMediaLink($url)
    {
        $i = strpos($url, '?');
        if ($i !== false) { $url = substr($url, 0, $i);
        }

        $url = preg_replace('/[^\da-zA-Z:_.-]+/', '', $url);

        return (tpl_getMediaFile(array($url), false));
    }


    /*
    * returns either a url or dokuwiki link
    *
    * @param    $url    link to build from
    * @return           built link
    */
    public function buildLink($url)
    {
        $i = strpos($url, '://');
        if ($i !== false || substr($url, 0, 1) == '#') { return $url;
        }

        return wl($url);
    }

    /*
    * Call syntax renderer of mikio syntax plugin
    *
    * @param $renderer          DokuWiki renderer object
    * @param $className         mikio syntax class to call
    * @param $text              unmatched text to pass outside of lexer. Only used when $lexer=MIKIO_LEXER_AUTO
    * @param $data              tag options to pass to syntax class. Runs through cleanOptions to validate first
    * @param $lexer             which lexer to call
    */
    public function syntaxRender(Doku_Renderer $renderer, $className, $text, $data = null, $lexer = MIKIO_LEXER_AUTO)
    {
        $className = 'syntax_plugin_mikioplugin_' . str_replace('-', '', $className);

        if (class_exists($className)) {
            $class = new $className;

            if (!is_array($data)) { $data = array();
            }


            if (count($class->options) > 0) {
                $data = $class->cleanOptions($data, $class->options);
            }

            switch ($lexer) {
            case MIKIO_LEXER_AUTO:
                if ($class->hasEndTag) {
                    if (method_exists($class, 'render_lexer_enter')) { $class->render_lexer_enter($renderer, $data);
                    }
                    $renderer->doc .= $text;
                    if (method_exists($class, 'render_lexer_exit')) { $class->render_lexer_exit($renderer, $data);
                    }
                } else {
                    if (method_exists($class, 'render_lexer_special')) { $class->render_lexer_special($renderer, $data);
                    }
                }

                break;
            case MIKIO_LEXER_ENTER:
                if (method_exists($class, 'render_lexer_enter')) { $class->render_lexer_enter($renderer, $data);
                }
                break;
            case MIKIO_LEXER_EXIT:
                if (method_exists($class, 'render_lexer_exit')) { $class->render_lexer_exit($renderer, $data);
                }
                break;
            case MIKIO_LEXER_SPECIAL:
                if (method_exists($class, 'render_lexer_special')) { $class->render_lexer_special($renderer, $data);
                }
                break;
            }
        }
    }


    protected function callMikioTag($className, $data)
    {
        // $className = 'syntax_plugin_mikioplugin_'.$className;


        // if(class_exists($className)) {
        //$class = new $className;
        if (!plugin_isdisabled('mikioplugin')) {
            $class = plugin_load('syntax', 'mikioplugin_' . $className);
            // echo '^^'.$className.'^^';


            if (method_exists($class, 'mikioCall')) { return $class->mikioCall($data);
            }
        }

        // }

        return '';
    }


    protected function callMikioOptionDefault($className, $option)
    {
        $className = 'syntax_plugin_mikioplugin_' . $className;

        if (class_exists($className)) {
            $class = new $className;

            if (array_key_exists($option, $class->options) && array_key_exists('default', $class->options[$option])) {
                return $class->options[$option]['default'];
            }
        }

        return '';
    }


    protected function buildTooltip($text)
    {
        if ($text != '') {
            return ' data-tooltip="' . $text . '"';
        }

        return '';
    }

    /*
    * Create array with passed elements and include them if their values are not empty
    *
    * @param ...        array items
    */
    protected function arrayRemoveEmpties($items)
    {
        $result = array();

        foreach ($items as $key => $value) {
            if ($value != '') {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    public function getFirstArrayKey($data)
    {
        if (!function_exists('array_key_first')) {
            foreach ($data as $key => $unused) {
                return $key;
            }
        }

        return array_key_first($data);
    }


    /*
    * add common options to options
    *
    * @param $typelist      common option to add
    * @param $options   save in options
    */
    public function addCommonOptions($typelist)
    {
        $types = explode(' ', $typelist);
        foreach ($types as $type) {
            if (strcasecmp($type, 'shadow') == 0) {
                $this->options['shadow'] =          array(
                    'type'     => 'choice',
                    'data'     => array('large' => array('shadow-large', 'shadow-lg'), 'small' => array('shadow-small', 'shadow-sm'), true),
                    'default'  => '',
                    'class'    => true
                );
            }

            if (strcasecmp($type, 'width') == 0) {
                $this->options['width'] =           array(
                    'type'     => 'size',
                    'default'  => ''
                );
            }

            if (strcasecmp($type, 'height') == 0) {
                $this->options['height'] =          array(
                    'type'     => 'size',
                    'default'  => ''
                );
            }

            if (strcasecmp($type, 'text-color') == 0) {
                $this->options['text-color'] =          array(
                    'type'      => 'color',
                    'default'  => ''
                );
            }

            if (strcasecmp($type, 'type') == 0) {
                $this->options['type'] =              array(
                    'type'     => 'text',
                    'data'     => array('primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark', 'outline-primary', 'outline-secondary', 'outline-success', 'outline-danger', 'outline-warning', 'outline-info', 'outline-light', 'outline-dark'),
                    'default'  => '',
                    'class'    => true
                );
            }

            if (strcasecmp($type, 'text-align') == 0) {
                $this->options['text-align'] =      array(
                    'type'     => 'choice',
                    'data'     => array('left' => array('text-left'), 'center' => array('text-center'), 'right' => array('text-right')),
                    'default'  => '',
                    'class'    => true
                );
            }

            if (strcasecmp($type, 'align') == 0) {
                $this->options['align'] =           array(
                    'type'     => 'choice',
                    'data'     => array('left' => array('align-left'), 'center' => array('align-center'), 'right' => array('align-right')),
                    'default'  => '',
                    'class'    => true
                );
            }

            if (strcasecmp($type, 'tooltip') == 0) {
                $this->options['tooltip'] =         array(
                    'type'     => 'text',
                    'default'  => '',
                    'class'    => true,
                    'classNoSuffix'   => true
                );
            }

            if (strcasecmp($type, 'vertical-align') == 0) {
                $this->options['vertical-align'] =  array(
                    'type'    => 'choice',
                    'data'    => array('top' => array('align-top'), 'middle' => array('align-middle'), 'bottom' => array('align-bottom'), 'justify' => array('align-justify')),
                    'default' => '',
                    'class'   => true
                );
            }

            if (strcasecmp($type, 'links-match') == 0) {
                $this->options['links-match'] =     array(
                    'type'    => 'boolean',
                    'default' => 'false',
                    'class'   => true
                );
            }
        }
    }


    /*
    * Find HTML tags in string. Parse tags options. Used in parsing subtags
    *
    * @param $tagName       tagName to search for. Name is exclusive
    * @param $content       search within content
    * @param $options       parse options similar to syntax element options
    * @param $hasEndTag     tagName search also looks for an end tag
    * @return               array of tags containing 'options' => array of 'name' => 'value', 'content' => content inside the tag
    */
    protected function findTags($tagName, $content, $options, $hasEndTag = true)
    {
        $items = [];
        $tn = preg_quote($tagName, '/');

        $search = $hasEndTag
            ? '/<(?i:' . $tn . ')(?P<attrs>.*?)>(?P<body>.*?)<\/(?i:' . $tn . ')>/s'
            : '/<(?i:' . $tn . ')(?P<attrs>.*?)>/s';

        if (preg_match_all($search, $content, $m)) {
            $n = count($m['attrs']);
            for ($i = 0; $i < $n; $i++) {
                $rawAttrs = trim($m['attrs'][$i] ?? '');
                $body     = $hasEndTag ? ($m['body'][$i] ?? '') : '';
                $item     = ['options' => [], 'content' => $this->render_text($body)];

                $optionlist = $rawAttrs === '' ? [] :
                    preg_split('/\s(?=([^"]*"[^"]*")*[^"]*$)/', $rawAttrs);

                foreach ($optionlist as $option) {
                    if ($option === '') continue;
                    $j = strpos($option, '=');
                    if ($j !== false) {
                        $value = trim($option, " \t\n\r\0\x0B");
                        $value = substr($value, $j + 1);
                        $value = trim($value, '"');
                        $item['options'][substr($option, 0, $j)] = $value;
                    } else {
                        $item['options'][$option] = true;
                    }
                }

                $item['options'] = $this->cleanOptions($item['options'], $options);
                $items[] = $item;
            }
        }

        return $items;
    }

    /*
    * Check if a custom style exists in styles.less
    *
    * @param $name          The style name to search foe
    * @return               true if the style name exists
    */
    protected function customStyleExists($name)
    {
        $stylePath = __DIR__.'/../styles/styles.less';

        if(file_exists($stylePath)) {
            $styleData = file_get_contents($stylePath);
            $searchString = '._mikiop-custom-type('.$name.');';

            return (strpos($styleData, $searchString) !== false);
        }

        return false;
    }

    /*
    * Convert a string to include HTML code based on markdown
    *
    * @param $text          The text to style
    * @return               The styled text
    */
    public function applyMarkdownEffects($text)
    {
        // Emphasis * Strong
        $regex = '/(?<!\*)\*\*\*([^*]+)\*\*\*(?!\*)/';
        $replacement = '<em><strong>$1</strong></em>';
        $text = preg_replace($regex, $replacement, $text);

        // Strong
        $regex = '/(?<!\*)\*\*([^*]+)\*\*(?!\*)/';
        $replacement = '<strong>$1</strong>';
        $text = preg_replace($regex, $replacement, $text);

        // Emphasis
        $regex = '/(?<!\*)\*([^*]+)\*(?!\*)/';
        $replacement = '<em>$1</em>';
        $text = preg_replace($regex, $replacement, $text);

        return $text;
    }
}

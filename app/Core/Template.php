<?php


namespace App\Core;


use Exception;

class Template
{
    private $_basePath = null;
    private $_variables = array();
    private $_template = null;
    private $_controller = null;

    public function controller()
    {
        return $this->_controller;
    }

    public static function create($controller)
    {
        $ret = new self;
        $ret->_controller = $controller;
        return $ret;
    }

    public function __set($variable, $value)
    {
        $this->_variables[$variable] = $value;
        $this->$variable = $value;
    }

    public function setBasePath($basepath)
    {
        $this->_basePath = $basepath . (substr($basepath, -1, 1) != "/" ? "/" : null);

        return $this;
    }

    /**
     * @param null $template
     * @param bool $setContentArray
     * @return false|string
     * @throws Exception
     */
    public function fetch($template = null, $setContentArray = true)
    {
        if (isset($template)) {
            $this->_template = $template;
        }

        if (!isset($this->_template)) {
            throw new Exception('template empty');
        }

        $this->_template = $this->_basePath . $this->_template;

//        if (!file_exists($this->_template)) {
//            throw new Exception($this->_template . ' is inaccesible');
//        }

        print_r($this->_template);

        extract($this->_variables);
        ob_start();
        if (!empty($this->_template)) {
            require($this->_template);
        }
        $return = ob_get_contents();
        ob_end_clean();

        return $return;
    }

    public function display($template)
    {
        $content = $this->fetch($template);

        var_dump($content);

        include dirname(dirname(__FILE__)) . '/Views/index.php';

        return $this;
    }

    public function assign($name, $value = null)
    {
        if (is_array($name)) {

            foreach ($name as $akey => $avalue) {
                $this->$akey = $avalue;
            }
            return $this;
        }

        $this->$name = $value;

        return $this;
    }
}
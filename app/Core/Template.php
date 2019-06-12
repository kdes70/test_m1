<?php


namespace App\Core;


use Exception;

class Template
{
    private $_basePath = ROOT_PATH . DIRECTORY_SEPARATOR . "Views" . DIRECTORY_SEPARATOR;
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

        $this->_template = $this->_basePath . $this->_template . '.php';

        if (!file_exists($this->_template)) {
            throw new Exception($this->_template . ' is inaccesible');
        }

        extract($this->_variables);
        ob_start();
        require($this->_template);

        $return = ob_get_contents();
        ob_end_clean();

        return $return;
    }

    public function display($template)
    {
        $content = $this->fetch($template);

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
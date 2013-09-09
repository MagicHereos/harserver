<?php
namespace Erpk\Harserver;

use RuntimeException;

class Config
{
    protected $params = array();
    protected $path;

    public function __construct($path)
    {
        $this->path = $path;
        if (file_exists($path)) {
            $params = json_decode(file_get_contents($path), true);

            if ($params === null) {
                throw new RuntimeException('Configuration file is invalid JSON.');
            } else {
                $this->params = $params;
            }
        }
    }

    public function getPath()
    {
        return $this->path;
    }

    public function set($key, $value)
    {
        $this->params[$key] = $value;
    }

    public function all()
    {
        return $this->params;
    }

    public function get($key)
    {
        if ($this->has($key)) {
            return $this->params[$key];
        } else {
            throw new RuntimeException('Missing configuration option: "'.$key.'"');
        }
    }

    public function has($key)
    {
        return array_key_exists($key, $this->params);
    }

    public function save()
    {
        file_put_contents(
            $this->getPath(),
            json_encode($this->all())
        );
    }
}

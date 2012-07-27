<?php

class MailxpertAPI
{

    protected $transport = null;
    protected $entity = null;
    protected $parent = null;
    protected $body = array();
    protected $settings = null;
    protected $debug = false;

    public function __call($action, $args)
    {
        $parentId   = $this->parent ? array_shift($args) : null;
        $id         = array_shift($args);
        $this->body = count($args) ? array_shift($args) : $this->body;

        //merge settings with possible settings in body, body settings have priority
        if (count($this->settings)) {
            $this->body = array_merge(array('settings' => $this->settings), $this->body);
        }

        $path = $this->buildPath($id, $parentId, $action);

        return $this->transport->executeRequest($path, $action, $this->body);
    }

    public function reset()
    {
        $this->entity   = null;
        $this->parent   = null;
        $this->body     = array();
        $this->settings = null;

        return $this;
    }

    /**
     * INTERNALS
     */
    protected function buildPath($id, $parentId, $action)
    {
        $path = '';

        if ($this->parent) {
            $path .= '/' . $this->parent . '/' . $parentId;
        }

        $path .= '/'.  $this->entity;

        if ($id) {
            $path .= '/'.$id;
        }

        if (!$this->transport->isKnownMethod($action)) {
            $path .= '/'.$action;
        }

        if (strtoupper($action) === 'GET' && $this->body) {
            $path .= '?' . http_build_query($this->body);
        }

        return ltrim($path, '/');
    }

    /**
     * SETTERS
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    public function setSetting($k, $v)
    {
        $this->settings[$k] = $v;

        return $this;
    }

    public function setSettings(array $settings)
    {
        $this->settings = $settings;

        return $this;
    }

    public function setTransport(TransportInterface $transport)
    {
        $this->transport = $transport;

        return $this;
    }

    /**
     * GETTERS
     */
    public function getTransport()
    {
        return $this->transport;
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getSettings()
    {
        return $this->settings;
    }

    public function getDebug()
    {
        return $this->debug;
    }

    public function setDebug($debug)
    {
        $this->debug = (boolean)$debug;
    }

}

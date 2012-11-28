<?php

namespace Artack\MxApi;

use Artack\MxApi\Request\Call;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class ArtackMxApi
{

    /**
     * @var Dispatcher
     */
    protected $dispatcher;
    
    /**
     * @var Call
     */
    protected $call;
    
    public function __construct(Dispatcher $dispatcher, Call $call)
    {
        $this->dispatcher = $dispatcher;
        $this->call = $call;
    }
    
    public function setPath($path, $ids)
    {
        $this->call->getUrl()->setPath($path, $ids);
        
        return $this;
    }
    
    public function setBody($body)
    {
        $this->call->setBody($body);
        
        return $this;
    }
    
    public function get()
    {
        $this->call->setMethod('GET');
        
        return $this->dispatch();
    }
    
    public function post()
    {
        $this->call->setMethod('POST');
        
        return $this->dispatch();
    }
    
    protected function dispatch()
    {
        $this->dispatcher->dispatch($this->call);
    }
    
}

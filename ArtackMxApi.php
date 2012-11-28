<?php

namespace Artack\MxApi;

use Artack\MxApi\Factory\Factory;
use Artack\MxApi\Factory\FactoryInterface;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class ArtackMxApi
{

    /**
     * @var \Artack\MxApi\Configuration
     */
    protected $configuration;

    /**
     * @var \Artack\MxApi\Factory\FactoryInterface
     */
    protected $factory;
    protected $browser;
    protected $coder;

    /**
     * @var \Artack\MxApi\Authenticator\AuthenticatorInterface
     */
    protected $authenticator;

    /**
     * @var \Artack\MxApi\Randomizer\RandomizerInterface
     */
    protected $randomizer;

    /**
     * @var \Artack\MxApi\Header\AccountTokenHeaderInterface
     */
    protected $accountTokenHeader;

    /**
     * @var \Artack\MxApi\Header\DateHeaderInterface
     */
    protected $dateHeader;

    protected $nonce;

    public function __construct(Configuration $configuration, FactoryInterface $factory = null)
    {
        $this->configuration = $configuration;
        $this->factory = $factory ?: new Factory();

        $this->build();
        $this->init();
    }

    protected function build()
    {
        $this->randomizer = Factory::buildRandomizer();
        $this->authenticator = Factory::buildAuthenticator();
        $this->accountTokenHeader = Factory::buildAccountTokenHeader();
        $this->dateHeader = Factory::buildDateHeader();
    }

    protected function init()
    {
        $this->nonce = $this->randomizer->getRandom(32);

        $this->authenticator->setData('anydata');
        $this->authenticator->setKey($this->configuration->getApiSecret());

        $hmac = $this->authenticator->getHash();

        $this->accountTokenHeader->setCustomerKey($this->configuration->getCustomerKey());
        $this->accountTokenHeader->setApiKey($this->configuration->getApiKey());
        $this->accountTokenHeader->setHmac($hmac);
        $this->accountTokenHeader->setNonce($this->nonce);
    }

    /**
     * @return string
     */
    public function getRandom($length)
    {
        return $this->randomizer->getRandom($length);
    }

    /**
     * @return string
     */
    public function getDateHeader()
    {
        return $this->dateHeader->getHeader();
    }

    /**
     * @return string
     */
    public function getAccountTokenHeader()
    {
        return $this->accountTokenHeader->getHeader();
    }

}

<?php

namespace Siarko\ActionRouting;

use Siarko\Bootstrap\Exception\ApplicationStartupException;
use Siarko\Utils\Persistance\Session\SessionManager;

class HttpApplication implements \Siarko\Bootstrap\Api\AppInterface
{

    /**
     * @param ActionManager $actionManager
     * @param SessionManager $sessionManager
     */
    public function __construct(
        private readonly ActionManager $actionManager,
        private readonly SessionManager $sessionManager
    )
    {
    }

    /**
     * Start application
     *
     * @return void
     */
    public function start(): void
    {
        $this->sessionManager->open();
        $this->actionManager->resolve();
    }

    /**
     * Run sanity checks to ensure that application is properly configured
     *
     * @return void
     * @throws ApplicationStartupException
     */
    public function runSanityChecks(): void
    {
        if(php_sapi_name() === 'cli'){
            throw new ApplicationStartupException("Cannot run Http Application in CLI Mode");
        }
    }

    /**
     * Handle errors
     *
     * @param \Throwable $exception
     * @return void
     */
    public function handleErrors(\Throwable $exception): void
    {
        throw $exception;// TODO: Implement handleErrors() method.
    }


}
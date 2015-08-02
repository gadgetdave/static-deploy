<?php

namespace StaticDeploy\Controller;

use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Mvc\MvcEvent;
use Zend\Paginator\Paginator;
use PhlyRestfully\ResourceController as PhlyRestfullyResourceController;
use OAuth2\Server;
use OAuth2\Request as OAuth2Request;
use PhlyRestfully\ApiProblem;
use PhlyRestfully\View\RestfulJsonModel;
use ZF\OAuth2\Factory\OAuth2ServerFactory;
use ZF\OAuth2\Controller\Exception\RuntimeException;

class ResourceController extends PhlyRestfullyResourceController
{
    /**
     * @var OAuth2ServerFactory
     */
    protected $serverFactory;

    /**
     * @var OAuth2Server
     */
    protected $server;

    /**
     * Constructor
     *
     * @param OAuth2Server $server
     * @param sting $eventIdentifier
     */
    public function __construct($serverFactory, $eventIdentifier = null)
    {
        if (! is_callable($serverFactory)) {
            throw new InvalidArgumentException(sprintf(
                'OAuth2 Server factory must be a PHP callable; received %s',
                (is_object($serverFactory) ? get_class($serverFactory) : gettype($serverFactory))
            ));
        }
        $this->serverFactory  = $serverFactory;

        parent::__construct($eventIdentifier);
    }

    /**
     * Handle the dispatch event - in this case we are authenticate the request
     *
     * @param  MvcEvent $e
     * @return mixed
     * @throws Exception\DomainException
     */
    public function onDispatch(MvcEvent $e)
    {
        $server = $this->getOAuth2Server($this->params('oauth'));
        // Handle a request for an OAuth2.0 Access Token and send the response to the client
        if (!$server->verifyResourceRequest($this->getOAuth2Request())) {
            // Not authorized return 401 error
            $viewModel = $this->acceptableViewModelSelector($this->acceptCriteria);
            $viewModel->setVariables(array('payload' => new ApiProblem(401, "Invalid Access Token")));

            if ($viewModel instanceof RestfulJsonModel) {
                $viewModel->setTerminal(true);
            }

            $e->setResult($viewModel);

            return $viewModel;
        }

        return parent::onDispatch($e);
    }


    /**
     * Return collection of resources
     *
     * @return Response|HalCollection
     */
    public function getList()
    {
        if (!$this->isMethodAllowedForCollection()) {
            return $this->createMethodNotAllowedResponse($this->collectionHttpOptions);
        }

        $events = $this->getEventManager();
        $events->trigger('getList.pre', $this, array());

        try {
            $collection = $this->resource->fetchAll($this->params()->fromQuery());
        } catch (\Exception $e) {
            $code = $e->getCode() ?: 500;

            return new ApiProblem($code, $e);
        }

        if ($collection instanceof ApiProblem) {
            return $collection;
        }

        $plugin     = $this->plugin('HalLinks');
        $collection = $plugin->createCollection($collection, $this->route);
        $collection->setCollectionRoute($this->route);
        $collection->setIdentifierName($this->getIdentifierName());
        $collection->setResourceRoute($this->route);
        $collection->setPage($this->getRequest()->getQuery('page', 1));
        $collection->setCollectionName($this->collectionName);

        $pageSize = $this->pageSizeParam
        ? $this->getRequest()->getQuery($this->pageSizeParam, $this->pageSize)
        : $this->pageSize;
        $collection->setPageSize($pageSize);

        $events->trigger('getList.post', $this, array('collection' => $collection));
        return $collection;
    }

    /**
     * Create an OAuth2 request based on the ZF2 request object
     *
     * Marshals:
     *
     * - query string
     * - body parameters, via content negotiation
     * - "server", specifically the request method and content type
     * - raw content
     * - headers
     *
     * This ensures that JSON requests providing credentials for OAuth2
     * verification/validation can be processed.
     *
     * @return OAuth2Request
     */
    protected function getOAuth2Request()
    {
        $zf2Request = $this->getRequest();
        $headers    = $zf2Request->getHeaders();

        // Marshal content type, so we can seed it into the $_SERVER array
        $contentType = '';
        if ($headers->has('Content-Type')) {
            $contentType = $headers->get('Content-Type')->getFieldValue();
        }

        // Get $_SERVER superglobal
        $server = [];
        if ($zf2Request instanceof PhpEnvironmentRequest) {
            $server = $zf2Request->getServer()->toArray();
        } elseif (!empty($_SERVER)) {
            $server = $_SERVER;
        }
        $server['REQUEST_METHOD'] = $zf2Request->getMethod();

        // Seed headers with HTTP auth information
        $headers = $headers->toArray();
        if (isset($server['PHP_AUTH_USER'])) {
            $headers['PHP_AUTH_USER'] = $server['PHP_AUTH_USER'];
        }
        if (isset($server['PHP_AUTH_PW'])) {
            $headers['PHP_AUTH_PW'] = $server['PHP_AUTH_PW'];
        }

        // Ensure the bodyParams are passed as an array
        $bodyParams = $this->bodyParams() ?: [];

        return new OAuth2Request(
            $zf2Request->getQuery()->toArray(),
            $bodyParams,
            [], // attributes
            [], // cookies
            [], // files
            $server,
            $zf2Request->getContent(),
            $headers
        );
    }

    /**
     * Retrieve the OAuth2\Server instance.
     *
     * If not already created by the composed $serverFactory, that callable
     * is invoked with the provided $type as an argument, and the value
     * returned.
     *
     * @param string $type
     * @return OAuth2Server
     * @throws RuntimeException if the factory does not return an OAuth2Server instance.
     */
    private function getOAuth2Server($type)
    {
        if ($this->server instanceof Server) {
            return $this->server;
        }
        $server = call_user_func($this->serverFactory, $type);
        if (! $server instanceof Server) {
            throw new RuntimeException(sprintf(
                'OAuth2\Server factory did not return a valid instance; received %s',
                (is_object($server) ? get_class($server) : gettype($server))
            ));
        }
        $this->server = $server;
        return $server;
    }
}

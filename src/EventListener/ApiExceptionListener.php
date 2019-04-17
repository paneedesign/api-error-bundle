<?php
declare(strict_types=1);

/**
 * User: Patrick Luca Fazzi
 * Date: 13/03/19
 * Time: 12.38
 */

namespace PED\ApiErrorBundle\EventListener;

use PED\ApiErrorBundle\Discrimination\DiscriminationStrategyInterface;
use PED\ApiErrorBundle\ResponseBuilder\ResponseBuilderInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

final class ApiExceptionListener
{
    /**
     * @var DiscriminationStrategyInterface
     */
    private $discriminator;

    /**
     * @var ResponseBuilderInterface
     */
    private $responseBuilder;

    /**
     * ApiExceptionListener constructor.
     *
     * @param DiscriminationStrategyInterface $discriminator
     * @param ResponseBuilderInterface $responseBuilder
     */
    public function __construct(
        DiscriminationStrategyInterface $discriminator,
        ResponseBuilderInterface $responseBuilder
    ) {
        $this->discriminator = $discriminator;
        $this->responseBuilder = $responseBuilder;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if (!$this->discriminator->inApiContext($event->getRequest())) {
            return null;
        }

        $response = $this->responseBuilder->build($event->getException());

        $event->setResponse($response);
    }
}

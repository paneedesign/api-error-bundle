<?php
declare(strict_types=1);

/**
 * User: Patrick Luca Fazzi
 * Date: 13/03/19
 * Time: 12.38
 */

namespace PaneeDesign\ApiErrorBundle\EventListener;

use PaneeDesign\ApiErrorBundle\Discrimination\DiscriminationStrategyInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

final class ApiExceptionListener
{
    /**
     * @var DiscriminationStrategyInterface
     */
    private $discriminator;

    /**
     * ApiExceptionListener constructor.
     *
     * @param DiscriminationStrategyInterface $discriminator
     */
    public function __construct(DiscriminationStrategyInterface $discriminator)
    {
        $this->discriminator = $discriminator;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if (!$this->discriminator->inApiContext($event->getRequest())) {
            return;
        }

        // TODO: view handling

//        $response = $this->viewHandler->handle(
//            View::create(
//                $this->makeRepresentation($exception),
//                $this->determineStatusCode($exception),
//                ['Content-Type' => 'application/problem+json']
//            ),
//            $event->getRequest()
//        );
//
//        $event->setResponse($response);
    }
}

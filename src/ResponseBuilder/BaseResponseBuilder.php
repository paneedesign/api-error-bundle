<?php
declare(strict_types=1);

/**
 * User: Patrick Luca Fazzi
 * Date: 13/03/19
 * Time: 17.35
 */

namespace PaneeDesign\ApiErrorBundle\ResponseBuilder;

use PaneeDesign\ApiErrorBundle\ExceptionMapper\ErrorDetailsMapperInterface;
use PaneeDesign\ApiErrorBundle\ExceptionMapper\MappingStrategyInterface;
use PaneeDesign\ApiErrorBundle\ExceptionMapper\AbstractParametersExtractor;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


final class BaseResponseBuilder implements ResponseBuilderInterface
{
    /**
     * @var bool
     */
    private $debug;

    /**
     * @var MappingStrategyInterface
     */
    private $mapper;

    /**
     * @var AbstractParametersExtractor
     */
    private $parameterExtractor;

    /**
     * @var ErrorDetailsMapperInterface
     */
    private $errorDetails;


    public function build(\Exception $exception): Response
    {
        $type = $this->mapper->map($exception);

        return new JsonResponse(
            $this->buildContent($exception, $type),
            $this->errorDetails->statusCode($type),
            [
                'Content-Type' => 'application/problem+json'
            ]
        );
    }

    private function buildContent(\Exception $exception, string $type): array
    {
        $error = [
            'type'   => $type,
            'title'  => $this->errorDetails->title($type),
            'params' => $this->parameterExtractor->processException($exception),
        ];

        if (empty($error['params'])) {
            unset($error['params']);
        }

        if ('dev' === $this->debug) {
            $error['exception'] = FlattenException::create($exception);
        }

        return $error;
    }
}

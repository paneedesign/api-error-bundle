<?php
declare(strict_types=1);

/**
 * User: Patrick Luca Fazzi
 * Date: 13/03/19
 * Time: 17.35
 */

namespace PED\ApiErrorBundle\ResponseBuilder;

use PED\ApiErrorBundle\ExceptionMapper\ErrorDetailsMapperInterface;
use PED\ApiErrorBundle\ExceptionMapper\MappingStrategyInterface;
use PED\ApiErrorBundle\ExceptionMapper\AbstractParametersExtractor;
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

    /**
     * BaseResponseBuilder constructor.
     *
     * @param bool $debug
     * @param MappingStrategyInterface $mapper
     * @param AbstractParametersExtractor $parameterExtractor
     * @param ErrorDetailsMapperInterface $errorDetails
     */
    public function __construct(
        bool $debug,
        MappingStrategyInterface $mapper,
        AbstractParametersExtractor $parameterExtractor,
        ErrorDetailsMapperInterface $errorDetails
    ) {
        $this->debug              = $debug;
        $this->mapper             = $mapper;
        $this->parameterExtractor = $parameterExtractor;
        $this->errorDetails       = $errorDetails;
    }


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

        if ($this->debug) {
            $error['exception'] = FlattenException::create($exception)->toArray();
        }

        return $error;
    }
}

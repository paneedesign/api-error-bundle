<?php
declare(strict_types=1);

/**
 * User: Patrick Luca Fazzi
 * Date: 20/03/19
 * Time: 14.58
 */

namespace PaneeDesign\ApiErrorBundle\ExceptionMapper;

use PaneeDesign\ApiErrorBundle\Exception\ParametricExceptionInterface;

final class ParametricExceptionExtractor extends AbstractParametersExtractor
{
    public function handleParametricExceptionInterface(ParametricExceptionInterface $exception): ?array
    {
        return $exception->getParameters();
    }

    protected function handledExceptions(): array
    {
        return [
            ParametricExceptionInterface::class => 'handleParametricExceptionInterface'
        ];
    }
}

<?php
declare(strict_types=1);

/**
 * User: Patrick Luca Fazzi
 * Date: 20/03/19
 * Time: 13.32
 */

namespace PED\ApiErrorBundle\ExceptionMapper;

interface MappingStrategyInterface
{
    public const UNKNOWN_ERROR = 'UNKNOWN_ERROR';

    /**
     * @param \Exception $exception
     *
     * @return string Error type
     */
    public function type(\Exception $exception): string;

    public function forwardMessage(\Exception $exception): bool;
}

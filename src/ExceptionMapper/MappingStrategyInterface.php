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

    public function map(\Exception $exception): string;
}

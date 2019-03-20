<?php
declare(strict_types=1);

/**
 * User: Patrick Luca Fazzi
 * Date: 20/03/19
 * Time: 12.13
 */

namespace PaneeDesign\ApiErrorBundle\ExceptionMapper;

interface ErrorDetailsMapperInterface
{
    public function title(string $type): string;

    public function statusCode(string $type): int;
}

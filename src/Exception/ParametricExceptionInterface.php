<?php
declare(strict_types=1);

/**
 * User: Patrick Luca Fazzi
 * Date: 20/03/19
 * Time: 12.16
 */

namespace PaneeDesign\ApiErrorBundle\Exception;

interface ParametricExceptionInterface
{
    public function getParameters(): array;
}

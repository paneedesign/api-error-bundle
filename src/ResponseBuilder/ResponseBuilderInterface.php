<?php
declare(strict_types=1);

/**
 * User: Patrick Luca Fazzi
 * Date: 13/03/19
 * Time: 17.32
 */

namespace PED\ApiErrorBundle\ResponseBuilder;

use Symfony\Component\HttpFoundation\Response;

interface ResponseBuilderInterface
{
    public function build(\Exception $exception): Response;
}

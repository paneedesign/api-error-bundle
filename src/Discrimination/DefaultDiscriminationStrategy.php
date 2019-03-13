<?php
declare(strict_types=1);

/**
 * User: Patrick Luca Fazzi
 * Date: 13/03/19
 * Time: 13.15
 */

namespace PaneeDesign\ApiErrorBundle\Discrimination;

use Symfony\Component\HttpFoundation\Request;

final class DefaultDiscriminationStrategy implements DiscriminationStrategyInterface
{
    public function inApiContext(Request $request): bool
    {
        $apiPath = '/api/';

        return $apiPath === substr($request->getPathInfo(), 0, strlen($apiPath));
    }
}

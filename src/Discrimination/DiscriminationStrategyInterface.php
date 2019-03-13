<?php
declare(strict_types=1);

/**
 * User: Patrick Luca Fazzi
 * Date: 13/03/19
 * Time: 13.12
 */

namespace PaneeDesign\ApiErrorBundle\Discrimination;

use Symfony\Component\HttpFoundation\Request;

interface DiscriminationStrategyInterface
{
    public function inApiContext(Request $request): bool;
}

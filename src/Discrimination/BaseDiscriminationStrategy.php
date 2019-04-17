<?php
declare(strict_types=1);

/**
 * User: Patrick Luca Fazzi
 * Date: 13/03/19
 * Time: 13.15
 */

namespace PED\ApiErrorBundle\Discrimination;

use Symfony\Component\HttpFoundation\Request;

final class BaseDiscriminationStrategy implements DiscriminationStrategyInterface
{
    /**
     * @var string
     */
    private $apiBasePath;

    /**
     * DefaultDiscriminationStrategy constructor.
     *
     * @param string $apiBasePath
     */
    public function __construct(string $apiBasePath)
    {
        $this->apiBasePath = $apiBasePath;
    }

    public function inApiContext(Request $request): bool
    {
        return $this->apiBasePath === substr($request->getPathInfo(), 0, strlen($this->apiBasePath));
    }
}

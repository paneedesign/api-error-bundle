<?php
declare(strict_types=1);

/**
 * User: Patrick Luca Fazzi
 * Date: 20/03/19
 * Time: 13.34
 */

namespace PaneeDesign\ApiErrorBundle\ExceptionMapper;

final class FqcnMappingStrategy implements MappingStrategyInterface
{
    /**
     * @var array
     */
    private $map;

    /**
     * FqcnMappingStrategy constructor.
     *
     * @param array $map
     */
    public function __construct(array $map)
    {
        $this->map = $map;
    }

    public function map(\Exception $exception): string
    {
        foreach ($this->map as $fqcn => $type) {
            if ($fqcn === get_class($exception)) {
                return $type;
            }
        }

        return static::UNKNOWN_ERROR;
    }
}

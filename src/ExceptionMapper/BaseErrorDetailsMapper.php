<?php
declare(strict_types=1);

/**
 * User: Patrick Luca Fazzi
 * Date: 20/03/19
 * Time: 12.54
 */

namespace PED\ApiErrorBundle\ExceptionMapper;

use Symfony\Component\HttpFoundation\Response;

final class BaseErrorDetailsMapper implements ErrorDetailsMapperInterface
{
    /**
     * @var array
     */
    private $map;

    /**
     * BaseExceptionMapper constructor.
     *
     * @param array $map
     */
    public function __construct(array $map)
    {
        $this->map = $map;
    }

    public function title(string $type): string
    {
        if (array_key_exists($type, $this->map)) {
            return $this->map[$type]['title'];
        }

        return '';
    }

    public function statusCode(string $type): int
    {
        if (array_key_exists($type, $this->map)) {
            return $this->map[$type]['statusCode'];
        }

        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}

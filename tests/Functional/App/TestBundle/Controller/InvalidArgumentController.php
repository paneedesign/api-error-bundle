<?php
declare(strict_types=1);

namespace PED\ApiErrorBundle\Tests\Functional\App\TestBundle\Controller;

final class InvalidArgumentController
{
    const MESSAGE = "Parameter 'aParameter' is invalid.";

    public function __invoke()
    {
        throw new \InvalidArgumentException(self::MESSAGE);
    }
}

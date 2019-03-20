<?php
declare(strict_types=1);

/**
 * User: Patrick Luca Fazzi
 * Date: 20/03/19
 * Time: 14.57
 */

namespace PaneeDesign\ApiErrorBundle\ExceptionMapper;

abstract class AbstractParametersExtractor
{
    /**
     * @var self
     */
    protected $successor;

    public function setSuccessor(AbstractParametersExtractor $successor): void
    {
        $this->successor = $successor;
    }

    public function processException(\Exception $exception): ?array
    {
        $subscribedTo = $this->subscribe();
        if (array_key_exists($fqcn = get_class($exception), $subscribedTo)) {
            $method = $subscribedTo[$fqcn];
            return $this->$method($exception);
        }

        if (null === $this->successor) {
            return null;
        }

        return $this->successor->processException($exception);
    }

    abstract protected function subscribe(): array;
}

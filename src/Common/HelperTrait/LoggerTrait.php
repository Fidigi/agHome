<?php
namespace App\Common\HelperTrait;

use Psr\Log\LoggerInterface;

trait LoggerTrait
{
    /**
     * @var LoggerInterface|null
     */
    private $logger;

    /**
     * @required
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function logEmergency($message, array $context = array())
    {
        if ($this->logger) {
            $this->logger->emergency($message, $context);
        }
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function logAlert($message, array $context = array())
    {
        if ($this->logger) {
            $this->logger->alert($message, $context);
        }
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function logCritical($message, array $context = array())
    {
        if ($this->logger) {
            $this->logger->critical($message, $context);
        }
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function logError($message, array $context = array())
    {
        if ($this->logger) {
            $this->logger->error($message, $context);
        }
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function logWarning($message, array $context = array())
    {
        if ($this->logger) {
            $this->logger->warning($message, $context);
        }
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function logNotice($message, array $context = array())
    {
        if ($this->logger) {
            $this->logger->notice($message, $context);
        }
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function logInfo($message, array $context = array())
    {
        if ($this->logger) {
            $this->logger->info($message, $context);
        }
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function logDebug($message, array $context = array())
    {
        if ($this->logger) {
            $this->logger->debug($message, $context);
        }
    }
}
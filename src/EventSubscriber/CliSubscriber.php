<?php

declare(strict_types=1);

namespace Beter\Bundle\BeterLoggingBundle\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class CliSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly string $startTime
    ) {}

    public function onConsoleCommand(ConsoleCommandEvent $event): void
    {
        try {
            $command = $event->getCommand()?->getName();
        } catch (\Throwable $t) {
            $this->logger->error('An error occurred during the context gathering', ['exception' => $t]);
        }

        $this->logger->info('CLI command start', ['command' => $command ?? 'unknown']);
    }

    public function onConsoleError(ConsoleErrorEvent $event): void
    {
        $context = [];
        try {
            $command = $event->getCommand()?->getName();
            $context['command'] = $command ?? 'unknown';
            $context['exitStatus'] = $event->getExitCode();
            $context['execTimeSec'] = microtime(true) - $this->startTime;
            $context['memoryPeakUsageBytes'] = memory_get_peak_usage(true);
        } catch (\Throwable $t) {
            $this->logger->error('An error occurred during the context gathering', ['exception' => $t]);
        }

        $this->logger->info('CLI command error', $context);
    }

    public function onConsoleTerminate(ConsoleTerminateEvent $event): void
    {
        $context = [];
        try {
            $command = $event->getCommand()?->getName();
            $context['command'] = $command ?? 'unknown';
            $context['exitStatus'] = $event->getExitCode();
            $context['execTimeSec'] = microtime(true) - $this->startTime;
            $context['memoryPeakUsageBytes'] = memory_get_peak_usage(true);
        } catch (\Throwable $t) {
            $this->logger->error('An error occurred during the context gathering', ['exception' => $t]);
        }

        $this->logger->info('CLI command end', $context);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ConsoleEvents::COMMAND => 'onConsoleCommand',
            ConsoleEvents::ERROR => 'onConsoleError',
            ConsoleEvents::TERMINATE => 'onConsoleTerminate',
        ];
    }
}
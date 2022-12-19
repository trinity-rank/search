<?php

namespace Trinityrank\Search\Traits;

use Exception;
use Symfony\Component\Process\Process;

trait ShellExecuteCommand
{
    public static function shell_execute($cmd): string
    {
        $process = Process::fromShellCommandline($cmd);

        $processOutput = '';

        $captureOutput = function ($type, $line) use (&$processOutput) {
            $processOutput .= $line;
        };

        $process->setTimeout(null)
            ->run($captureOutput);

        if ($process->getExitCode()) {
            $exception = new Exception($cmd . " - " . $processOutput);
            report($exception);

            throw $exception;
        }

        echo $processOutput;
        
        return $processOutput;
    }
}

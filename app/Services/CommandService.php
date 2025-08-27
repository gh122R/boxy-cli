<?php

declare(strict_types=1);

namespace Boxy\Services;

use Exception;
use League\CLImate\CLImate;

readonly class CommandService
{
    public function __construct(
        private MessageService $message,
        public CLImate $cliMate
    ) {
    }

    /**
     * @param string $path
     * @param string $title
     * @param string $type
     * @param string $template
     * @param bool $output
     * @return bool
     */
    public function makeFile(
        string $path,
        string $title,
        string $type,
        string $templatePath = '',
        bool $output = true
    ): bool {
        $file = "$title.$type";

        if (!is_dir($path)) {
            if (!mkdir($path, 0777, true) && !is_dir($path)) {
                $this->message->error("Не удалось создать директорию '$path'");

                return false;
            }
        }

        if (file_exists("$path/$file")) {
            $this->message->error("Файл $file уже существует в '$path'");

            return false;
        }

        try {
            $template = $templatePath && file_exists($templatePath)
                ? file_get_contents($templatePath)
                : '';

            file_put_contents("$path/$file", $template);

            if ($output) {
                $this->message->success("Файл $file создан в '$path'");
            }

            return true;
        } catch (Exception) {
            logger()->error("Ошибка при создании файла $file");

            if ($output) {
                $this->message->error("Произошла ошибка при создании файла $file");
            }
        }

        return false;
    }

    /**
     * @param string $filePath
     * @param bool $output
     * @return bool
     */
    public function deleteFile(string $filePath, bool $output = true): bool
    {
        try {
            unlink($filePath);

            if ($output) {
                $this->message->success("Файл $filePath успешно удалён");
            }

            return true;
        } catch (Exception) {
            logger()->error("Произошла ошибка при удалении файла $filePath");

            if ($output) {
                $this->message->error("Произошла ошибка при удалении файла $filePath");
            }
        }

        return false;
    }

    /**
     * @param string $command
     * @param bool $showOutput
     * @return bool
     */
    public function execute(string $command, bool $showOutput = false): bool
    {
        exec($command, $output, $returnCode);

        if ($showOutput) {
            echo implode("\n", $output) . "\n";
        }

        if ($returnCode !== 0) {
            logger()->error("Ошибка выполнения команды: $command");

            return false;
        }

        return true;
    }
}
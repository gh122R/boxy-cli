<?php

namespace Command\basic;

use App\Interfaces\Command\CommandInterface;
use App\ParentClasses\Command;
use App\Traits\CommandGuide;
use League\CLImate\CLImate;

use function Laravel\Prompts\text;

class WelcomeCommand extends Command implements CommandInterface
{
    use CommandGuide;

    protected string $command = 'help';
    protected string $description = 'Выводит welcome-информацию :)';
    protected array $options = [];
    protected array $flags = [];

    public function __construct()
    {
        $this->options = [
            'search' => [$this, 'search'],
        ];

        $this->flags = [
            'someFlag' => [$this, 'test'],
        ];
    }

    public function __invoke()
    {
        $climate = new CLImate();

        $climate->br();

        $climate->addArt(ART_DIR);

        $climate->green()->animation('box-1')->speed(200)->enterFrom('top');

        $climate->red()->dim(env('app_name') . " | версия: " . env('app_version'));
        $climate->dim('Версия php: ' . phpversion());
        $climate->dim('Разработал: ' . env('author'));

        $guide = $this->guideAll();

        $climate->br();

        foreach ($guide as $info) {
            $climate->green()->bold()->out("Команда: {$info['command']}");

            if (!empty($info['description'])) {
                $climate->tab()->out("Описание: {$info['description']}");
            }

            if (!empty($info['options'])) {
                $climate->tab()->out(" - Опции: " . implode(', ', array_keys($info['options'])));
            }

            if (!empty($info['flags'])) {
                $climate->tab()->out(" - Флаги: " . implode(', ', array_keys($info['flags'])));
            }

            if (is_array($info['action'])) {
                [$class, $method] = $info['action'];

                $climate->tab()->out(" - Ответственный за вызов: $class");
                $climate->tab()->out(" - Вызываемый метод: $method");
            }

            if (is_callable($info['action'])) {
                $climate->tab()->out(" - Ответственный за вызов: замыкание");
            }

            if (!is_array($info['action']) && !is_callable($info['action'])) {
                $climate->tab()->out(" - Ответственный за вызов: {$info['action']}");
            }

            if ($info['parameters'] !== null) {
                if (is_array($info['parameters'])) {
                    $climate->tab()->out(" - Параметры для передачи в вызов: " . implode(', ', $info['parameters']));
                }
            }

            $climate->br();
        }
    }

    public function search()
    {
        $command = text(
            label: 'Какую команду ищешь?',
            hint: 'Попробуем найти команду и вывести информацию о ней'
        );
    }

    public function test()
    {
        $cli = new CLImate();

        $cli->out('Это просто тестовый флаг');
    }
}
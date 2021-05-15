<?php

namespace Application\config;

use RuntimeException;

class DotEnv
{
    protected string $path;

    public function __construct(string $path = null)
    {
        $this->path = $path ?? __DIR__ . '/../.env';
    }

    public function load()
    {
        if (!file_exists($this->path)) {
            throw new \InvalidArgumentException(sprintf('%s does not exist', $this->path));
        }

        if (!is_readable($this->path)) {
            throw new RuntimeException(sprintf('%s file is not readable', $this->path));
        }

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {

            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}

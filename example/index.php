<?php

use Dotenv\Dotenv;
use Illuminate\Config\Repository;

require __DIR__.'/../vendor/autoload.php';

// Load .env to $_ENV
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

class Config extends Repository
{
    protected string $configPath;

    public function __construct(array $items = [])
    {
        parent::__construct($items);

        $this->configPath = __DIR__.'/../config';
        $this->loadConfigFiles();
    }

    protected function loadConfigFiles()
    {
        $files = glob($this->configPath.'/*.php');
        $files = array_map('realpath', $files);

        foreach ($files as $file) {
            $this->set(basename($file, '.php'), require $file);
        }
    }
}

$config = new Config;

var_dump($config->all());
echo "\n----------------\n";
echo $config->get('app.name');
echo "\n----------------\n";
echo $config->get('app.title');

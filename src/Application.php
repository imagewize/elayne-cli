<?php

namespace Imagewize\ElaynePatternCli;

use Imagewize\ElaynePatternCli\Commands\PatternCreateCommand;
use Imagewize\ElaynePatternCli\Commands\PatternListCommand;
use Symfony\Component\Console\Application as BaseApplication;

class Application extends BaseApplication
{
    public function __construct()
    {
        parent::__construct('Elayne Pattern CLI', '1.0.0');

        $this->add(new PatternCreateCommand());
        $this->add(new PatternListCommand());
        $this->setDefaultCommand('list');
    }
}

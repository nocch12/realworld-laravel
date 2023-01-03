<?php

namespace App\Console\Commands;

// use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand; // Laravel本体を参考に、継承元を変更。

class UseCaseMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:usecase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    
    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'UseCase';
    
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->laravel->basePath(trim('/stubs/usecase.stub', '/'));
    }
    
    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\UseCases';
    }
}

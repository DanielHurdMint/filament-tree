<?php

namespace SolutionForest\FilamentTree\Commands;

use Filament\Support\Commands\Concerns\CanManipulateFiles;
use Filament\Support\Commands\Concerns\CanValidateInput;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeTreePageCommand extends Command
{
    use CanManipulateFiles;
    use CanValidateInput;
    protected $signature = "make:filament-tree-page {name?} {--R|resource=}";

    public $description = 'Creates a Filament tree page class';

    protected ?string $resourceClass = null;
    protected string $page;
    protected string $pageClass;

    public function handle(): int
    {
        $this->page =  Str::of(strval($this->argument('name') ?? $this->askRequired('Name (e.g. `Settings`)', 'name')))
            ->trim('/')
            ->trim('\\')
            ->trim(' ')
            ->replace('/', '\\');

        $this->pageClass = (string) Str::of($this->page)->afterLast('\\');

        $this->askResourceClass();

        $this->createPage();

        $this->info("Successfully created {$this->page}!");

        return static::SUCCESS;
    }

    protected function createPage(): void
    {
        $path = config('filament.pages.path', app_path('Filament/Pages/'));
        $resourcePath = config('filament.resources.path', app_path('Filament/Resources/'));

        $namespace = config('filament.pages.namespace', 'App\\Filament\\Pages');
        $resourceNamespace = config('filament.resources.namespace', 'App\\Filament\\Resources');
        $pageNamespace = Str::of($this->page)->contains('\\') ?
            (string) Str::of($this->page)->beforeLast('\\') :
            '';
        
        $resourceClass = $this->resourceClass;
        $stub = $this->getStub();

        $path = (string) Str::of($this->pageClass)
            ->prepend('/')
            ->prepend($resourceClass === null ? $path : "{$resourcePath}\\{$resourceClass}\\Pages\\")
            ->replace('\\', '/')
            ->replace('//', '/')
            ->append('.php');

        if ($resourceClass === null) {

            $this->copyStubToApp($stub, $path, [
                'class' => $this->pageClass,
                'namespace' => $namespace . ($pageNamespace !== '' ? "\\{$pageNamespace}" : ''),
            ]);
        } else {
            $this->copyStubToApp($stub, $path, [
                'namespace' => "{$resourceNamespace}\\{$resourceClass}\\Pages" . ($pageNamespace !== '' ? "\\{$pageNamespace}" : ''),
                'resource' => "{$resourceNamespace}\\{$resourceClass}",
                'class' => $this->pageClass,
                'resourceClass' => $resourceClass,
            ]);
        }

    }

    protected function getStub(): string
    {
        return $this->resourceClass ? 'TreeResourcePage' : 'TreePage';
    }

    protected function askResourceClass(): void
    {
        $resourceInput = $this->option('resource') ?? $this->ask('(Optional) Resource (e.g. `UserResource`)');

        if ($resourceInput !== null) {
            $resource = (string) Str::of($resourceInput)
                ->studly()
                ->trim('/')
                ->trim('\\')
                ->trim(' ')
                ->replace('/', '\\');

            if (! Str::of($resource)->endsWith('Resource')) {
                $resource .= 'Resource';
            }

            $this->resourceClass = (string) Str::of($resource)
                ->afterLast('\\');
        }
    }
}

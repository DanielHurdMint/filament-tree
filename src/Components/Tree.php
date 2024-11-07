<?php

namespace SolutionForest\FilamentTree\Components;

use Filament\Forms\ComponentContainer;
use Filament\Support\Components\ViewComponent;
use Illuminate\Database\Eloquent\Model;
use SolutionForest\FilamentTree\Concern\BelongsToLivewire;
use SolutionForest\FilamentTree\Contract\HasTree;
use SolutionForest\FilamentTree\Support\Utils;

class Tree extends ViewComponent
{
    use BelongsToLivewire;

    protected string $view = 'filament-tree::components.tree.index';

    protected string $viewIdentifier = 'tree';

    protected int $maxDepth = 999;

    protected array $actions = [];

    public $treeRecords = [];
    public $expandedIds = [];

    public const LOADING_TARGETS = ['activeLocale', 'expand'];

    public function __construct(HasTree $livewire)
    {
        $this->livewire($livewire);
    }

    public static function make(HasTree $livewire): static
    {
        $result = app(static::class, ['livewire' => $livewire]);

        $result->configure();

        return $result;
    }

    public function maxDepth(int $maxDepth): static
    {
        $this->maxDepth = $maxDepth;

        return $this;
    }

    public function actions(array $actions): static
    {
        $this->actions = $actions;

        return $this;
    }

    public function getMaxDepth(): int
    {
        return $this->maxDepth;
    }

    public function getActions(): array
    {
        return $this->actions;
    }

    public function getModel(): string
    {
        return $this->getLivewire()->getModel();
    }

    public function getRecordKey(?Model $record): ?string
    {
        if (! $record) {
            return null;
        }
        return $record->getAttributeValue($record->getKeyName());
    }

    public function getParentKey(?Model $record):?string
    {
        if (! $record) {
            return null;
        }
        return $record->getAttributeValue((method_exists($record, 'determineParentKey') ? $record->determineParentColumnName() : Utils::parentColumnName()));
    }

    public function getMountedActionForm(): ?ComponentContainer
    {
        return $this->getLivewire()->getMountedTreeActionForm();
    }

    public function loadChildren($parentId)
    {
        $record = $this->getLivewire()->getModel()::find($parentId);

        if (!$record) {
            return [];
        }

        // Load children with count of their children
        $record->load(['children' => function ($query) {
            $query->withCount('children')->ordered();
        }]);

        $treeRecords = $this->getLivewire()->treeRecords;
        $treeRecords[$parentId] = $record->children;
        $this->getLivewire()->treeRecords = $treeRecords;
        $this->treeRecords = $treeRecords;

        $expandedIds = $this->getLivewire()->expandedIds;
        $expandedIds[$parentId] = $parentId;
        $this->getLivewire()->expandedIds = $expandedIds;
        $this->expandedIds = $expandedIds;
    }

    public function expand($id)
    {
        $expandedIds = $this->getLivewire()->expandedIds;
        if (!array_key_exists($id, $expandedIds)) {
            $expandedIds[$id] = $id;
        } else {
            unset($expandedIds[$id]);
        }
        $this->getLivewire()->expandedIds = $expandedIds;
        $this->expandedIds = $expandedIds;
    }
}

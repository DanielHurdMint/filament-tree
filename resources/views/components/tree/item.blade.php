@php use Illuminate\Database\Eloquent\Model; @endphp
@php use Filament\Facades\Filament; @endphp
@php use SolutionForest\FilamentTree\Components\Tree; @endphp
@props(['record', 'containerKey', 'tree', 'title' => null, 'icon' => null, 'hasChildren' => false, 'isLoaded' => false, 'parentIds' => null])
@php
    /** @var $record Model */
    /** @var $containerKey string */
    /** @var $tree Tree */

    $recordKey = $tree->getRecordKey($record);
    $parentKey = $tree->getParentKey($record);
    $collapsed = $this->getNodeCollapsedState($record);
    $actions = $tree->getActions();
@endphp

<li class="filament-tree-row dd-item"
    data-id="{{ $recordKey }}"
    wire:key="tree-item-{{ $recordKey }}"
    x-data="{
        isLoading: false,
        isLoaded: {{ $isLoaded ? 'true' : 'false' }},
        hasChildren: {{ $hasChildren ? 'true' : 'false' }},

        async loadChildren() {
            if (this.isLoaded || this.isLoading) return;

            this.isLoading = true;
            await @this.loadChildren('{{ $recordKey }}')
            this.isLoaded = true;
            this.isLoading = false;
        }
    }"
>
    <div wire:loading.remove.delay
        wire:target="{{ implode(',', Tree::LOADING_TARGETS) }}"
        @class([
            'rounded-lg border dd-handle h-10',
            'mb-2',
            'flex w-full items-center',
            'border-gray-300 bg-white dark:border-white/10 dark:bg-gray-900',
        ])>

        <button type="button" @class([
            'h-full flex items-center',
            'rounded-l-lg border-r rtl:rounded-l rtl:border-r-0 rtl:border-l px-px',
            'bg-gray-50 border-gray-300 dark:bg-white/5 dark:border-white/10',
        ])>
            <x-heroicon-m-ellipsis-vertical class="text-gray-400 dark:text-gray-500 w-4 h-4 -mr-2 rtl:mr-0 rtl:-ml-2"/>
            <x-heroicon-m-ellipsis-vertical class="text-gray-400 dark:text-gray-500 w-4 h-4"/>
        </button>

        <div class="dd-content dd-nodrag flex gap-1">
            @if ($icon)
                <div class="w-4">
                    <x-dynamic-component :component="$icon" class="w-4 h-4"/>
                </div>
            @endif

            <span @class([
                'ml-4 rtl:mr-4' => !$icon,
                'font-semibold'
            ])>
                {{ $title }}
            </span>

            @if ($hasChildren)
                <div @class(['dd-item-btns', 'flex items-center justify-center pl-3'])>
                    <button
                        data-action="expand"
                        @class(['hidden' => !$collapsed])
                        @click="loadChildren"
                    >
                        <x-heroicon-o-chevron-down class="text-gray-400 w-4 h-4" />
                    </button>
                    <button data-action="collapse" @class(['hidden' => $collapsed])>
                        <x-heroicon-o-chevron-up class="text-gray-400 w-4 h-4" />
                    </button>
                </div>
            @endif
        </div>

        @if (count($actions))
            <div class="dd-nodrag ml-auto rtl:ml-0 rtl:mr-auto">
                <x-filament-tree::actions :actions="$actions" :record="$record" />
            </div>
        @endif
    </div>

    <div x-show="isLoading" class="ml-8 my-2">
        <x-filament::loading-indicator class="h-4 w-4"/>
    </div>

    @if ($hasChildren)
        <div wire:loading.remove wire:target="loadChildren">
            <div x-show="isLoaded">
                @if(!$isLoaded)
                    <div wire:ignore></div>
                @else
                    <x-filament-tree::tree.list
                        :records="$record->children"
                        :containerKey="$containerKey"
                        :tree="$tree"
                        :collapsed="null"
                        :parent-id="$recordKey"
                    />
                @endif
            </div>
        </div>
    @endif
</li>

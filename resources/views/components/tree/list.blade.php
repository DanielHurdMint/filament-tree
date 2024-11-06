@props([
    'records',
    'containerKey',
    'tree',
    'collapsed' => null,
    'parentId' => null,
])
<ol @class([
    'filament-tree-list',
    'dd-list',
    'hidden' => $collapsed,
])>
@php
    $childrenRecords = $parentId ? $tree->treeRecords[$parentId] : $records;
@endphp
    @foreach ($childrenRecords ?? [] as $record)
        @php
            $title = $this->getTreeRecordTitle($record);
            $icon = $this->getTreeRecordIcon($record);
            $recordKey = $tree->getRecordKey($record);
            // if (array_key_exists($recordKey, $tree->treeRecords)) {
            // dd($tree->treeRecords);
            // }
        @endphp
        <x-filament-tree::tree.item
            :record="$record"
            :containerKey="$containerKey"
            :tree="$tree"
            :title="$title"
            :icon="$icon"
            :has-children="$record->children()->count() > 0"
            :is-loaded="array_key_exists($recordKey, $tree->treeRecords) ? true : false"
            wire:key="tree-item-{{ $recordKey }}"
        />
    @endforeach
</ol>

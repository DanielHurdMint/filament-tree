@php
    use Illuminate\View\ComponentAttributeBag;
    $columns = [
        'default' => 1,
    ];
@endphp
<x-filament::page class="filament-tree-page">
    <div
        {{
            (new ComponentAttributeBag)
                ->grid($columns)
                ->class(['gap-4'])
        }}
    >
        <div {{
            (new ComponentAttributeBag)
                ->gridColumn($columns['default'])
        }}>
            {{ $this->tree }}
        </div>

    </div>
</x-filament::page>

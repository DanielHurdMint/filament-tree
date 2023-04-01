<?php

namespace SolutionForest\FilamentTree\Actions;

use Closure;
use Filament\Forms\ComponentContainer;
use Filament\Support\Actions\Concerns\CanCustomizeProcess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class EditAction extends Action
{
    use CanCustomizeProcess;
    
    protected ?Closure $mutateRecordDataUsing = null;

    public static function getDefaultName(): ?string
    {
        return 'edit';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('filament-support::actions/edit.single.label'));

        $this->modalHeading(fn (): string => __('filament-support::actions/edit.single.modal.heading', ['label' => $this->getRecordTitle()]));

        $this->modalButton(__('filament-support::actions/edit.single.modal.actions.save.label'));

        $this->successNotificationTitle(__('filament-support::actions/edit.single.messages.saved'));

        $this->icon('heroicon-s-pencil');

        $this->iconButton();

        $this->mountUsing(function (ComponentContainer $form, Model $record): void {
            $data = $record->attributesToArray();

            if ($this->mutateRecordDataUsing) {
                $data = $this->evaluate($this->mutateRecordDataUsing, ['data' => $data]);
            }

            $form->fill($data);
        });

        $this->action(function (): void {
            dd($this);
            $this->process(function (array $data, Model $record) {
                dd($data, $record);

                $record->update($data);
            });

            $this->success();
        });
    }

    public function mutateRecordDataUsing(?Closure $callback): static
    {
        $this->mutateRecordDataUsing = $callback;

        return $this;
    }
}

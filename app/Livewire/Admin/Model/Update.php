<?php

namespace App\Livewire\Admin\Model;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Livewire\Traits\Alert;
use App\Models\ConsoleModel;
use App\Models\Console;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;

class Update extends Component
{
    use Alert;

    public ConsoleModel $model;
    public $years, $consoles;

    public bool $modal = false;

    public function mount(): void
    {
        $this->years = range(date('Y'),1970);
        $this->consoles = Console::all();
    }

    #[On('load::model')]
    public function load($id): void
    {
        $this->model = ConsoleModel::findOrFail($id);

        $this->modal = true;
    }

    public function render()
    {
        return view('livewire.admin.model.update');
    }

    public function rules(): array
    {
        return [
            'model.console_id' => [
                'required',
                'integer',
                'max:255'
            ],
            'model.model' => [
                'required',
                'string',
                'max:255'
            ],
            'model.release_year' => [
                'nullable',
                'integer',
                'digits:4'
            ],
            'model.storage_capacity' => [
                'nullable',
                'string',
                'max:255'
            ]
        ];
    }

    public function save(): void 
    {
        $this->validate();

        $this->model->save();

        $this->modal = false;

        $this->dispatch('updated');

        $this->resetExcept('consoles','years');

        $this->toast()->success('Model updated successfully!')->send();
    }
}

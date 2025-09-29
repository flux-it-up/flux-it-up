<?php

namespace App\Livewire\Admin\Model;

use Livewire\Component;
use App\Livewire\Traits\Alert;
use App\Models\ConsoleModel;
use App\Models\Console;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;

class Create extends Component
{
    use Alert;

    public ConsoleModel $model;
    public $years, $consoles;

    public bool $modal = false;

    public function mount(): void
    {
        $this->model = new ConsoleModel();
        $this->years = range(date('Y'),1970);
        $this->consoles = Console::all();
    }

    public function render()
    {
        return view('livewire.admin.model.create');
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

        $this->dispatch('created');

        $this->reset('model');
        $this->model = new ConsoleModel();

        $this->toast()->success('Model created successfully!')->send();
    }
}

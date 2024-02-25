<?php

namespace App\Livewire;

use App\Jobs\ProcessTextract;
use Livewire\Component;
use Livewire\WithFileUploads;

class Home extends Component
{
    use WithFileUploads;

    public $attachment;
    public $isUploaded = false;
    public function save() : void
    {
        $file = $this->attachment->store(path: 'files');
        ProcessTextract::dispatch($file);
        $this->isUploaded = true;
    }
    public function render()
    {
        return view('livewire.home');
    }
}

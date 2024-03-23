<?php

namespace App\Livewire;

use App\Jobs\ProcessTextract;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Home extends Component
{
    use WithFileUploads;

    public $attachment;
    public $isUploaded = false;
    public $isLoading = false;

    public $data;

    public function getData($data): void
    {
        $this->data = $data;
        if($this->data) $this->isLoading = false;
    }

    public function submit() : void
    {
        $file = $this->attachment->store(path: 'files');
        ProcessTextract::dispatch($file);
        $this->isUploaded = true;
        $this->isLoading = true;
    }

    public function rescan(): void
    {
        $this->isUploaded = false;
    }

    public function render(): View
    {
        return view('livewire.home');
    }
}

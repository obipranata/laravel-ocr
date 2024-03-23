<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class Form extends Component
{
    public $nik, $nama, $tglLahir, $alamat, $agama, $status, $pekerjaan, $kewarganegaraan;

    public function mount($data): void
    {
        $this->nik = $data['nik'];
        $this->nama = $data['nama'];
        $this->tglLahir = $data['tgl_lahir'];
        $this->alamat = $data['alamat'];
        $this->agama = $data['agama'];
        $this->status = $data['status'];
        $this->pekerjaan = $data['pekerjaan'];
        $this->kewarganegaraan = $data['kewarganegaraan'];
    }

    public function render(): View
    {
        return view('livewire.form');
    }
}

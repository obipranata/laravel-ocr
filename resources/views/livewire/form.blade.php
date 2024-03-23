<div class="grid gap-6 mb-6 md:grid-cols-2 ">
    <x-form.input wire:model="nik" type="number" :label="'NIK'" />
    <x-form.input wire:model="nama" :label="'Nama'" />
    <x-form.input wire:model="tglLahir" :label="'Tempat Tanggal Lahir'" />
    <x-form.input wire:model="alamat" :label="'Alamat'" />
    <x-form.input wire:model="agama" :label="'Agama'" />
    <x-form.input wire:model="status" :label="'Status Perkawinan'" />
    <x-form.input wire:model="pekerjaan" :label="'Pekerjaan'" />
    <x-form.input wire:model="kewarganegaraan" :label="'Kewarganegaraan'" />
</div>

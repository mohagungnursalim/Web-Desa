<?php

namespace App\Livewire\Dashboard\About;

use App\Models\About as ModelsAbout; // Pastikan nama model sudah benar
use Livewire\Component;

class About extends Component
{
    public $description;

    public function mount()
    {
        // Ambil deskripsi dari database, misalnya id 1 untuk data awal
        $about = ModelsAbout::find(1); // Sesuaikan ID atau kondisi yang diperlukan
        $this->description = $about->description ?? ''; // Mengambil deskripsi awal
    }

    public function updateDescription()
    {
        // Validasi deskripsi
        $this->validate([
            'description' => 'required|string|min:10', // Sesuaikan aturan validasi
        ]);

            // Update deskripsi di database
            $about = ModelsAbout::find(1); // Ambil record dengan id yang sudah ada
            $about->description = $this->description;
            $about->save();

           $this->dispatch('updateSuccess');
    }

    public function render()
    {
        return view('livewire.dashboard.about.about');
    }
}

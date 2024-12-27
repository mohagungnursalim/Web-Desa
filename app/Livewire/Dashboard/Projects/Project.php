<?php

namespace App\Livewire\Dashboard\Projects;

use App\Models\Project as ModelsProject;
use Livewire\WithFileUploads;
use Livewire\Component;

class Project extends Component
{
    use WithFileUploads;

    public $search = '';
    public $limit = 8;
    public $totalProjects;
    public $projects;
    public $project_id;
    public $image = [], $imagePaths = [], $project_name, $project_description, $start_date, $end_date;
    public $existingImages = [];

    // delete
    public $projectId;
    public $projectName;

    public function mount()
    {
        $this->totalProjects = ModelsProject::count();
        $this->projects = collect();
    }

    public function updatingSearch()
    {
        $this->limit = 8;
    }

    public function updatedSearch()
    {
        usleep(500000);
        $this->loadInitialProjects();
    }

    public function loadInitialProjects()
    {
       $this->projects = ModelsProject::where('project_name', 'like', '%' . $this->search . '%')->latest()->take($this->limit)->get();

    }
    public function loadMore()
    {
        $this->limit += 8;
        $this->loadInitialProjects();
    }

    protected function storeRules()
    {
        return [
            'image' => 'required|array|min:1',
            'image.*' => 'required|image|max:5120',
            'project_name' => 'required|string|max:250',
            'project_description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ];
    }

    protected function updateRules()
    {
        return [
            'image' => 'nullable|array',
            'image.*' => 'nullable|image|max:5120',
            'project_name' => 'required|string|max:250',
            'project_description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ];
    }

    public function resetForm()
    {
        $this->reset(['image', 'project_name', 'project_description', 'start_date', 'end_date']);
    }


    public function store()
    {
        $this->validate($this->storeRules());
        
        foreach ($this->image as $img) {
            $imagePaths[] = $img->store('project-images', 'public');
        }
        
        sleep(1);
       $newProject = ModelsProject::create([
            'image' => json_encode($imagePaths),
            'project_name' => $this->project_name,
            'project_description' => $this->project_description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date
        ]);

        $this->projects->prepend($newProject);
        $this->totalProjects++;

        $this->resetForm();
        $this->dispatch('closeAddProjectModal');
        $this->dispatch('addedSuccess');
        
    }

    public function openUpdateModal($id)
    {
        try {
            $project = ModelsProject::findOrFail($id);
            $this->project_id = $project->id;
            $this->project_name = $project->project_name;
            $this->project_description = $project->project_description;
            $this->start_date = $project->start_date;
            $this->end_date = $project->end_date;
            $this->existingImages = json_decode($project->image, true);
            
            $this->dispatch('initSummernote'); // Kirim event untuk inisialisasi summernote
            $this->dispatch('openEditProjectModal'); // Kirim event untuk membuka modal dengan jQuery
        } catch (\Throwable $th) {
            $this->dispatch('error'); // Event untuk menampilkan pesan gagal
        }
    }

    public function closeUpdateModal()
    {
        $this->dispatch('closeUpdateModal');
    }

    public function update()

    {
        $this->validate($this->updateRules());

        $project = ModelsProject::find($this->project_id);

        $imagePaths = [];
        $updateData = [
            'project_name' => $this->project_name,
            'project_description' => $this->project_description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ];

        if (!empty($this->image) && is_array($this->image)) {
            if ($project->image) {
                $oldImages = json_decode($project->image, true);
                foreach ($oldImages as $oldImage) {
                    $oldImagePath = public_path('storage/' . $oldImage);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
            }

            foreach ($this->image as $img) {
                if ($img instanceof \Illuminate\Http\UploadedFile) {
                    $imagePaths[] = $img->store('project-images', 'public');
                }
            }

            if (!empty($imagePaths)) {
                $updateData['image'] = json_encode($imagePaths);
            }
        }

        sleep(1);
        $project->update($updateData);

        $this->closeUpdateModal();
        $this->dispatch('projectUpdated');
        // Emit event untuk menutup modal
        $this->dispatch('closeEditProjectModal');
    }


    public function confirmDelete($id, $project_name)
    {
        try {
            ModelsProject::findOrFail($id);
            $this->projectId = $id;
            $this->projectName = $project_name;
            $this->dispatch('show-delete-modal');
        } catch (\Throwable $th) {
            $this->dispatch('error'); // Event untuk menampilkan pesan gagal
        }
    }

    public function delete()
    {
       
        // Cari project berdasarkan ID
        $project = ModelsProject::find($this->projectId);
            
            // Lokasi gambar
            $imagePaths = json_decode($project->image, true);

            // Hapus semua gambar yang terkait dengan project ini
            if ($imagePaths && is_array($imagePaths)) {
                foreach ($imagePaths as $imagePath) {
                    $filePath = storage_path('app/public/' . $imagePath);
                    
                    // Cek jika file gambar ada dan hapus
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
            }

            // Hapus project dari database
            $project->delete();

             $this->projects = $this->projects->filter(fn($item) => $item->id !== $this->projectId);
             $this->totalProjects--;

             $this->dispatch('hide-delete-modal'); 
             $this->dispatch('deleteSuccess'); // Event untuk menampilkan pesan sukses

    }


    public function render()
    {
     
        return view('livewire.dashboard.projects.project', [
            'projects' => $this->projects,
            'totalProjects' => $this->totalProjects
        ]);
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ProcurementProject;

class ProcurementTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';

    protected $paginationTheme = 'tailwind'; // Optional for Tailwind styling

    public function updatingSearch()
    {
        $this->resetPage(); // Reset to page 1 on search
    }

    public function updatingStatus()
    {
        $this->resetPage(); // Reset to page 1 on filter
    }

    public function render()
    {
        $projects = ProcurementProject::query()
            ->when($this->search, fn ($query) =>
                $query->where('pr_number', 'like', "%{$this->search}%")
                      ->orWhere('procurement_project', 'like', "%{$this->search}%")
                      ->orWhere('end_user', 'like', "%{$this->search}%")
            )
            ->when($this->status, fn ($query) =>
                $query->where('status', $this->status)
            )
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('livewire.procurement-table', compact('projects'));
    }
}

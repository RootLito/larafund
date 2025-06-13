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
    public string $mode = '';

    protected $paginationTheme = 'tailwind'; 

    public function updatingSearch()
    {
        $this->resetPage(); 
    }

    public function updatingStatus()
    {
        $this->resetPage(); 
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
            ->when($this->mode, function ($query) {
                if ($this->mode === 'others') {
                    $query->whereNotIn('mode_of_procurement', [
                        'Public Bidding',
                        'Direct Contracting',
                        'Small Value Procurement',
                        'Emergency Cases',
                    ]);
                } else {
                    $query->where('mode_of_procurement', $this->mode);
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('livewire.procurement-table', compact('projects'));
    }
}

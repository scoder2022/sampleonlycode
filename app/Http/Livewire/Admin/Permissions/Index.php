<?php

namespace App\Http\Livewire\Admin\Permissions;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class Index extends Component
{
    use WithPagination;

    public $updateMode = false;
    protected $paginationTheme = 'bootstrap';
    public $all_categories;
    public $sortBy = "created_at";
    public $sorting = "desc";
    public $status;
    public $search;
    protected $queryString = ['search'];
    protected $listeners = [
        'refreshParent' => '$refresh',
        'response'=>'render'
    ];

    public function sortBy($sortBy,$sorting)
    {
        $sorting == 'desc'?$this->sorting='asc':$this->sorting='desc';
        $this->sortBy = $sortBy;
    }

    public function render()
    {
        $search = $this->search;
        $data = Permission::orderBy($this->sortBy,$this->sorting)
        ->when($this->search !='', function ($query) use ($search){
            $query->whereLike('name', $search);
        })->paginate(10);
        return view('livewire.admin.permissions.index', [
            'data' => $data
        ]);
    }

}

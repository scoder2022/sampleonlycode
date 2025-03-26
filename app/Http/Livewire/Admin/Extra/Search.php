<?php

namespace App\Http\Livewire\Admin\Extra;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Search extends Component
{
    public $search;
    protected $queryString = ['search'];
    public function mount($model){
        $search = $this->search;
        DB::table($model)->when($this->search !='', function ($query) use ($search){
            $query->whereLike('email', $this->search,'end');
        })->paginate(10);
    }

    public function render()
    {
        return view('livewire.admin.extra.search');
    }
}

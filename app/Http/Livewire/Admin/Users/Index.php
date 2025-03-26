<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\user;
use App\Traits\ExtraTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination,WithFileUploads,ExtraTraits;

    public  $listeners = ['fileChosen'=>'handleFileUpload','updateStatus'=>'updateStatus'];

    protected $paginationTheme = 'bootstrap';
    public $base_route = 'admin.users';
    public $images_path;
    public $image;
    public $all_categories;
    public $sortBy = "created_at";
    public $sorting = "desc";
    public $status;
    public $search;
    protected $queryString = ['search'];

    public function handleFileUpload($imageData)
    {
        $this->user_icon = $imageData;
    }

    public function DeleteImage(User $user)
    {
       if(!deleteFile($user,'user')){
        session()->flash('error','Sorry The user Has Not Been Updated Now');
        return redirect()->route($this->base_route.'.index');
       }
    }

    public function changeImage(User $user)
    {
    }

    public function updateStatusf($id)
    {
        dd($id);
        $this->emitSelf('updateStatus');
    }

    public function sortBy($sortBy,$sorting)
    {
        $sorting == 'desc'?$this->sorting='asc':$this->sorting='desc';
        $this->sortBy = $sortBy;
    }

    public function render()
    {
        $search = $this->search;
        $data = User::orderBy($this->sortBy,$this->sorting)
        ->when($this->search !='', function ($query) use ($search){
            $query->whereLike('email', $search,'end');
        })->paginate(10);
        return view('livewire.admin.users.index', [
            'data' => $data,
            'base_route'=>$this->base_route
        ]);
    }
}

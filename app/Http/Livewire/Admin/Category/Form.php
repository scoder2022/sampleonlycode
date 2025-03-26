<?php

namespace App\Http\Livewire\Admin\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;
    public $name,$image,$status,$category,$all_categories,$images_path,$loading_now;
    public $panel = "Category";
    public $email, $user_id;
    public $updateMode = false;
    protected $model = "App\Models\Category";
    protected $listeners = ['imageload'];

    public function imageload()
    {
        $this->dispatchBrowserEvent('name-updated', ['state' => 'show']);
    }

    public function mount($all_categories){
        $this->all_categories = $all_categories;
    }

    public function updatingImage($value)
    {
        $this->dispatchBrowserEvent('name-updated', ['state' => 'show']);
    }

    public function updatedImage($value)
    {
        $this->dispatchBrowserEvent('name-updated', ['state' => 'hide']);
    }

    private function resetInputFields(){
        $this->name = '';
        $this->email = '';
    }

    public function store()
    {
        dd('her');
        $validatedDate = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);
        Category::create($validatedDate);

        session()->flash('message', 'Users Created Successfully.');

        $this->resetInputFields();

        $this->emit('userStore'); // Close model to using to jquery

    }

    public function edit($id)
    {
        $this->updateMode = true;
        $user = Category::where('id',$id)->first();
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;

    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();


    }

    public function update()
    {
        $validatedDate = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        if ($this->user_id) {
            $user = Category::find($this->user_id);
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);
            $this->updateMode = false;
            session()->flash('message', 'Users Updated Successfully.');
            $this->resetInputFields();

        }
    }

    public function delete($id)
    {
        if($id){
            Category::where('id',$id)->delete();
            session()->flash('message', 'Users Deleted Successfully.');
        }
    }

    public function render()
    {
        return view('livewire.admin.category.form')->with(['all_categories'=>$this->all_categories]);
    }
}

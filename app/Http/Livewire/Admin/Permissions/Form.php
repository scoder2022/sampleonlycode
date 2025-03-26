<?php

namespace App\Http\Livewire\Admin\Permissions;

use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;

class Form extends Component
{
    use WithFileUploads;

    public $name,$guard_name;

    protected $listeners = [
        'fileUpload'=>'handleFileUpload'
    ];

    public function store()
    {

        $this->validate([
            'name' => 'required|unique:permissions,id',
            'guard_name' => 'required',
        ]);

        try{
            Permission::create([
                'name'=>$this->name,
                'guard_name'=>'web'
            ]);
            $this->emit('response','success','User Created Successfully');
            $this->cancel();
        }catch(\Exception $e){
            session()->flash('error', $e->getMessage());
            Log::alert($e->getMessage());
        }


    }

    public function edit($id)
    {
        $this->updateMode = true;
        $permission = Permission::where('id',$id)->first();
        $this->model_id = $id;
        $this->name = $permission->name;
        $this->email = $permission->guard_name;
     }

    public function cancel()
    {
        $this->updateMode = false;
        $this->name = null;
        $this->modelId = null;

         $this->cleanVars();
         $this->resetInputFields();
         $this->resetErrorBag();
         $this->resetValidation();
    }

    public function update()
    {
       $this->validate([
        'name' => 'required',
        ]);

        if ($this->modelId) {
            $permission = Permission::find($this->modelId);

            $permission->update([
                'name' => $this->name,
                'guard_name'=>'web'
            ]);

            $this->updateMode = false;
            session()->flash('message', 'permission Updated Successfully.');
            $this->resetInputFields();
            $this->emit('userStore');
        }
    }
    public function delete($id)
    {
        if($id){
            Permission::where('id',$id)->delete();
            session()->flash('message', 'permission Deleted Successfully.');
        }
    }

    public function render()
    {
        return view('livewire.admin.permissions.form');
    }
}

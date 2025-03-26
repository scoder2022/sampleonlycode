<?php

namespace App\Http\Livewire\Admin\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{

    use WithFileUploads;
    protected $listeners = ['imageload'];
    public $name, $slug, $image, $description, $parent_id, $data_id, $all_categories, $images_path, $loading_now, $search, $current_category, $current_image;
    public $panel = "Category", $sortBy = "id", $sorting = "desc", $base_route = "admin.category", $model = "App\Models\Category", $updateMode = false, $status = 1;


    protected function rules()
    {
        return [
            'name' => 'required|unique:categories,slug,' . $this->data_id,
            'image' => 'nullable|image|max:2100',
            'parent_id' => 'required|exists:categories,id',
            'status' => 'required|boolean'
        ];
    }

    public function hydrate()
    {
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('loading', ['state' => 'hide']);
    }
    public function updated($propertyName)
    {
        $this->dispatchBrowserEvent('loading', ['state' => 'hide']);
        $this->slug = str_slug($this->name);
        $this->validateOnly($propertyName);
    }

    public function imageload()
    {
        $this->dispatchBrowserEvent('loading', ['state' => 'show']);
    }

    public function updatingName()
    {
        $this->dispatchBrowserEvent('loading', ['state' => 'show']);
    }

    public function updatedName()
    {
        $this->dispatchBrowserEvent('loading', ['state' => 'hide']);
        $this->emit('loadckeditor');
    }

    public function sortBy($sortBy, $sorting)
    {
        $sorting == 'desc' ? $this->sorting = 'asc' : $this->sorting = 'desc';
        $this->sortBy = $sortBy;
    }

    public function statusf()
    {
        $this->status == 1 ? $this->status = 'jere' : $this->status = 'asdfsadf';
    }

    public function mount($all_categories)
    {
        $this->all_categories = $all_categories;
        $this->panel = 'Category';
    }

    public function updatingImage($value)
    {
        $this->dispatchBrowserEvent('loading', ['state' => 'show']);
    }

    public function updatedImage($value)
    {
        $this->dispatchBrowserEvent('loading', ['state' => 'hide']);
    }

    public function resetInputFields()
    {
        $this->updateMode = false;
        $this->current_category = null;
        $this->data_id = null;
        $this->name = null;
        $this->slug = null;
        $this->description = null;
        $this->current_image = null;
        $this->parent_id = null;
        $this->status = null;
    }

    public function store()
    {
        $validatedDate = $this->validate();
        if ($this->image != null) {
            $file_name = files_uploads($this->image, $this->panel, null);
        }
        $file_name = files_uploads($this->image, $this->panel, null);
        Category::create(array_except($validatedDate, 'image') + [
            'slug' => str_slug($this->name),
            'description' => $this->description,
            'image' => isset($file_name) ? $file_name : null,
        ]);

        session()->flash('success', $this->panel . ' Created Successfully.');

        $this->resetInputFields();

        $this->emit('data_store'); // Close model to using to jquery

    }

    public function edit($id)
    {
        $this->image = null;
        $this->dispatchBrowserEvent('loading', ['state' => 'show']);
        $this->emit('loadckeditor');
        $this->updateMode = true;
        $this->current_category = Category::findOrfail($id);
        $this->data_id = $this->current_category->id;
        $this->name = $this->current_category->name;
        $this->slug = $this->current_category->slug;
        $this->description = $this->current_category->description;
        $this->current_image = $this->current_category->image;
        $this->parent_id = $this->current_category->parent_id;
        $this->status = $this->current_category->status;
        $this->dispatchBrowserEvent('loading', ['state' => 'hide']);
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function update()
    {
        $validatedDate = $this->validate();

        if ($this->data_id) {
            $data = check_exists($this->data_id, $this->model);

            if ($this->image != null) {
                $file_name = files_uploads($this->image, $this->panel, $data != null ? $data->image : null);
            }
            $data->update(array_except($validatedDate, 'image') + [
                'slug' => str_slug($this->name),
                'description' => $this->description,
                'image' => isset($file_name) ? $file_name : $data->image,
            ]);
        }


        session()->flash('success', $this->panel . ' Updated Successfully.');

        // $this->resetExcept('search', 'all');
        $this->resetInputFields();
        $this->emit('data_store'); // Close model to using to jquery
    }

    public function delete($id)
    {
        if ($id) {
            Category::where('id', $id)->delete();
            session()->flash('message', 'Users Deleted Successfully.');
        }
    }


    public function render()
    {
        $search = $this->search;
        $data = Category::orderBy($this->sortBy, $this->sorting)
            ->when($this->search != '', function ($query) use ($search) {
                $query->whereLike('name', $search, 'end');
            })->paginate(10);
        return view('livewire.admin.category.index', [
            'data' => $data
        ]);
    }
}

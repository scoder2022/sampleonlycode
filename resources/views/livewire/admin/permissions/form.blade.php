<div>
    <form wire:submit.prevent="store" enctype="multipart/form-data">
        <div class="form-group">
            <label for="exampleFormControlInput1">Name</label>
            <input type="text" name="name" wire:model="name"  placeholder="Enter Name"  class="form-control">
            @error('name') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput2">Web</label>
            <select wire:model="guard_name" class="form-control" name="guard_name">
                <option selected disabled>Select Guard</option>
                <option value="admin" {{ checked_values('select','admin',old('guard_name')) }}>Admin</option>
                <option value="web" {{ checked_values('select','web',old('guard_name')) }}>Web</option>
            </select>
            @error('guard_name') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>
        <div class="modal-footer">

                    <button type="submit" class="btn btn-primary btn-blue font-white" wire:click.prevent="store()" >Create
                        New</button>
                    <button type="button" class="btn btn-danger btn-red" wire.click.prevent="cancel()" data-dismiss="modal">Close</button>
        </div>
    </form>
</div>


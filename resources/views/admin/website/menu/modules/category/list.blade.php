<div class="modal-content">
    <form action="{{ route('admin.menu.attach_module',$menu->id) }}" method="post">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title">
                {{ $menu->menu_name }} :: Link Modules
            </h5>
        </div>
        <div class="modal-body">
            <input type="hidden" name="type" value='categories' />
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="category" class="label-control">
                            Category
                        </label>
                        <select name="link" id="category" class="form-control">
                            @foreach (categories() as $category)
                            <option value='{{ $category->id }}'>{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4 mt-4">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Attach Category </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">

        </div>
    </form>
</div>
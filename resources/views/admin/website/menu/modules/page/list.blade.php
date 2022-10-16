<div class="modal-content">
    <form action="{{ route('admin.website.menus.attach_module',$menu->id) }}" method="post">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title">
                {{ $menu->menu_name }} :: Link Modules
            </h5>
        </div>
        <div class="modal-body">
            <input type="hidden" name="type" value='pages' />
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="category" class="label-control">
                            Select Page
                        </label>
                        <select name="link" id="category" class="form-control">
                            <?php
                            $pages = \App\Models\Page::get();
                            ?>
                            @foreach ($pages as $page)
                            <option value='{{ $page->id }}'>{{ $page->page_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Attach Page </button>

        </div>
    </form>
</div>
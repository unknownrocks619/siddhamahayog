<div class="modal-content">
    <form action="{{ route('admin.menu.attach_module',$menu->id) }}" method="post">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title">
                {{ $menu->menu_name }} :: Link Modules
            </h5>
        </div>
        <div class="modal-body">
            <input type="hidden" name="type" value='posts' />
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="category" class="label-control">
                            Select Post
                        </label>
                        <select name="link" id="category" class="form-control">
                            <?php
                            $posts = \App\Models\Post::get();
                            ?>
                            @foreach ($posts as $post)
                            <option value='{{ $post->id }}'>{{ $post->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Attach Category </button>

        </div>
    </form>
</div>
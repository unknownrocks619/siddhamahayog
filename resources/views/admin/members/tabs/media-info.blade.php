<!-- Project table -->
<div class="card mb-4">
    <div class="card-header">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-between align-items-center">
                <h5 class="card-header">`{{ $member->full_name }}` Media file</h5>
                <button class="btn btn-primary btn-icon" data-bs-toggle="collapse" data-bs-target="#uploadMedia">
                    <i class="fas fa-upload"></i>
                </button>
            </div>
        </div>
        <div id="uploadMedia" class="collapse">
            <form action="{{ route('admin.members.media.upload', ['member' => $member]) }}" method="post"
                class="ajax-component-form ajax-append">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="file">Select File</label>
                            <input type="file" name="file" id="file" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="file_type">File Type</label>
                            <select name="file_type" id="file_type" class="form-control">
                                @foreach (\App\Models\Member::IMAGE_TYPES as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 text-end">
                        <button type="submit" class="btn btn-primary">
                            Upload Image
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="row">
        @foreach ($member->media as $media)
            <div class="col-md-3 bg-white">
                <div class="bg-label-primary rounded-3 text-center pt-4 mx-1 mb-0 pb-0">
                    <img class="img-fluid"
                        src="{{ \App\Classes\Helpers\Image::getImageAsSize($media->image->filepath, 'm') }}"
                        alt="Card girl image" width="140">
                    <h4 class="p-1">{{ \App\Models\Member::IMAGE_TYPES[$media->type] }}</h4>
                </div>
                <div class="bg-white text-end">
                    <button class="btn btn-danger btn-icon data-confirm"
                        data-action="{{ route('admin.members.media.delete', ['member' => $member, 'relation' => $media->getKey()]) }}"
                        data-method="post"
                        data-confirm="Are you sure you want to remove selected media from user. This action cannot be undone, it will be reflected to user end as well. Do you wish to continue.">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        @endforeach

    </div>
</div>

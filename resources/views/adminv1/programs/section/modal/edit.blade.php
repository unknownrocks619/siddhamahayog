<form method="post" action="{{ route('admin.program.sections.admin_update_section',$section->id) }}">
    @method("PUT")
    @csrf
    <div class="modal-body">
        <div class="modal-header bg-dark text-white">
            <h4 class="title" id="largeModalLabel">{{ $section->section_name }} - <small>Edit</small></h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <b>
                            Section Name
                            <sup class="text-danger">
                                *
                            </sup>
                        </b>
                        <input type="text" value="{{$section->section_name}}" name="section_name" required class='form-control' id="section_time" />
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <b>
                            Make Default Section
                            <sup class="text-danger">*</sup>
                        </b>
                        <div class="form-group">
                            <div class="radio inlineblock m-r-20">
                                <input type="radio" name="default" @if($section->default) checked @endif id="default_yes_edit" class="with-gap" value="1">
                                <label for="default_yes_edit">Yes</label>
                            </div>                                
                            <div class="radio inlineblock">
                                <input type="radio" name="default" @if( $section->default == false) checked @endif id="default_no_edit" class="with-gap" value="0">
                                <label for="default_no_edit">No</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="row display-content" style="display:contents">
                <div class="col-md-4 text-left mr-4">
                    <button type="button" data-dismiss="modal" class='btn btn-sm btn-danger'>Close</button>
                </div>
                <div class="col-md-8 text-right">
                    <button type="submit" style="float:right;clear:both" class="btn btn-primary btn-block btn-sm ">Update Section</button>
                </div>
            </div>
        </div>                
    </div>
</form>
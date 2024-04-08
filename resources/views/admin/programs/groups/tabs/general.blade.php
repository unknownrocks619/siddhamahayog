<form action="{{route('admin.program.admin_program_group_edit',['program' => $program,'group' => $group])}}" method="post" class="ajax-component-form">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="group_name">Group name
                    <sup class="text-danger">*</sup>
                </label>
                <input type="text" name="group_name" value="{{$group->group_name}}" id="group_name" class="form-control" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="card_sample">Card Sample
                    <sup class="text-danger">*</sup>
                </label>
                <input type="file" name="card_sample" id="card_sample" class="form-control" />
            </div>
        </div>
        
        
        <div class="col-md-6 mt-4">
            <div class="form-group">
                <label for="print_size_height">Actual Print Size In Height (in Pixel)
                    <sup class="text-danger">*</sup>
                </label>
                <input type="number" value="{{$group->actual_print_height}}" name="print_size_height" id="print_size_height" class="form-control">

            </div>
        </div>
        <div class="col-md-6 mt-4">
            <div class="form-group">
                <label for="print_size_width">
                    Actual Print Size in Width (in Pixel)
                    <sup class="text-danger">*</sup>
                </label>
                <input type="number" value="{{$group->actual_print_width}}" name="print_size_width" id="print_size_width" class="form-control">
            </div>
        </div>

    </div>

    <div class="row my-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="primary_colour">Primary Colour
                    <sup class="text-danger">*</sup>
                </label>
                <input type="color" value="{{$group->print_primary_colour}}" name="primary_colour" id="primary_colour" class="form-control">
            </div>
        </div>
    </div>

    <div class="row mt-4 mb-4 rule-wrapper">
        <div class="col-md-12 mb-3">
            <div class="form-group">
                <label for="rules" class="fs-3">Rules</label>
            </div>
        </div>
        @foreach ($group->rules['rules'] ?? [] as $amount => $rules)
            <div class="col-md-12">
                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="text" value="{{$amount}}" name="amount[]" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label >Operator</label>
                            <select name="operator[]"  class="form-control">
                                <option value="gt" @if($rules['operator'] == 'gt') selected @endif> > </option>
                                <option value="gtq"  @if($rules['operator'] == 'gtq') selected @endif> >= </option>
                                <option value="lt"  @if($rules['operator'] == 'lt') selected @endif> < </option>
                                <option value="ltq"  @if($rules['operator'] == 'ltq') selected @endif> <= </option>
                                <option value="eq"  @if($rules['operator'] == 'eq') selected @endif> = </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label >Connector</label>
                            <select name="connector[]"  class="form-control">
                                <option value="">-</option>
                                <option value="or" @if($rules['connector'] == 'or') selected @endif>OR</option>
                                <option value="and"  @if($rules['connector'] == 'and') selected @endif>AND</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-center justify-content-end action-button">
                        @if($loop->first)
                        <button class="btn-primary btn-icon btn" type="button" onclick="window.programGroup.addRules(this,{appendTo:'.rule-wrapper'})"><i class="fas fa-plus"></i></button>
                        @else
                        <button class="btn-danger btn-icon btn" type="button" onclick="window.programGroup.removeRules(this)"><i class="fas fa-trash"></i></button>
                        @endif
                    </div>

                </div>
            </div>
        @endforeach
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="form-group">
                <label for="auto_include">Auto Update User</label>
                <select name="auto_include" id="auto_include" class="form-control">
                    <option value="1" @if($group->enable_auto_adding) selected @endif>Yes</option>
                    <option value="0"  @if( ! $group->enable_auto_adding) selected @endif>No</option>
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="enable_barcode">Enable Barcode Print</label>
                <select name="enable_barcode" id="enable_barcode" class="form-control">
                    <option value="1"  @if($group->enable_barcode) selected @endif>Yes</option>
                    <option value="0" @if(! $group->enable_barcode) selected @endif>No</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="enable_persononal">Enable Personal Info Print</label>
                <select name="enable_persononal" id="enable_persononal" class="form-control">
                    <option value="1"  @if($group->enable_personal_info) selected @endif>Yes</option>
                    <option value="0"  @if( ! $group->enable_personal_info) selected @endif>No</option>
                </select>
            </div>
        </div>
    </div>

    @if($group->resizedImage)
        <div class="row mt-5">
            <div class="col-md-6" style="position:relative">
                <img src="{{App\Classes\Helpers\Image::getImageAsSize($group->resizedImage->filepath,'resized')}}" class=""/>
                <div id="idCardArea" style="position: absolute;min-width:{{$group->id_card_print_width ?? 0}}px;min-height:{{$group->id_card_print_height ?? 0}}px;left:{{$group->id_card_print_position_x ?? 0}}px; top: {{$group->id_card_print_position_y ?? 0}}px;border: 1px dashed"></div>
                <div id="barCodeArea"  style="position: absolute;min-width:{{$group->barcode_print_width ?? 0}}px;min-height:{{$group->barcode_print_height ?? 0}}px;left:{{$group->barcode_print_position_x ?? 0}}px; top: {{$group->barcode_print_position_y ?? 0}}px;border: 1px dashed red"></div>
                <div id="personalInfoArea" style="position: absolute;min-width:{{$group->personal_info_print_width ?? 0}}px;min-height:{{$group->personal_info_print_height ?? 0}}px;left:{{$group->personal_info_print_position_x ?? 0}}px; top: {{$group->personal_info_print_position_y ?? 0}}px;border: 1px dashed green"></div>
            </div>
            <div class="col-md-4">

                <!-- Photo Position -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label >
                                ID Card Width
                            </label>
                            <input type="number" value="{{$group->id_card_print_width}}" onchange="window.programGroup.addIDCardArea()" name="id_width" id="width" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="width">
                                ID Card Height
                            </label>
                            <input type="number"   value="{{$group->id_card_print_height}}"  onchange="window.programGroup.addIDCardArea()" name="id_height" id="width" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="width">
                                Position X
                            </label>
                            <input type="number"  value="{{$group->id_card_print_position_x}}"  onchange="window.programGroup.addIDCardArea()" name="id_position_x" id="width" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="width">
                                Position Y
                            </label>
                            <input type="number"  value="{{$group->id_card_print_position_y}}" onchange="window.programGroup.addIDCardArea()" name="id_position_y" id="width" class="form-control">
                        </div>
                    </div>
                </div>

                <!-- Barcode Positin -->
                <div class="row mt-5 border-top pt-5 ">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="width">
                                        Bar Code Width
                                    </label>
                                    <input type="number" value="{{$group->barcode_print_width}}" onchange="window.programGroup.barCodeArea()" name="barcode_width" id="width" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="width">
                                        Bar Code Height
                                    </label>
                                    <input type="number"  value="{{$group->barcode_print_height}}" onchange="window.programGroup.barCodeArea()" name="barcode_height" id="width" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="width">
                                        Bar Code Position X
                                    </label>
                                    <input type="number"  value="{{$group->barcode_print_position_x}}" onchange="window.programGroup.barCodeArea()" name="barcode_position_x" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >
                                        Bar Code Position Y
                                    </label>
                                    <input type="number"  value="{{$group->barcode_print_position_y}}" onchange="window.programGroup.barCodeArea()" name="barcode_position_y"  class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Text Position -->
                <div class="row mt-5 border-top pt-5 ">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="width">
                                        Text width
                                    </label>
                                    <input type="number" value="{{$group->personal_info_print_width}}" onchange="window.programGroup.personalInfoArea()" name="personal_info_width" id="text_width" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="width">
                                        Text Height
                                    </label>
                                    <input type="number"  value="{{$group->personal_info_print_height}}" onchange="window.programGroup.personalInfoArea()" name="personal_info_height" id="text_height" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="width">
                                        Text Start Position Position X
                                    </label>
                                    <input type="number"  value="{{$group->personal_info_print_position_x}}" onchange="window.programGroup.personalInfoArea()" name="personal_info_position_x" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >
                                        Text End Position Y
                                    </label>
                                    <input type="number"  value="{{$group->personal_info_print_position_y}}" onchange="window.programGroup.personalInfoArea()" name="personal_info_position_y"  class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    @endif

    <div class="card-footer">
        <div class="row">
            <div class="col-md-12 text-end">
                <button class="btn btn-primary" type="submit">Update Group Info</button>
            </div>
        </div>
    </div>
</form>

<!-- Add Children Card -->
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="card-title">Add Family / Sub Group </h5>
        <button type="button" data-bs-toggle="modal" data-bs-target="#childrenCategory" class="btn btn-primary btn-icon"><i class="fas fa-plus"></i></button>
    </div>

    <div class="card-datatable table-responsive">

        <div class="accordion" id="dharamasalaBuilding">
            @foreach ($group->children ?? [] as $children)
                <form action="{{route('admin.program.admin_program_group_edit',['program' => $program,'group' => $children,'tab' => 'general','parentGroup' => $group]) }}" method="post" class="ajax-component-form">
                    <div class="accordion-item">
                        <h2 class="accordion-header bg-success" id="item_{{$children->getKey()}}">
                            <button class="accordion-button d-inline bg-light fs-3" type="button" data-bs-toggle="collapse" data-bs-target="#{{str($children->group_name)->slug('_')}}_{{$children->getKey()}}" aria-expanded="true" aria-controls="collapseOne">
                                {{$children->group_name}}
                            </button>
                        </h2>

                        <div id="{{str($children->group_name)->slug('_')}}_{{$children->getKey()}}" class="accordion-collapse collapse" aria-labelledby="item_{{$children->getKey()}}" data-bs-parent="#dharamasalaBuilding">
                            {{-- @dd($children->resizedImage,$children); --}}
                            <div class="accordion-body my-3">
                                <!-- Card Sample -->

                                <div class="row mt-5">
                                    <div class="col-md-8" style="position:relative">
                                        <img src="{{App\Classes\Helpers\Image::getImageAsSize($children->resizedImage->filepath,'resized')}}" style="width:{{$children->actual_print_width}}px !important; height:{{$children->actual_print_height}}px !important;" />
                                        <div id="idCardAreaChild" style="position: absolute;min-width:{{$children->id_card_print_width ?? 0}}px;min-height:{{$children->id_card_print_height ?? 0}}px;left:{{$children->id_card_print_position_x ?? 0}}px; top: {{$children->id_card_print_position_y ?? 0}}px;border: 1px dashed"></div>
                                        <div id="barCodeAreaChild"  style="position: absolute;min-width:{{$children->barcode_print_width ?? 0}}px;min-height:{{$children->barcode_print_height ?? 0}}px;left:{{$children->barcode_print_position_x ?? 0}}px; top: {{$children->barcode_print_position_y ?? 0}}px;border: 1px dashed red"></div>
                                        <div id="personalInfoAreaChild" style="position: absolute;min-width:{{$children->personal_info_print_width ?? 0}}px;min-height:{{$children->personal_info_print_height ?? 0}}px;left:{{$children->personal_info_print_position_x ?? 0}}px; top: {{$children->personal_info_print_position_y ?? 0}}px;border: 1px dashed green"></div>
                                    </div>
                                    <div class="col-md-4">
                        
                                        <!-- Photo Position -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label >
                                                        ID Card Width
                                                    </label>
                                                    <input type="number" value="{{$children->id_card_print_width}}" onchange="window.programGroup.addIDCardArea('idCardAreaChild')" name="id_width" id="width" class="form-control id_width">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="width">
                                                        ID Card Height
                                                    </label>
                                                    <input type="number"   value="{{$children->id_card_print_height}}"  onchange="window.programGroup.addIDCardArea('idCardAreaChild')" name="id_height" id="width" class="form-control id_height">
                                                </div>
                                            </div>
                                        </div>
                        
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="width">
                                                        Position X
                                                    </label>
                                                    <input type="number"  value="{{$children->id_card_print_position_x}}"  onchange="window.programGroup.addIDCardArea('idCardAreaChild')" name="id_position_x" id="width" class="form-control id_position_x">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="width">
                                                        Position Y
                                                    </label>
                                                    <input type="number"  value="{{$children->id_card_print_position_y}}" onchange="window.programGroup.addIDCardArea('idCardAreaChild')" name="id_position_y" id="width" class="form-control id_position_y">
                                                </div>
                                            </div>
                                        </div>
                        
                                        <!-- Barcode Positin -->
                                        <div class="row mt-5 border-top pt-5 ">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="width">
                                                                Bar Code Width
                                                            </label>
                                                            <input type="number" value="{{$children->barcode_print_width}}" onchange="window.programGroup.barCodeArea('barCodeAreaChild')" name="barcode_width" id="width" class="form-control barcode_width">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="width">
                                                                Bar Code Height
                                                            </label>
                                                            <input type="number"  value="{{$children->barcode_print_height}}" onchange="window.programGroup.barCodeArea('barCodeAreaChild')" name="barcode_height" id="width" class="form-control barcode_height">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="width">
                                                                Bar Code Position X
                                                            </label>
                                                            <input type="number"  value="{{$children->barcode_print_position_x}}" onchange="window.programGroup.barCodeArea('barCodeAreaChild')" name="barcode_position_x" class="form-control barcode_position_x">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label >
                                                                Bar Code Position Y
                                                            </label>
                                                            <input type="number"  value="{{$children->barcode_print_position_y}}" onchange="window.programGroup.barCodeArea('barCodeAreaChild')" name="barcode_position_y"  class="form-control barcode_position_y">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                        
                                        <!-- Text Position -->
                                        <div class="row mt-5 border-top pt-5 ">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="width">
                                                                Text width
                                                            </label>
                                                            <input type="number" value="{{$children->personal_info_print_width}}" onchange="window.programGroup.personalInfoArea('personalInfoAreaChild')" name="personal_info_width" id="text_width" class="form-control personal_info_width">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="width">
                                                                Text Height
                                                            </label>
                                                            <input type="number"  value="{{$children->personal_info_print_height}}" onchange="window.programGroup.personalInfoArea('personalInfoAreaChild')" name="personal_info_height" id="text_height" class="form-control personal_info_height">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="width">
                                                                Text Start Position Position X
                                                            </label>
                                                            <input type="number"  value="{{$children->personal_info_print_position_x}}" onchange="window.programGroup.personalInfoArea('personalInfoAreaChild')" name="personal_info_position_x" class="form-control personal_info_position_x">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label >
                                                                Text End Position Y
                                                            </label>
                                                            <input type="number"  value="{{$children->personal_info_print_position_y}}" onchange="window.programGroup.personalInfoArea('personalInfoAreaChild')" name="personal_info_position_y"  class="form-control personal_info_position_y">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                        
                                    </div>
                        
                                </div>

                                <!-- /Card Sample -->

                                <div class="text-end my-4">
                                    <button class="btn me-3 btn-danger data-confirm" data-method="post" data-action="{{route('admin.program.admin_program_group_delete',['group' => $children,'program' => $program])}}" data-confirm="You are about to delete Group Child This will do you wish to continue ?">
                                        Delete Child
                                    </button>

                                    <button class="btn btn-default" type="submit">
                                        <i class="fas fa-pencil me-2"></i>
                                        Update Child Info
                                    </button>
                            
                                </div>

                            </div>

                        </div>
                    </div>
                </form>
            @endforeach
        </div>
    </div>
</div>

<!-- / End of Children Card -->
<x-modal modal='childrenCategory'>
    <form action="{{route('admin.program.admin_program_group_create',['program' => $program,'group' => $group])}}" method="post" class="ajax-component-form">
        <div class="modal-title p-4 bg-light">
            <h4>Add Sub Category</h4>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="group_name">Group name
                            <sup class="text-danger">*</sup>
                        </label>
                        <input type="text" name="group_name" id="group_name" class="form-control" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="card_sample">Card Sample
                            <sup class="text-danger">*</sup>
                        </label>
                        <input type="file" name="card_sample" id="card_sample" class="form-control" />
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="print_size_height">Actual Print Size In Height (in Pixel)
                            <sup class="text-danger">*</sup>
                        </label>
                        <input type="number" name="print_size_height" id="print_size_height" class="form-control">

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="print_size_width">
                            Actual Print Size in Width
                            <sup class="text-danger">*</sup>
                        </label>
                        <input type="number" name="print_size_width" id="print_size_width" class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <div class="row">
                <div class="col-md-12 text-end">
                    <button class="btn btn-primary">Save Children Group </button>
                </div>
            </div>
        </div>
    </form>
</x-modal>
<div class="row mt-4 bg-light py-4" id="sample_form" style="display:none">
    <div class="col-md-6">
        <div class="form-group">
            <strong>
                Title
            </strong>
            <input type="text" name="title[]" class="form-control" />
        </div>
    </div>

    <div class="col-md-5">
        <strong>Image</strong>
        <input type="file" name="image[]" class="form-control" />
    </div>
    <div class="col-md-1">
        <button type="button" onclick="$(this).closest('.row').remove()" class="btn btn-danger remove_section"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                <polyline points="3 6 5 6 21 6"></polyline>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                <line x1="10" y1="11" x2="10" y2="17"></line>
                <line x1="14" y1="11" x2="14" y2="17"></line>
            </svg></button>
    </div>


    <div class="col-md-6 my-4">
        <div class="form-group">
            <label for="image" class="label-control">Icon
            </label>
            <select name="icons[]" class="form-control">
                <option value="global-icon">Earth</option>
                <option value="cart-with-arrow-down">Shoping Cart with Downarrow</option>
                <option value="lightbulb">Bulb</option>
                <option value="parachute-box">Parachute with box</option>
                <option value="rocket">Rocket</option>
                <option value="cubes">Cubes</option>
            </select>
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <div class="form-group">
            <strong>
                Content
                <sup class="text-danger">*</sup>
            </strong>
            <text-area name="widget_content[]" class="form-control"></text-area>
        </div>
    </div>
</div>
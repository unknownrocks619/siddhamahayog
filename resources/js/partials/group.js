export class ProgramGrouping {
    
    addRules(elm,params={}) {

    let _html =`
                <div class='col-md-12 group-add'>
                    <div class='row mt-3'>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="text" name="amount[]" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label >Operator</label>
                                <select name="operator[]"  class="form-control">
                                    <option value="gt"> > </option>
                                    <option value="gtq"> >= </option>
                                    <option value="lt"> < </option>
                                    <option value="ltq"> <= </option>
                                    <option value="eq"> = </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label >Connector</label>
                                <select name="connector[]"  class="form-control">
                                    <option value="">-</option>
                                    <option value="or">OR</option>
                                    <option value="and" selected>AND</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-center justify-content-end action-button">
                            <button class="btn-danger btn-icon btn" type='button' onclick="window.programGroup.removeRules(this)"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </div>
        `;

        if (params.appendTo) {
            $(elm).closest(params.appendTo).append(_html);
        }
        window.select2Options();
    }

    removeRules(elm) {
        $(elm).closest('.group-add').remove();
    }

    addPeople() {

    }

    addFamily() {

    }

    addIDCardArea() {
        let _elm = $('#idCardArea');
        let _width = $('input[name="id_width"]').val();
        let _height = $('input[name="id_height"]').val();
        let _position_x = $('input[name="id_position_x"]').val();
        let _position_y = $('input[name="id_position_y"]').val();
            
        let _styles = {
            'min-width' : _width +'px',
            'min-height' : _height +'px',
            'left'      : _position_x + 'px',
            'top'       : _position_y + 'px',
            'position'  : 'absolute' ,
            'border'    : '1px dashed'
        }
        _elm.css(_styles);
    }

    barCodeArea() {
        let _elm = $('#barCodeArea');
        let _width = $('input[name="barcode_width"]').val();
        let _height = $('input[name="barcode_height"]').val();
        let _position_x = $('input[name="barcode_position_x"]').val();
        let _position_y = $('input[name="barcode_position_y"]').val();
            
        let _styles = {
            'min-width' : _width +'px',
            'min-height' : _height +'px',
            'left'      : _position_x + 'px',
            'top'       : _position_y + 'px',
            'position'  : 'absolute' ,
            'border'    : '1px dashed red'
        }
        _elm.css(_styles);
    }

    personalInfoArea() {
        let _elm = $('#personalInfoArea');
        let _width = $('input[name="personal_wpersonalth"]').val();
        let _height = $('input[name="personal_height"]').val();
        let _position_x = $('input[name="personal_position_x"]').val();
        let _position_y = $('input[name="personal_position_y"]').val();
            
        let _styles = {
            'min-width' : _width +'px',
            'min-height' : _height +'px',
            'left'      : _position_x + 'px',
            'top'       : _position_y + 'px',
            'position'  : 'absolute' ,
            'border'    : '1px dashed'
        }
        _elm.css(_styles);
    }

}


window.programGroup = new ProgramGrouping;
export class ProgramGrouping {

    #currentCard;

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

    addIDCardArea(targetElm="") {
        
        let _elm = $('#idCardArea');
        let _width = $('input[name="id_width"]').val();
        let _height = $('input[name="id_height"]').val();
        let _position_x = $('input[name="id_position_x"]').val();
        let _position_y = $('input[name="id_position_y"]').val();


        if (targetElm != "") {
            _elm = $('#'+targetElm);
            _width = $('input.id_width').val();
            _height = $('input.id_height').val();
            _position_x = $('input.id_position_x').val();
            _position_y = $('input.id_position_y').val();
    
        }

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

    barCodeArea(targetElm='') {

        let _elm = $('#barCodeArea');

        let _width = $('input[name="barcode_width"]').val();
        let _height = $('input[name="barcode_height"]').val();
        let _position_x = $('input[name="barcode_position_x"]').val();
        let _position_y = $('input[name="barcode_position_y"]').val();

        if (targetElm != '') {
            _elm = $('#'+targetElm);
            _width = $('input.barcode_width').val();
            _height = $('input.barcode_height').val();
            _position_x = $('input.barcode_position_x').val();
            _position_y = $('input.barcode_position_y').val();
        }


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

    personalInfoArea(targetElm='') {

        let _elm = $('#personalInfoArea');

        
        let _width = $('input[name="personal_info_width"]').val();
        let _height = $('input[name="personal_info_height"]').val();
        let _position_x = $('input[name="personal_info_position_x"]').val();
        let _position_y = $('input[name="personal_info_position_y"]').val();

        if (targetElm != '') {
            _elm = $('#'+targetElm);
            _width = $('input.personal_info_width').val();
            _height = $('input.personal_info_height').val();
            _position_x = $('input.personal_info_position_x').val();
            _position_y = $('input.personal_info_position_y').val();
                
        }

        let _styles = {
            'min-width' : _width +'px',
            'min-height' : _height +'px',
            'left'      : _position_x + 'px',
            'top'       : _position_y + 'px',
            'position'  : 'absolute' ,
            'border'    : '1px dashed green'
        }
        _elm.css(_styles);
    }

    updateFamilyGroup(params){

        console.log('card element: ', params);

        let _cardElement = $('#'+params.cardID);
        this.#setCardLoader(true,_cardElement);
        let _getContentFrom = $(params.view).find('.card').html();
        $(_cardElement).html(_getContentFrom);
    }

    #setCardLoader(loading = true, elm={}) {

        let _closestCardElement = '';
        /**
         * Set Element on property
         */
        if (loading === true){
            this.#currentCard = elm;
            _closestCardElement = $(this.#currentCard).find('.card-error');
            let _html =`<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><span class="fw-medium">Holy grail!</span> Your success/error message here.</div>`;
            $(_closestCardElement).html(_html);
            return ;
        }

        if ( elm ) {
            _closestCardElement = $(elm).find('.card-error');

        } else {
            _closestCardElement = $(this.#currentCard).find('.card-error');
        }

        $(_closestCardElement).empty();

    }

}


window.programGroup = new ProgramGrouping;

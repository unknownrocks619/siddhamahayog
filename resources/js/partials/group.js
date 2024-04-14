export class ProgramGrouping {

    #currentCard;
    constructor() {
        let _this = this;

        if ($(document).find('#groupScanning').length) {

            let scannedData = '';

            $('input[id="groupScanning"]').on('keypress', function () {
                _this.scanBarCode(this,5);
            })
            $(document).keydown( function(event) {
                let key = event.key;

                // Check if the pressed key is alphanumeric or Enter
                if (/^[a-zA-Z0-9]$/.test(key) || key === 'Enter') {
                    // Append the pressed key to the buffer

                    scannedData += key;

                    // Check if Enter key is pressed (end of scan)
                    if (key === 'Enter') {
                        // Process the scanned data (e.g., send to server, display on screen, etc.)
                        // console.log('scannedData:', scannedData ,typeof(scannedData));
                        $('#quickCheckIn').val(scannedData.replace('Enter','')).trigger('keypress');
                        // _this.quickCheckIn($('#quickCheckIn'));
                        // Clear the buffer for the next scan
                        scannedData = '';
                    }

                }
            });
        }
    }

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

        let _cardElement = $('#'+params.cardID);
        this.#setCardLoader(true,_cardElement);
        let _getContentFrom = '';
        if (_cardElement.is('tr') ) {
            _getContentFrom = $($(params.view)[0]).html();
            // console.log('tr element: ', $($(params.view)[0]).html());
        } else {

            _getContentFrom = $(params.view).find('.card').html();
        }
        $(_cardElement).html(_getContentFrom);
    }

    userVerification(elm) {
        let _verified = false;

        if ($(elm).is(":checked") ) {
            _verified = true;
        }
        let _url = $(elm).closest('tr').attr('data-action');

        if (_url === undefined) {
            _url = $(elm).parent().attr('data-action');
        }

        console.log('url: ' , _url);
        let _body = {'verified' : _verified};
        $.ajax({
            type : "POST",
            url : _url,
            data : _body,
        })
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

    scanBarCode(elm) {
        console.log('valu: ', $(elm).val());
        if ($(elm).val().length < 8) {
            return ;
        }

        let _this = this;

        let _displayDivWrapper = $('#group-scan-status');
        let _errorWrapper = $('#scanErrorDisplay');

        _errorWrapper.addClass('d-none')
        _displayDivWrapper.addClass('d-none');


        $.ajax({
            type : 'post',
            data : {groupUUID: $(elm).val()},
            url : '/admin/programs/grouping/5/bar-code-scan/'+$(elm).val(),
            success : function(response) {
                let _data = response;
                if (_data.params.class) {
                    _displayDivWrapper.find('div.col-md-12').removeClass('bg-succes')
                                                            .removeClass('bg-danger')
                                                            .addClass(_data.params.class)
                    
                }

                if (_data.params.confirmationText) {
                    _displayDivWrapper.find('#groupConfirmationText').text(_data.params.confirmationText)
                }

                if (_data.params.groupScanCount) {
                    _displayDivWrapper.find('#groupScanCount').text(_data.params.groupScanCount);
                }
                _displayDivWrapper.removeClass('d-none');

                // $(elm).val('');
            },
            error : function(response) {
                console.log('error response: ', res)
            }
        })
    }
}

window.programGroup = new ProgramGrouping();
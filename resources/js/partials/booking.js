// import {MemberRegistration} from "./member";

export class Booking {

    #memberClass;
    #bookingID;
    #loading = false;
    #lastLoading = 0;
    #disabled = false;


    constructor() {
        if ($(document).find('input[id="quickCheckIn"]').length) {

            let _this = this;
            $('input[id="quickCheckIn"]').on('keypress', function () {
                _this.quickCheckIn(this);
            })

            let scannedData = '';
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

    #postRequest(_url,body={}) {
        if (this.#disabled === true) {

            Swal.fire({
                title: 'Error',
                text: "Unauthorized Action.",
                icon : 'error'
            });
            return;

        }

        return axios.post(_url,body,{
            headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        })
    }

    #getRequest(_url,body={}) {
        return axios.get(_url,{
            headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        })
    }

    updateBookingInfo(elm,bookingID,param={}) {

        if (this.#disabled === true || this.#disabled) {

            Swal.fire({
                title: 'Error',
                text: "Unauthorized Action.",
                icon : 'error'
            });
            return;

        }


        let _this = this;
        param[$(elm).attr('name')] = ($(elm).is('select') === true) ?  $(elm).find(":selected").val() : $(elm).val();console.log(param);

        if (bookingID !== this.#bookingID) {
            param['silent'] = true;
            param['primaryInfo'] = this.#bookingID;
        } else {
            param['silent'] = false;
        }

        _this.#postRequest('/admin/dharmasala/bookings/update/'+bookingID,param)
            .then(function(response){
                let _responseData = response.data;

                if (_responseData.params.targetDIV && _responseData.params.view) {
                    $(_responseData.params.targetDIV).html(_responseData.params.view)
                }

            })
            .catch(function(error){
                Swal.fire({
                    title: 'Error',
                    text: "Failed to updated failed.",
                    icon : 'error'
                })
                console.error(error.message());
            })
    }

    bookingNavigation(elm,bookingID,params={}) {

        if (this.#disabled === true) {

            Swal.fire({
                title: 'Error',
                text: "Unauthorized Action.",
                icon : 'error'
            });
            return;

        }


        if ( this.#loading == true || this.#lastLoading == bookingID) {
            return;
        }

        this.#lastLoading = bookingID;
        this.#loading = true;

        let _url = '/admin/dharmasala/bookings/quick-navigation/'+bookingID
        let _this = this;

        _this.#getRequest(_url,params)
            .then(function(response){
                $('#confirmationNavigation').html(response.data.params.view);
                _this.#loading = false;
            }).catch((error) => {
                _this.#loading = false;
        })
    }

    quickBookingModal() {

    }

    quickShortCutBooking() {

    }

    enableCamera(elm,bookingID,params={}) {
        if (this.#disabled === true) {

            Swal.fire({
                title: 'Error',
                text: "Unauthorized Action.",
                icon : 'error'
            });
            return;

        }

        if ( ! this.#memberClass ) {
            this.#memberClass = new MemberRegistration()
        }
        this.#memberClass.enableCamera(this,params)
    }

    captureImage(elm,bookingID, params={}) {

        if (this.#disabled === true) {

            Swal.fire({
                title: 'Error',
                text: "Unauthorized Action.",
                icon : 'error'
            });
            return;

        }

        if (! this.#memberClass ){
            Swal.fire({
                title: 'Error',
                text: "Camera not initialized.",
                icon : 'error'
            })
            console.error(error.message());
            return;
        }
        this.#memberClass.captureImage(elm,params);
    }

    uploadMedia(elm,bookingID,params={}) {

        if (this.#disabled === true) {

            Swal.fire({
                title: 'Error',
                text: "Unauthorized Action.",
                icon : 'error'
            });
            return;

        }

        const file = elm.files[0];

        if ( ! file) {
            Swal.fire({
                title: 'Error',
                text: "Unable to select file.",
                icon : 'error'
            });

            return ;
        }

        const formData = new FormData();
        formData.append($(elm).attr('name'),file);

        this.#postRequest('/admin/dharmasala/bookings/update/'+bookingID,formData)
            .then((response) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $(params.preview).removeAttr('src').attr('src',e.target.result);
                }
                reader.readAsDataURL(file);
                $(response.data.params.targetDIV).html(response.data.params.view);
            })
            .catch((error) => {
                Swal.fire({
                    title: 'Error',
                    text: "Unable to upload selected File. Please check your file permission.",
                    icon : 'error'
                })
                console.error(error.message());
            })
    }

    setInitialBookingID(bookingID,params={}) {
        if ( this.#bookingID ) {
            Swal.fire({
                title: 'Error',
                text: "Not allowed to change booking information.",
                icon : 'error'
            })
            return;
        }
        this.#bookingID = bookingID;

        if (params.disabled) {
            this.setBooking(params.disabled)
        }
    }

    confirmBooking(elm,bookingID, params={}) {
        let _this = this;

        if (_this.#disabled === true) {
            Swal.fire({
                title: 'Error',
                text: "Unauthorized Action",
                icon : 'error'
            });
        }

        _this.#postRequest('/admin/dharmasala/bookings/update-booking-status/'+bookingID+'/confirmation', params)
            .then((response)=> {
            window.handleOKResponse(response.data);
        }).catch((error) => {
            window.handle422Case(error.data);
            window.handleBadResponse(error.data);
        })
    }

    enableAllBookingFields(elm,bookingID,params={}){
        let _this = this;
        Swal.fire({
            title: 'Confirm your Action !!',
            text: "This booking was already confirmed, Do you wish to update the information for this booking.",
            showConfirmButton: true,
            showCloseButton: true,
            showCancelButton: true
        }).then((action) => {
            if (action.isConfirmed === true) {
                _this.setBooking();
                $('#confirmationNavigation').find('input, select, button').removeAttr('disabled').removeClass('disabled');}
        })
    }
    setBooking(status = false) {
        this.#disabled = (status)
    }

    quickCheckIn(elm) {

        console.log("element value: ", elm);
            if ($(elm).val().length < 10)  {
            return;
        }
        let _this = this;
        let _displayDivWrapper = $('#booking-status');
        let _errorWrapper = $('#errorDisplay');

        _errorWrapper.addClass('d-none')
        _displayDivWrapper.addClass('d-none');

        _this.#postRequest('/admin/dharmasala/bookings/quick-check-in',{bookingID : $(elm).val()})
            .then(function(response) {
                let _data = response.data;


                if (! _data.state ) {
                    return;
                }

                _displayDivWrapper.removeClass('d-none')

                if (_data.params.class) {

                    _displayDivWrapper.find('div.col-md-12').removeClass('bg-succes')
                                                            .removeClass('bg-danger')
                                                            .addClass(_data.params.class)
                }
                if (_data.params.records.room_number) {

                    _displayDivWrapper.find('#RoomNumber').text('Room Number :' + _data.params.records.room_number)
                }

                if (_data.params.records.floor_name) {
                    _displayDivWrapper.find('#Floor').text(_data.params.records.building_name).removeClass('d-none')
                } else {
                    _displayDivWrapper.find('#Floor').addClass('d-none');
                }
                console.log(_data.params.records);
                if (_data.params.records.building_name) {
                    _displayDivWrapper.find('#Building').text(_data.params.records.floor_name).removeClass('d-none')
                } else {
                    _displayDivWrapper.find('#Building').addClass('d-none')
                }

                $('#quickCheckIn').val('')

            }).catch((error) => {
                console.log('error: ', error.response);
                _errorWrapper.find('div.col-md-12').text(error.response.data.msg);
                _errorWrapper.removeClass('d-none');
                $('#quickCheckIn').val('');
            });

        setTimeout(() => {
            _displayDivWrapper.addClass('d-none');
            _errorWrapper.addClass('d-none');
        }, 5000);
    }
}

@php
    $dharmasala = request()->dharmasala ? true  : false;
    $program = false;
@endphp
@extends('layouts.admin.master')
@push('page_title') Register New Member @endpush
@section('main')
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">Members/</span> Register
            </h4>

            <a href="{{route('admin.members.all')}}" class="btn btn-danger btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
    </div>
    <!-- Responsive Datatable -->
    <div class="card">
        <h5 class="card-header">Create New Member</h5>
        <form enctype="multipart/form-data" action="{{route('admin.members.create')}}" method="post" class="ajax-component-form ajax-append">
            <div class="card-body">
                <div class="row">
                <div class="@if($dharmasala == true || $program == true) col-md-8  @else col-md-12 @endif bg-light p-2">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="first_name">First name
                                    <sup class="text-danger">*</sup>
                                </label>
                                <input type="text" name="first_name" id="first_name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="middle_name">Middle name
                                </label>
                                <input type="text" name="middle_name" id="middle_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="last_name">Last name
                                    <sup class="text-danger">*</sup>
                                </label>
                                <input type="text" name="last_name" id="last_name" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="date_of_birth">
                                    Date of Birth
                                    <sup class="text-danger">*</sup>
                                </label>
                                <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone_number">
                                    Phone Number
                                    <sup class="text-danger">*</sup>
                                </label>
                                <input type="text" name="phone_number" id="phone_number" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" />
                            </div>
                        </div>
                        @if($dharmasala == true)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="register_account">Online Registration</label>
                                    <select name="online_registration" id="register_account" class="form-control">
                                        <option value="0" selected>No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                        @else
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="country">Country
                                <sup class="text-danger">*</sup>
                                </label>
                                <select name="country" id="country" class="form-control">
                                    @foreach(\App\Models\Country::get() as $country)
                                        <option value="{{$country->getKey()}}" @if($country->getKey() == 153) selected @endif>{{$country->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="city">
                                    State / Province
                                    <sup class="text-danger">*</sup>
                                </label>
                                <input type="text" name="city" id="city" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="street_address">Street Address
                                    <sup class="text-danger">*</sup>
                                </label>
                                <textarea name="street_address" id="street_address"
                                          class="form-control textarea"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                @if($dharmasala == true)
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="id_card">
                                        ID Card
                                        <sup class="text-danger">*</sup>
                                    </label>
                                    <input type="file" name="id_card" id="id_card" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="media" class="d-flex justify-content-between align-items-center">
                                        <span class="fs-5">
                                            Capture Selfie
                                            <sup class="text-danger">*</sup>
                                        </span>
                                        <span>
                                            <button id="cameraOpenButton" onclick="stopWebcam()" class="btn btn-primary btn-icon"><i class="fas fa-camera"></i></button>
                                        </span>

                                    </label>
                                    <div id="cameraArea">
                                        <video id="webcam" width="640" height="480" autoplay playsinline>
                                        </video>
                                    </div>
                                    <div id="loading-bar"></div>
                                    <input type="hidden" name="dharmasala_media" class="form-control d-none">
                                </div>
                            </div>
                            <div class="col-md-12 text-end">
                                <button class="btn btn-info" type="button" id="capture">Save Image</button>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="room_number">
                                        Room Number
                                        <sup class="text-danger">*</sup>
                                    </label>
                                    <select name="room_number" id="room_number" class="form-control">
                                        @foreach (\App\Models\Dharmasala\DharmasalaBuildingRoom::get() as $room)
                                            <option value="{{$room->getKey()}}">{{$room->room_number}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="check_in">Check In
                                        <sup class="text-danger">*</sup>
                                    </label>
                                    <input type="datetime-local" name="check_in" id="check_in" class="form-control" value="{{date('Y-m-d h:i')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-primary">
                            Create new Member
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('page_script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
    <script>
        const captureButton = document.getElementById('capture');
        const cameraOpenButton = document.getElementById('cameraOpenButton');

        function setVideoElement() {

            const _cameraOpenButton = $('#cameraOpenButton');

            if ( ! $('#webcam').length ) {
                const _camera = $('#cameraArea');
                let _videoElement = `<video id='webcam' width='600' height='600' autoplay playsinline></video>`
                _camera.html(_videoElement);
            }

            _cameraOpenButton.removeAttr('click')
                            .addClass('btn-danger')
                            .removeClass('btn-primary')
                            .html(`<i class='fas fa-stop'></i>`)
        }

        function setImageElement(src) {

            const cameraOpenButton = $('#cameraOpenButton');
            stopWebcam();
            const _camera = $('#cameraArea');

            if ( $('#webcam').length ) {
                _camera.empty();
                let _videoElement = `<img src="${src}" style="width:600px; height: 450px;" />`
                _camera.append(_videoElement);
            }

            cameraOpenButton.attr('click','stopWebcam()')
                            .removeClass('btn-danger')
                            .addClass('btn-primary')
                            .html(`<i class='fas fa-camera'></i>`)
        }

         function openDeviceCamera (){
             showLoadingBar();
             setVideoElement();
             const video = document.getElementById('webcam');
            navigator.mediaDevices.getUserMedia({ video: true })
                .then((stream) => {
                    video.srcObject = stream;
                    hideLoadingBar();
                })
                .catch((err) => {
                    console.error('Error accessing webcam:', err);
                    hideLoadingBar();
                });
        }


        function showLoadingBar() {
            const loadingBar = document.getElementById('loading-bar');
            loadingBar.style.display = 'block';
        }

        function hideLoadingBar() {
            const loadingBar = document.getElementById('loading-bar');
            loadingBar.style.display = 'none';
        }

        function updateLoadingBar(progress) {
            const loadingBar = document.getElementById('loading-bar');
            loadingBar.style.width = `${progress}%`;
        }

        captureButton.addEventListener('click', () => {
            const canvas = document.createElement('canvas');
            const video = document.getElementById('webcam');

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);

            const image = canvas.toDataURL('image/png');
            setImageElement(image);
            $('input[name="dharmasala_media"]').val(image);

            // fetch('/webcam/save', {
            //     method: 'POST',
            //     headers: {
            //         'Content-Type': 'application/json',
            //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            //     },
            //     body: JSON.stringify({ image: image }),
            // })
            //     .then(response => response.json())
            //     .then(data => {
            //         console.log(data.message);
            //         console.log('Image saved at:', data.path);
            //     })
            //     .catch(error => console.error('Error saving image:', error));
        });

        function stopWebcam() {
            const video = document.getElementById('webcam');
            // Check if the video element has an active stream
            if (video.srcObject) {
                // Get the stream tracks
                const tracks = video.srcObject.getTracks();
                // Stop each track
                tracks.forEach(track => track.stop());
                // Reset the video source
                video.srcObject = null;
            }
        }

        $(document).ready ( function(){
            openDeviceCamera();
             cameraOpenButton.addEventListener('click', () => {
                 openDeviceCamera();
             })
         })
    </script>
@endpush
@push('page_css')
    <style>
        video {
            display: block;
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
            height: auto;
        }

        canvas {
            display: block;
            margin: 10px auto;
            border: 1px solid #ccc;
            max-width: 600px;
        }

        button {
            display: block;
            margin: 10px auto;
            padding: 10px;
        }
        #loading-bar {
            display: none;
            background-color: #3490dc;
            height: 4px;
            width: 0%;
            transition: width 1s ease-in-out;
        }
    </style>
@endpush

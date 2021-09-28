@extends("layouts.clients")


@php
//        function generate_signature( $api_key, $api_secret, $meeting_number, $role){

            $api_key = "pUBhiJDjTRWhoWAenjkmLQ";
            $api_secret = "ZbQiQsEZxtAwd78PcpAX1bZH5SQp1FlVS7Ut";
            $meeting_number = 89235985677;
            $role = 0;
            //Set the timezone to UTC
            date_default_timezone_set("UTC");

            $time = time() * 1000 - 30000;//time in milliseconds (or close enough)
            
            $data = base64_encode($api_key . $meeting_number . $time . $role);
            
            $hash = hash_hmac('sha256', $data, $api_secret, true);
            
            $_sig = $api_key . "." . $meeting_number . "." . $time . "." . $role . "." . base64_encode($hash);
            $f_sig = rtrim(strtr(base64_encode($_sig), '+/', '-_'), '=');
//            }
        @endphp 
@section("page_css")
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.5/css/react-select.css" />
    <style>

        .join-audio-by-phone__steps{
            display: none;
        }
        .footer-button__participants-icon{
            background: url("data:image/svg+xml;charset=utf-8,%3Csvg width='24' height='24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M19.501 1a.75.75 0 011.5 0v2.002h2a.75.75 0 010 1.5h-2v1.997a.75.75 0 11-1.5 0V4.5h-2.003a.75.75 0 110-1.499h2.003V1.001z' fill='%23fff' fill-opacity='.62'/%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M12 3h2.2c.675 0 1.018.58 1.063.996A2.25 2.25 0 0017.5 6h.504v.498c0 1.151.864 2.1 1.979 2.234C20.397 8.782 21 9 21 9.8V12a9 9 0 11-9-9zm-2.4 9a1.2 1.2 0 100-2.4 1.2 1.2 0 000 2.4zm6-1.2a1.2 1.2 0 11-2.4 0 1.2 1.2 0 012.4 0zm-6.282 2.63a.75.75 0 10-1.304.74c.94 1.655 2.774 2.18 3.986 2.18 1.212 0 3.046-.525 3.986-2.18a.75.75 0 10-1.304-.74c-.579 1.017-1.784 1.42-2.682 1.42-.898 0-2.103-.403-2.682-1.42z' fill='%23fff' fill-opacity='.8'/%3E%3C/svg%3E") !important;
            margin: 25px;
        }
        .footer-button__button-label {
            display: none !important;
        }
        .participants-ul {
            display : none !important;
        }
        .footer-button__number-counter {
            display: none !important;
        }
        .participants-header__title {
            display: none !important;
        }
        #zmmtg-root {
            background: transparent;
            
        }
    </style>
@endsection
@section("breadcrumb")
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12 col-12">
					<nav aria-label="breadcrumb" class="page-breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
						</ol>
					</nav>
					<h2 class="breadcrumb-title">Zoom Live Session</h2>
				</div>
			</div>
		</div>
	</div>
	<!-- /Breadcrumb -->
@endsection

@section("content")
    <div class="call-wrapper">
        <div class="call-main-row">
            <div class="call-main-wrapper">
                <div class="call-view">
                    <div class="call-window">
                    
                        <!-- Call Contents -->
                        <div class="call-contents">
                            <div class="call-content-wrap">
                                <div class="user-video">
                                    <button type="button" id="join_meeting">Join Meeting</button>
                                </div>
                               
                            </div>
                        </div>
                        <!-- Call Contents -->
                        
                        
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@endsection

@section("page_js")
<!-- import ZoomMtg dependencies -->
    <script src="https://source.zoom.us/1.9.5/lib/vendor/react.min.js"></script>
    <script src="https://source.zoom.us/1.9.5/lib/vendor/react-dom.min.js"></script>
    <script src="https://source.zoom.us/1.9.5/lib/vendor/redux.min.js"></script>
    <script src="https://source.zoom.us/1.9.5/lib/vendor/redux-thunk.min.js"></script>
    <script src="https://source.zoom.us/1.9.5/lib/vendor/lodash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsrsasign/8.0.20/jsrsasign-all-min.js"></script>
    <script src="https://source.zoom.us/zoom-meeting-1.9.7.min.js"></script>
    <script src="{{ asset('zoom/js/tool.js') }}"></script>
    <script src="{{ asset('zoom/js/vconsole.min.js') }}"></script>
    <script>

        window.addEventListener('DOMContentLoaded', function(event) {
            console.log('DOM fully loaded and parsed');
            websdkready();
            start_meeting();
        });

        function websdkready() {
            var testTool = window.testTool;
            if (testTool.isMobileDevice()) {
                vConsole = new VConsole();
            }
            console.log("checkSystemRequirements");
            console.log(JSON.stringify(ZoomMtg.checkSystemRequirements()));

            // it's option if you want to change the WebSDK dependency link resources. setZoomJSLib must be run at first
            // if (!china) ZoomMtg.setZoomJSLib('https://source.zoom.us/1.9.7/lib', '/av'); // CDN version default
            // else ZoomMtg.setZoomJSLib('https://jssdk.zoomus.cn/1.9.7/lib', '/av'); // china cdn option
            // ZoomMtg.setZoomJSLib('http://localhost:9999/node_modules/@zoomus/websdk/dist/lib', '/av'); // Local version default, Angular Project change to use cdn version
            ZoomMtg.preLoadWasm(); // pre download wasm file to save time.
            const API_KEY = "{{ $api_key }}";
            const API_SECRET = "{{ $api_secret }}";


        /**
         * NEVER PUT YOUR ACTUAL API SECRET IN CLIENT SIDE CODE, THIS IS JUST FOR QUICK PROTOTYPING
         * The below generateSignature should be done server side as not to expose your api secret in public
         * You can find an eaxmple in here: https://marketplace.zoom.us/docs/sdk/native-sdks/web/essential/signature
         */
        // var API_SECRET = "YOUR_API_SECRET";

        // some help code, remember mn, pwd, lang to cookie, and autofill.
        // document.getElementById("display_name").value =
        //     "CDN" +
        //     ZoomMtg.getJSSDKVersion()[0] +
        //     testTool.detectOS() +
        //     "#" +
        //     testTool.getBrowserInfo();
        // document.getElementById("meeting_number").value = testTool.getCookie(
        //     "meeting_number"
        // );
        // document.getElementById("meeting_pwd").value = testTool.getCookie(
        //     "meeting_pwd"
        // );
        if (testTool.getCookie("meeting_lang"))
            // document.getElementById("meeting_lang").value = testTool.getCookie(
            // "meeting_lang"
            // );
            testTool.setCookie(
                "meeting_lang",
                "en-US"
            );
            testTool.setCookie(
                "_zm_lang",
                'en-US'
            );

        // copy zoom invite link to mn, autofill mn and pwd.
        testTool.setCookie(
                "meeting_number",
                "89235985677"
            );
        testTool.setCookie("meeting_pwd", "418916");


        

        // click join meeting button
     
        .getElementById("join_meeting")
            .addEventListener("click", function (e) {
                    e.preventDefault();
                    var meetingConfig = testTool.getMeetingConfig();
                    if (!meetingConfig.mn || !meetingConfig.name) {
                        alert("Meeting number or username is empty");
                        return false;
                    }
        
                    
                    // testTool.setCookie("meeting_number", meetingConfig.mn);
                    // testTool.setCookie("meeting_pwd", meetingConfig.pwd);
        
                    var signature = ZoomMtg.generateSignature({
                        meetingNumber: 84583289078,
                        apiKey: API_KEY,
                        apiSecret: API_SECRET,
                        role: meetingConfig.role,
                        success: function (res) {
                        console.log(res.result);
                        meetingConfig.signature = res.result;
                        meetingConfig.apiKey = API_KEY;
                        var joinUrl = "{{ route('public.room.zoom-buffer') }}?" + testTool.serialize(meetingConfig);
                        console.log(joinUrl);
                        window.open(joinUrl, "_self");
                        }
                    });
            });


        function copyToClipboard(elementId) {
            var aux = document.createElement("input");
            aux.setAttribute("value", document.getElementById(elementId).getAttribute('link'));
            document.body.appendChild(aux);  
            aux.select();
            document.execCommand("copy");
            document.body.removeChild(aux);
        }
            
        // click copy jon link button
        window.copyJoinLink = function (element) {
            var meetingConfig = testTool.getMeetingConfig();
            if (!meetingConfig.mn || !meetingConfig.name) {
            alert("Meeting number or username is empty");
            return false;
            }
            var signature = ZoomMtg.generateSignature({
            meetingNumber: meetingConfig.mn,
            apiKey: API_KEY,
            apiSecret: API_SECRET,
            role: meetingConfig.role,
            success: function (res) {
                console.log(res.result);
                meetingConfig.signature = res.result;
                meetingConfig.apiKey = API_KEY;
                var joinUrl =
                testTool.getCurrentDomain() +
                "{{ route('public.room.zoom-buffer') }}?" +
                testTool.serialize(meetingConfig);
                document.getElementById('copy_link_value').setAttribute('link', joinUrl);
                copyToClipboard('copy_link_value');
                
            },
            });
        };

        }

</script>

@endsection
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title></title>
    <!-- import #zmmtg-root css -->
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.7/css/bootstrap.css"/>
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.7/css/react-select.css"/>
</head>
<body>
<!-- added on import -->
<div id="zmmtg-root"></div>
<div id="aria-notify-area"></div>
<div id="crsf">{{ csrf_token() }}</div>

<!-- added on meeting init -->
<div class="ReactModalPortal"></div>
<div class="ReactModalPortal"></div>
<div class="ReactModalPortal"></div>
<div class="ReactModalPortal"></div>
<div class="global-pop-up-box"></div>
<div class="sharer-controlbar-container sharer-controlbar-container--hidden"></div>

<!-- import ZoomMtg dependencies -->
<script src="https://source.zoom.us/1.9.7/lib/vendor/react.min.js"></script>
<script src="https://source.zoom.us/1.9.7/lib/vendor/react-dom.min.js"></script>
<script src="https://source.zoom.us/1.9.7/lib/vendor/redux.min.js"></script>
<script src="https://source.zoom.us/1.9.7/lib/vendor/redux-thunk.min.js"></script>
<script src="https://source.zoom.us/1.9.7/lib/vendor/lodash.min.js"></script>
<!-- import ZoomMtg -->
<script src="https://source.zoom.us/zoom-meeting-1.9.7.min.js"></script>
<script>
    ZoomMtg.preLoadWasm();
    ZoomMtg.prepareJssdk();

    const zoomMeeting = document.getElementById("zmmtg-root");

    const meetConfig = {
        apiKey: 'yPtOa1p8ReKrqbD2dLmiCQ',
        meetingNumber: '4869024146',
        leaveUrl: 'https://yoursite.com/meetingEnd',
        userName: 'linh dinh',
        userEmail: 'linhdv@navigo-tech.com',
        passWord: '123123', // if required
        role: 0 // 1 for host; 0 for attendee
    };


    function getSignature(meetConfig) {
        // make a request for a signature
        fetch(`/generate_signature`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.getElementById('crsf').innerHTML
            },
            body: JSON.stringify({ api_key: meetConfig.apiKey, meeting_number: meetConfig.meetingNumber, role: meetConfig.role

            })
        })
            .then(result => result.text())
            .then(response => {
                ZoomMtg.init({
                    leaveUrl: meetConfig.leaveUrl,
                    isSupportAV: true,
                    success: function() {
                        ZoomMtg.join({
                            signature: response,
                            apiKey: meetConfig.apiKey,
                            meetingNumber: meetConfig.meetingNumber,
                            userName: meetConfig.userName,
                            // password optional; set by Host
                            passWord: meetConfig.passWord,
                            error(res) {
                                console.log(res)
                            }
                        })
                    }
                })
            })
    }
    getSignature(meetConfig);

</script>
</body>
</html>

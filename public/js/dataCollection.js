
function getposition() {
    if (navigator && navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (pos) {
                place_data['latitude'] = pos.coords.latitude;
                place_data['longitude'] = pos.coords.longitude;
                allowedLocation = true;
            },
            function (error) {
                if (error.code == error.PERMISSION_DENIED) {
                    allowedLocation = false;
                    alert("you need to allow your location in order to contiue");
                }
            }
        );
    }
}

function submitDetailData(place_data) {

    place_data['update'] = place_data.tab;

    const formData = new FormData();
    if (fileInput_place) {
        formData.append('place_image', fileInput_place);
    }
    if (fileInput_observation) {
        formData.append('observation_image', fileInput_observation);
    }

    formData.append('place_data', JSON.stringify(place_data));

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $.ajax({
        type: 'POST',
        url: "/map/add/place",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.status == 'success') {
                place_data['place_name'] = '';
                place_data['observation_name'] = '';
                place_data['place_id'] = data.place_id;
            } else {
                swal({
                    title: "Failed!",
                    text: data.msg,
                    icon: "error"
                });
            }
        }
    });
}
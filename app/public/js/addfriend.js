function search() {
    var txt = $('#search_text').val();
    console.log(txt);
    document.getElementById('content').innerHTML = '';
    //if(txt != '')
    //{
    $.ajax({
        url: '/addfriend',
        method: 'POST',
        dataType: 'json',
        data: {
            action: 'search',
            text: txt
        },
        success: function (data) {
            //console.log(data);
            $.each(data.result, function (index, data) {
                $('#content').append('<div class="col-md-3">' +
                    '<h4 class="card-header">' + data.username + '</h4>' +
                    '<h5> Name:' + data.firstName + '&nbsp&nbsp' + data.lastName + ' </h5>' +
                    '<button  class="btn btn-primary" onclick="add(\'' + data.username + '\')">add friend</button>' +
                    '</div>');
            });

        }
    });
    //}
}

function add(user) {

    $.ajax({
        url:'/addfriend',
        method: 'POST',
        data: {
            action:'add',
            user: user},
        success: function (data) {
            //console.log(data)
            alert(data);
            search();

        }
    });
    //console.log(user);
}

function friendReq(){
    $(".friendReq").slideToggle();

    $.ajax({
        url:'/index',
        method: 'POST',
        dataType: 'json',
        data: {
            action:'list',
        },
        success: function (data) {
            //console.log(data);
            html1='';
            if (!Object.keys(data).length){html1+='<strong>No!</strong> friend request'}
            else {
                $.each(data, function (index, data) {
                    html1 += '<div class="row">';
                    html1 += '<span class="col-md-4 red">' + data.sendFriend + '</span>';
                    html1 += '<button  class="btn btn-primary" onclick="acceptReq(\'' + data.sendFriend + '\')">accept friend</button>';
                    html1 += '<div class="divider"/>';
                    html1 += '<button  class="btn btn-primary " onclick="deleteReq(\'' + data.sendFriend + '\')">delete request</button>';
                    html1 += '</div>';
                    html1 += '<hr>';
                });
            }
            $('.friendReq').html(html1);
            removeUnseen();
            unseenF();
            getF();

        }
    });
}
function sentReq(){
    $(".sentReq").slideToggle();

    $.ajax({
        url:'/index',
        method: 'POST',
        dataType: 'json',
        data: {
            action:'listSent',
        },
        success: function (data) {
            //console.log(data);
            html='';
            if (!Object.keys(data).length){html+='<strong>No!</strong> sent request'}
            else{
                $.each(data, function(index, data) {
                    html+='<div class="row">';
                    html+='<span class="col-md-4 red">'+data.acceptFriend+'</span>';
                    html+='<button  class="btn btn-primary" onclick="cancelReq(\'' + data.acceptFriend + '\')">cancel Request</button>';
                    html+='</div>';
                    html+='<hr>';
                });}
            $('.sentReq').html(html);


        }
    });
}
function cancelReq(friend) {

    $.ajax({
        url:'/index',
        method: 'POST',
        data: {
            action:'cancelReq',
            friend: friend},
        success: function (data) {
            //console.log(data)
            alert(data);
            sentReq();
        }
    });
}
function deleteReq(friend) {

    $.ajax({
        url:'/index',
        method: 'POST',
        data: {
            action:'deleteReq',
            friend: friend},
        success: function (data) {
            //console.log(data)
            alert(data);
            friendReq();
        }
    });
}

function acceptReq(friend) {

    $.ajax({
        url:'/index',
        method: 'POST',
        data: {
            action:'acceptReq',
            friend: friend},
        success: function (data) {
            //console.log(data)
            alert(data);
            friendReq();
            $("#result").load(location.href + " #result");
        }
    });
}

function deluser(friend)
{
    if (confirm("Are you sure you want to delete this"))
    {
        $.ajax({
            url:'/index',
            method: 'POST',
            data: {
                action:'deleteFriend',
                friend: friend},
            success: function (data) {
                //console.log(data)
                alert(data);
                //$("#result").load(location.href + " #result");
                getF();
                clearChat(friend);
            }
        });

    }
}
function getF() {
    var txt = $('#search_text').val();
    // console.log(txt);
    if(!txt)
    {
        $.ajax({
            url: '/index',
            method: 'POST',
            dataType: 'json',
            data: {
                action: 'getFriends'
            },
            success: function (data) {
                //console.log(data);
                html2='<tr><th>Username</th><th>Name</th><th>Action</th></tr>';
                $.each(data, function(index, data) {
                    html2+='<tr>';
                    html2+='<td><a href="javascript:openChat(\'' + data.username + '\')">'+data.username+ '</a><span class="countChat" data-user="'+data.username+'"></span></td>';
                    html2+='<td>'+data.firstName+ '&nbsp'+ data.lastName+ '</td>';
                    html2+='<td>';
                    html2+='<a href="javascript:openChat(\'' + data.username + '\')">chat</a> |';
                    html2+='<a href="javascript:deluser(\''+data.username+'\')">Delete</a>';
                    html2+='</td>';
                    html2+='</tr>';
                });
                $('#result').html(html2);


            }
        });
    }
    else
    {
        $.ajax({
            url: '/index',
            method: 'POST',
            dataType: 'json',
            data: {
                action: 'searchFriends',
                search: txt
            },
            success: function (data) {
                //console.log(data);
                html2='<tr><th>Username</th><th>Name</th><th>Action</th></tr>';
                $.each(data, function(index, data) {
                    html2+='<tr>';
                    html2+='<td><a href="javascript:openChat(\'' + data.username + '\')">'+data.username+'</a><span class="countChat" data-user="'+data.username+'"></span></td>';
                    html2+='<td>'+data.firstName+ '&nbsp'+ data.lastName+ '</td>';
                    html2+='<td>';
                    html2+='<a href="javascript:openChat(\'' + data.username + '\')">chat</a> |';
                    html2+='<a href="javascript:deluser(\''+data.username+'\')">Delete</a>';
                    html2+='</td>';
                    html2+='</tr>';
                });
                $('#result').html(html2);


            }
        });

    }
}
//get the unseen friend request
function unseenF()
{
    $.ajax({
        url:'/index',
        method: 'POST',
        data: {
            action:'unseenF'
        },
        success: function (data) {
            // console.log(data);
            if (data === '0'){$('#count').text('').attr("class","")}
            else{$('#count').text(data).attr("class","count")}
            //alert(data);

        }
    });
}

function removeUnseen()
{
    $.ajax({
        url:'/index',
        method: 'POST',
        data: {
            action:'removeUnseen'
        },
        success: function (data) {
            //console.log(data);
            //$('#count').text(data);
            //alert(data);

        }
    });
}
function makeChatDialog(userName)
{
    var modalContent ='<div id="user_dialog_'+userName+'" title="chat with '+userName+'">';
    modalContent +='<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding: 16px;" id="chat_history_'+userName+'"  data-friend="'+userName+'">';
    modalContent +='</div>';
    modalContent +='<div class="form-group">';
    modalContent +='<textarea id="chat_message_'+userName+'" class="form-control"></textarea>';
    modalContent +='</div><div class="form-group" align="right">';
    modalContent +='<button type="button" name="sendChat" class="btn btn-info" onclick="sendChatMessage(\'' + userName + '\')">send</button></div>' ;
    modalContent +='<div class="form-group" align="left"><button type="button" name="clearChat" class="btn btn-danger" onclick="clearChat(\'' + userName + '\')">clear chat</button></div></div>';
    $('#userChat').html(modalContent);
    //to chat in real time
    $('#chat_history_' + userName).addClass('chatHistory');

}
var timer;
function openChat(userName)
{
    makeChatDialog(userName);
    $('#user_dialog_'+userName).dialog({
        autoOpen:false,
        width:400
    });
    $('#user_dialog_'+userName).dialog('open');
    $('#user_dialog_'+userName).on('dialogclose', function(event) {
        $('#chat_history_' + userName).removeClass("chatHistory");
    });
    getChatHistory(userName);

}

function sendChatMessage(userName)
{
    chatMessage =$('#chat_message_'+userName).val();
    //console.log(chatMessage);
    $.ajax({
        url:'/index',
        method:'POST',
        data:{
            acceptor:userName,
            message: chatMessage,
            action: 'sendChatMessage'
        },
        success:function (data) {
            $('#chat_message_'+userName).val('');
            getChatHistory(userName);
        }
    })
}

//hold count of messages if it changes then go to the under to see the new message
var messCount;
function getChatHistory(userName)
{

    $.ajax({
        url:'/index',
        method: 'POST',
        dataType: 'json',
        data: {
            friend: userName,
            action:'getChatHistory'
        },
        success: function (data) {
            //console.log(Object.keys(data).length);
            messages='';
            $.each(data, function (index, data) {
                if (data.sender == userName) {
                    user = '<b class="text-danger">' + data.sender + '</b>';
                }
                else {
                    user = '<b class="text-success">you</b>';
                }
                messages += '<div class="msg" style="border-bottom:1px dotted #ccc"><p>' + user + '-' + data.text + '<div align="right">-<small><em>' + data.time + '</em></small></div></p></div>';

            });
            $('#chat_history_' + userName).html(messages);
            if(messCount === Object.keys(data).length){

            }
            else{
                var element = document.getElementById('chat_history_' + userName);
                element.scrollTop = element.scrollHeight;
            }
            messCount = Object.keys(data).length;
            //alert(data);
            clearCountChat(userName);


        }
    });
    //setTimeout(getChatHistory(userName), 2*1000);

}
function clearChat(userName){
    if (confirm("Are you sure you want to clear chat with "+userName)) {
        $.ajax({
            url: '/index',
            method: 'POST',
            data: {
                action: 'clearChat',
                friend: userName
            },
            success: function (data) {
                //console.log(data);
                //$('#count').text(data);
                //alert(data);
                getChatHistory(userName);

            }
        });
    }
}
//chat in real time
function updateChat(){
    $('.chatHistory').each(function () {
        var userName= $(this).data('friend');
        getChatHistory(userName)
    });

}

function countChatSeen(){
    $('.countChat').each(function () {

        var friend= $(this).data('user');
        element=$(this);
        $.ajax({
            url:'/index',
            method: 'POST',
            data: {
                action:'countChatSeen',
                friend: friend
            },
            success: function (data) {
                //console.log(data);
                element.html(data);
                //$('#count').text(data);
                //alert(data);

            }
        });
    });

}
function clearCountChat(userName)
{
    $.ajax({
        url:'/index',
        method: 'POST',
        data: {
            action:'clearCountChat',
            friend: userName
        },
        success: function (data) {
            //console.log(data);
            //$('#count').text(data);
            //alert(data);

        }
    });
}
$(document).ready(function() {
    getF();
    setInterval(function () {
        getF();
    }, 3000);
    setInterval(function () {
        unseenF();
        updateChat();
    }, 2000);
    setInterval(function () {
        countChatSeen();
    }, 3000)
});
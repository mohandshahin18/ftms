// get all chats in dropdown once the page reloade
$(document).ready(function() {
    $.ajax({
        type: "get",
        url: urlOnLoad,
        data: {slug: slug},
        success:function(response) {
          $("#messages-wrapper").empty();
          $("#messages-wrapper").append(response.output);
          if(response.number == 0) {
            $("#messages-num").empty();
          } else {
            $("#messages-num").empty();
            $("#messages-num").html(response.number);
          }
        }
      });

})

const getAllChats = function() {
    $.ajax({
        type: "get",
        url: urlOnLoad,
        data: {slug: slug},
        success:function(response) {
          $("#messages-wrapper").empty();
          $("#messages-wrapper").append(response.output);
          if(response.number == 0) {
            $("#messages-wrapper #messages-num").empty();
          } else {
            $("#messages-wrapper #messages-num").empty();
            $("#messages-wrapper #messages-num").html(response.number);
          }
          console.log($("#messages-num"));
        }
      });
}

// pusher code

        

        var pusher = new Pusher(pusherKey, {
            cluster: 'ap2',
            authEndpoint: '/broadcasting/auth',
        });

        var channel = pusher.subscribe(`private-Messages.${userId}`);
        channel.bind('new-message', function(data) {
            if(data.message.receiver_type == user) {
                appendMessage(data.message.message, data.message.id);
                getAllChats();
            }
        });

$(function () {

    $(document).on('click', '.chat-circle', function (event) {
        event.preventDefault();
        let userSlug = $(this).data('slug');
        let name = $(this).data('name');
        let chatWrapper = $(".chat-logs");

        $(".chat-box").show();
        $(".box").css('height', 'unset');
        $(".chat-input").show();
        $(".chat-box-max").remove();
        $(".chat-box-min").remove();
        $('.icons-chat').append('<span class="chat-box-min" style="line-height: 0"><i class="fas fa-minus"></i></span>');
        $("#slug_input").val(userSlug);
        readAt(userSlug);
        $(this).removeClass('active');
        $("#messages-num").empty();
        
        $.ajax({
            type: "get",
            url:studentMessagesUrl,
            data: {slug: userSlug},
            beforeSend: function() {
                chatWrapper.empty();
                $("#user_name_msg").empty();
                chatWrapper.append('<div class="spinner-div d-flex align-items-center justify-content-center" style="width: 100%; position: absolute; width: 100%;height: 100%;z-index: top: 0; right: 0;"><i class="fa fa-spin fa-spinner" style="margin-right: 5px;"></i>Loading...</div>');
            },
            success:function(response) {
                if(response == '') {
                    $("#user_name_msg").empty();
                    $("#user_name_msg").append(name);
                    chatWrapper.empty();
                } else {
                    setTimeout(() => {
                        $("#user_name_msg").empty();
                        $("#user_name_msg").append(name);
                        chatWrapper.empty();
                        chatWrapper.append(response);
                        scrollToBottom();
                    }, 1000);
                }
            }
        });
    });

    // hide chat box when clicking on close button
    $(".chat-box-toggle").click(function () {
        $(".chat-box").hide();
    })
    // Minimize chat box
    $(".icons-chat").on("click", ".chat-box-min", function () {
        $(".box").css('height', '0');
        $(".chat-input").hide();
        $(this).hide();
        $(this).parent().append('<span class="chat-box-max" style="line-height: 0"><i class="fas fa-chevron-up"></i></span>')


    })

    // Maximize chat box
    $(".icons-chat").on("click", ".chat-box-max", function () {
        $(".box").css('height', 'unset');
        $(".chat-input").show();
        $(this).hide();
        $(this).parent().append('<span class="chat-box-min" style="line-height: 0"><i class="fas fa-minus"></i></span>');

    })

})
$(".chat-box-toggle").click(function () {
    $(".chat-box").hide();
})


// send message
let sendMsgForm = $("#messages_send_form");
let sendMsgBtn = $("#chat-submit");

sendMsgForm.on("submit", function(event) {
    event.preventDefault();
})

sendMsgBtn.on("click", function() {
    let sendMsgUrl = sendMsgForm.attr("action");

    $.ajax({
        type: "post",
        url: sendMsgUrl,
        data: sendMsgForm.serialize(),
        success:function(response) {
            $("#chat-input").val('');
            $(".chat-logs").append(response);
            scrollToBottom();
            getAllChats();
        }
    })
})

// append new message
const appendMessage = function(message, id) {
    msg = `<div class="chat incoming message" data-id="${id}">
                <div class="details">
                    <p>${message}</p>
                </div>
            </div>`;
    $('.chat-logs').append(msg);
    scrollToBottom();
}

// message read at
const readAt = function(userSlug) {
    $.ajax({
        type: "get",
        url: readAtUrl,
        data: {slug: userSlug},
        success:function(response) {

        },
    });
} 

// scroll to bottom function
function scrollToBottom() {
    $('.chat-logs').scrollTop($('.chat-logs').prop("scrollHeight"));
}
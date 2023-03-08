var send_form = $(".typing_area");
var send_btn = $(".message_btn");
var get_messages_form = $(".get_message");
var chatBox = $(".chat_box");

send_form.on("submit", function(e) {
    e.preventDefault();
})

const addMessage = function(msg) {
    let created = new Date();
    const options = { hour: 'numeric', minute: 'numeric', hour12: true };
    const time = created.toLocaleTimeString([], options);
    $(".chat_box").append(`<div class="chat outgoing message">
                            <div class="details">
                                <p>${msg}</p>
                                <span class="time">${time}</span>
                            </div>
                            </div>`);
}

const appendMessage = function(msg, image) {
    let created = new Date();
    const options = { hour: 'numeric', minute: 'numeric', hour12: true };
    const time = created.toLocaleTimeString([], options);
    let message = `<div class="chat incoming message" data-id="">
                    <img src="http://127.0.0.1:8000/${image}" alt="">
                    <div class="details">
                        <p>${msg}</p>
                        <span class="time">${time}</span>
                    </div>
                </div>`;
                $(".chat_box").append(message);
}

chatBox.html('<div class="d-flex align-items-center justify-content-center" style="height: 100%;"><i class="fa fa-spin fa-spinner"></i></div>');

// send message
send_btn.on("click", function() {
    if (!$(".input-field").val() == "") {
        url = send_form.attr("action");
        $.ajax({
            type: "post",
            url: url,
            data: send_form.serialize(),
            success: function(response) {
                let value = $(".input-field").val();
                appendChat();
                addMessage(value);
                scrollToBottom();

            }
        });
    }
});

// get messages and chats the first moment you open the page
$(document).ready(function() {
    $.ajax({
        type: "post",
        url: 'get/messages',
        data: send_form.serialize(),
        success: function(response) {
            chatBox.empty();
            chatBox.append(response);
            scrollToBottom();
        }
    });

    $.ajax({
        type: "get",
        url: "get/chats",
        beforeSend: function() {
            $(".chat-boxes").append(
                '<div class="d-flex align-items-center justify-content-center" style="height: 100%;"><i class="fa fa-spin fa-spinner"></i></div>'
                );
        },
        success: function(response) {
            $(".chat-boxes").empty();
            $(".chat-boxes").prepend(response);
        }
    })
});

const appendChat = function() {
    $.ajax({
        type: "get",
        url: "get/chats",
        success: function(response) {
            $(".chat-boxes").empty();
            $(".chat-boxes").append(response);
            $(".input-field").val("");
        }
    })
}

// append chat to chat area
$(".chat-list .chat-boxes").on("click", ".chat-box", function(e) {
    e.preventDefault();
    const slug = $(this).data('slug');
    $(this).addClass('active');
    $(this).siblings().removeClass('active');
    $.ajax({
        type: "get",
        url: "get/user/messages/"+slug,
        data: {
            slug: slug
        },
        success: function(response) {
            chatBox.empty();
            $(".chat-area img").attr('src', response.image);
            $("#student_name").empty();
            $("#student_name").append(response.user.name);
            $(".typing_area #receiver_id").val("");
            $(".typing_area #receiver_id").val(response.user.slug);
            window.history.pushState("localhost/admin/", "messages", response.user.slug);
            $.each(response.messages, function(key, value) {
                var created = new Date(Date.parse(value.created_at));
                const options = { hour: 'numeric', minute: 'numeric', hour12: true };
                const time = created.toLocaleTimeString([], options);

                if (value.sender_id == response.auth.id) {
                    let msg = `<div class="chat outgoing message" data-id="${value.id}">
                            <div class="details">
                                <p>${value.message}</p>
                                <span class="time">${time}</span>
                            </div>
                        </div>`;
                        chatBox.prepend(msg);
                } else {
                    let msg = `<div class="chat incoming message" data-id="${value.id}">
                            <img src="${response.image}" alt="">
                            <div class="details">
                                <p>${value.message}</p>
                                <span class="time">${time}</span>
                            </div>
                        </div>`;
                        chatBox.prepend(msg);
                }
            });
            scrollToBottom();

        }
    });
});

// messages mark as read
const readAt = function(msg) {
    $.ajax({
        type: "get",
        url: 'read/message',
        data: {msg: msg},
        success:function(response) {

        }
    });
}

function scrollToBottom() {
    chatBox.scrollTop(chatBox.prop("scrollHeight"));
}

// overlay
$(window).scroll(function() {
    var scroll = $(window).scrollTop();
    var chatBox = $('.chat_box');

    if (scroll > 0) {
        if (!chatBox.find('.overlay').length) {
            chatBox.append('<div class="overlay"></div>');
        }
    } else {
        chatBox.find('.overlay').remove();
    }
});

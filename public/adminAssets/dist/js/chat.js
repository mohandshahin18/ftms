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

chatBox.html(
    '<div class="d-flex align-items-center justify-content-center" style="height: 100%;"><i class="fa fa-spin fa-spinner"></i></div>'
    );


send_btn.on("click", function() {
    if (!$(".input-field").val() == "") {
        url = send_form.attr("action");
        $.ajax({
            type: "post",
            url: url,
            data: send_form.serialize(),
            success: function(response) {
                let value = $(".input-field").val();
                addMessage(value);
                $(".input-field").val("");
                scrollToBottom();

            }
        });
    }
});


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
            $(".chat-boxes").append(response);
        }
    })
});

// append chat to chat area

$(".chat-list .chat-boxes").on("click", ".chat-box", function(e) {
    e.preventDefault();
    const slug = $(this).data('slug');
    $.ajax({
        type: "get",
        url: 'get/user/messages',
        data: {
            slug: slug
        },
        beforeSend: function() {
            chatBox.css('position', 'relative');
            chatBox.append(
                '<div class="d-flex align-items-center justify-content-center" style="height: 100%; width: 100%; position: absolute; z-index: 999; background: #f7f7f7; top: 0;"><i class="fa fa-spin fa-spinner"></i></div>'
                )
        },

        success: function(response) {
            chatBox.empty();
            $(".chat-area img").attr('src', response.image);
            $("#student_name").empty();
            $("#student_name").append(response.student.name);
            // $(".chat_box").empty();
            window.history.pushState("localhost/admin/", "messages", response.student.slug);
            $.each(response.messages, function(key, value) {
                var created = new Date(Date.parse(value.created_at));
                const options = { hour: 'numeric', minute: 'numeric', hour12: true };
                const time = created.toLocaleTimeString([], options); 

                if (value.sender_id == response.user.id) {
                    let msg = `<div class="chat outgoing message" data-id="${value.id}">
                            <div class="details">
                                <p>${value.message}</p>
                                <span class="time">${time}</span>
                            </div>
                        </div>`;
                    $(".chat_box").prepend(msg);
                } else {
                    let msg = `<div class="chat incoming message" data-id="${value.id}"> 
                            <img src="${response.image}" alt="">
                            <div class="details">
                                <p>${value.message}</p>
                                <span class="time">${time}</span>
                            </div>
                        </div>`;
                    $(".chat_box").prepend(msg);
                }
            });
            scrollToBottom();
        }
    });
});

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

    // Restore chat box state from local storage
    $(window).on('beforeunload', function() {
        localStorage.setItem('chatBoxState', $('.chat-box').css('display'));
        localStorage.setItem('chatBoxMinimized', $(".chat-input").is(":hidden"));
    });

    $(document).ready(function() {
        var chatBoxState = localStorage.getItem('chatBoxState');
        if (chatBoxState == 'block') {
            $('.chat-box').show();
            var chatBoxMinimized = localStorage.getItem('chatBoxMinimized');
            if (chatBoxMinimized == 'true') {
                $(".box").css('height','0');
                $(".chat-input").hide();
                $(".chat-box-max").remove();
                $(".chat-box-min").remove();
                $('.icons-chat').append('<span class="chat-box-max" style="line-height: 0"><i class="fas fas fa-expand"></i></span>');
            } else {
                $(".box").css('height','unset');
                $(".chat-input").show();
                $(".chat-box-max").remove();
                $(".chat-box-min").remove();
                $('.icons-chat').append('<span class="chat-box-min" style="line-height: 0"><i class="fas fa-minus"></i></span>');
            }

        } else if (chatBoxState == 'none') {
            $('.chat-box').hide();
        } else {
            // chatBoxState is null or invalid, do nothing
        }

            // Retrieve messages from local storage
            var chatBoxSlug = localStorage.getItem('chatSlug');
            var chatType = localStorage.getItem('chatType');
            var chatName = localStorage.getItem('chatName');

            $("#slug_input").val(chatBoxSlug);
            $("#type_input").val(chatType);
            $("#user_name_msg").empty();
            $("#user_name_msg").append(chatName);

            var storedMessages = localStorage.getItem('chatBoxMessages-' + chatBoxSlug);
            if (storedMessages) {
                $('.chat-logs').empty();
                $('.chat-logs').append(storedMessages);
                scrollToBottom();
            }

            const getAllChats = function() {
                $.ajax({
                    type: "get",
                    url: allChatsUrl,
                    success:function(response) {
                        $("#messages-wrapper").empty();
                        $("#messages-wrapper").append(response.output);
                        $(".notify-number").empty();
                        $(".notify-number").append(response.number);
                    }
                });
            }

            getAllChats();
    });


    // show chat box when clicking on chat circle button
    $(function() {

        $("#messages-wrapper").on("click", ".chat-circle", function(event) {
            event.preventDefault();
            var slug = $(this).data('slug');
            var type = $(this).data('type');
            var name = $(this).data('name');
            var msgId = $(this).data('id');

            // Store slug and type in local storage
            localStorage.setItem('chatSlug', slug);
            localStorage.setItem('chatType', type);
            localStorage.setItem('chatName', name);

            $(".chat-box").show();
            $("#user_name_msg").empty();
            $("#user_name_msg").append(name);
            $(".box").css('height','unset');
            $(".chat-input").show();
            $(".chat-box-max").remove();
            $(".chat-box-min").remove();
            $('.icons-chat').append('<span class="chat-box-min" style="line-height: 0"><i class="fas fa-minus"></i></span>');
            $("#slug_input").val(slug);
            $("#type_input").val(type);



            $.ajax({
                type: "get",
                url: messagesURL,
                data: {
                    slug: slug,
                    type: type,
                },
                beforeSend: function() {
                    $('.chat-logs').empty();
                    $('.chat-logs').append('<div class="spinner-div d-flex align-items-center justify-content-center" style="width: 100%; position: absolute; width: 100%;height: 100%;z-index: top: 0; right: 0;"><i class="fa fa-spin fa-spinner" style="margin-right: 5px;"></i>Loading...</div>');
                },
                success:function(response) {
                    if(response == ''){
                        setTimeout(function() {
                            $('.chat-logs').empty();
                            $('.chat-logs').append(`<img src="${host}/adminAssets/dist/img/no-message-found.png" class="no-messages-img" alt="">`);
                        }, 1000);
                    } else {
                        setTimeout(function() {
                            $('.chat-logs').empty();
                            $('.chat-logs').append(response);
                            scrollToBottom();
                            readAt(msgId);

                            // Store messages in local storage
                            var chatBoxSlug = slug;
                            localStorage.setItem('chatBoxMessages-' + chatBoxSlug, response);
                        }, 1000);
                    }
                }
            });

        })


    })

    // hide chat box when clicking on close button
    $(".chat-box-toggle").click(function() {
        $(".chat-box").hide();
    })
    // Minimize chat box
    $(".icons-chat").on("click",".chat-box-min",function() {
        $(".box").css('height','0');
        $(".chat-input").hide();
        $(this).hide();
        $(this).parent().append('<span class="chat-box-max" style="line-height: 0"><i class="fas fas fa-expand"></i></span>')

        // Store chat box minimized state in local storage
        localStorage.setItem('chatBoxMinimized', false);
    })

    // Maximize chat box
    $(".icons-chat").on("click", ".chat-box-max",function() {
        $(".box").css('height','unset');
        $(".chat-input").show();
        $(this).hide();
        $(this).parent().append('<span class="chat-box-min" style="line-height: 0"><i class="fas fa-minus"></i></span>');

        // Store chat box minimized state in local storage
        localStorage.setItem('chatBoxMinimized', true);
    })

    // send message AJAX
    const sendBtn = $("#chat-submit");
    const form = $("#messages_send_form");

    form.on("submit", function(event) {
        event.preventDefault();
    });

    sendBtn.on("click", function() {
        const url = form.attr("action");
        var empty = $('.chat-logs').find('img');
        var slug = form.find("#slug_input").val();
        $.ajax({
            type: "post",
            url: url,
            data: form.serialize(),
            success:function(response) {
                if(empty) {
                    $('.chat-logs').empty();
                }

                var storedMessages = localStorage.getItem('chatBoxMessages-' + slug);
                if (storedMessages) {
                    $('.chat-logs').empty();
                    $('.chat-logs').append(storedMessages);

                    // get sent message
                    var sentMessage = localStorage.getItem('response')
                    $('.chat-logs').append(sentMessage);

                    scrollToBottom();
                }
                // store response of sent message (message) in local storage
                localStorage.setItem('response', response);

                $("#chat-input").val('');
                $('.chat-logs').append(response);
                scrollToBottom();
            }
        });
    });


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

    // scroll to bottom function
    function scrollToBottom() {
        $('.chat-logs').scrollTop($('.chat-logs').prop("scrollHeight"));
    }

    // message read at
    const readAt = function(id) {
        $.ajax({
            type: "get",
            url: readAtUrl,
            data: {id: id},
            success:function(response) {

            }
        })
    }

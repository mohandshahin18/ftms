
const getAllChats = function() {
    $.ajax({
        type: "get",
        url: allChatsUrl,
        success:function(response) {
            $("#messages-wrapper").empty();
            $("#messages-wrapper").append(response.output);
            if(response.number == 0) {
                $(".messages-notify").css('display', 'none');
            } else {
                $(".messages-notify").empty();
                $(".messages-notify").append(response.number);
                $(".messages-notify").css('display', 'block');
            }
        }
    });
} 
    $(document).ready(function() {
                $.ajax({
                    type: "get",
                    url: allChatsUrl,
                    success:function(response) {
                        $("#messages-wrapper").empty();
                        $("#messages-wrapper").append(response.output);
                        if(response.number > 0) {
                            $(".messages-notify").empty();
                            $(".messages-notify").css('display', 'block');
                            $(".messages-notify").append(response.number);
                        }
                    }
                });
         

            
    });
    
           
    // show chat box when clicking on chat circle button
    $(function() {

        $("#messages-wrapper").on("click", ".chat-circle", function(event) {
            event.preventDefault();
            var slug = $(this).data('slug');
            var type = $(this).data('type');
            var name = $(this).data('name');
            var msgId = $(this).data('id');

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
                            readAt(msgId, type);
                            getAllChats();
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
        // $(this).parent().parent().addClass('test');

 
    })
        
    // Maximize chat box
    $(".icons-chat").on("click", ".chat-box-max",function() {
        $(".box").css('height','unset');
        $(".chat-input").show();
        $(this).hide();
        $(this).parent().append('<span class="chat-box-min" style="line-height: 0"><i class="fas fa-minus"></i></span>');

    })
      
    // send message AJAX
    const sendBtn = $("#chat-submit");
    const form = $("#messages_send_form");

    form.on("submit", function(event) {
        event.preventDefault();
    });

    sendBtn.on("click", function() {
        const url = form.attr("action");
        
        $.ajax({
            type: "post",
            url: url,
            data: form.serialize(),
            success:function(response) {
                if($('.chat-logs').children().not('img').length > 0) {
                    
                } else {
                    $('.chat-logs').empty();
                }
                $("#chat-input").val('');
                $('.chat-logs').append(response);
                scrollToBottom();
                getAllChats();
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
    const readAt = function(id, type) {
        $.ajax({
            type: "get",
            url: readAtUrl,
            data: {
                id: id,
                type: type,
            },
            success:function(response) {

            }
        })
    }
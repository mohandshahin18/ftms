
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

        
    });
    
           
    // show chat box when clicking on chat circle button
    $(function() {

        $(".media .chat-circle").on("click", function(event) {
            event.preventDefault();
            var slug = $(this).data('slug');
            var type = $(this).data('type');
            var name = $(this).data('name');

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
                    $('.chat-logs').append('<div class="spinner-div d-flex align-items-center justify-content-center" width: 100%; position: absolute; width: 100%;height: 100%;z-index: 884;background: #fff; top: 0; right: 0;"><i class="fa fa-spin fa-spinner"></i> Loading...</div>');
                },
                success:function(response) {
                    setTimeout(function() {
                        $('.chat-logs').empty();
                        $('.chat-logs').append(response);
                        scrollToBottom();
                    }, 1000);
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
        $.ajax({
            type: "post",
            url: url,
            data: form.serialize(),
            success:function(response) {
                $("#chat-input").val('');
                $('.chat-logs').append(response);
                scrollToBottom();
            }
        });
    });

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
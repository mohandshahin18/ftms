import './bootstrap';


if(from == 'student'){
    Echo.private('App.Models.Student.' + studentId)
        .notification((notification) => {
            // let massege = `<a href="${host}/${lang}/mark-student-read/${notification.id}">${notification.name} ${notification.msg}</a>`;

            // toastr.success(massege);

            let notify_number  = $('.notify-number').html();
            if(notify_number == undefined){
                $('.notify').append('<span class="notify-number">1</span>');
                $('#no_notification').remove();
            }else{
                let new_number  = $('.notify-number').text(parseInt(notify_number) + 1 );
                $('.notify-number').append(new_number);
            }

            let name = notification.name ?? '';
            let src = `https://ui-avatars.com/api/?background=random&name=${name}`;
            if(notification.image) {
                let image = notification.image;
                src = host+'/'+image;
              }
            $('#dropNotification').prepend(`<div class="media">
                                                <a href="${host}/${lang}/mark-student-read/${notification.id}" class="list-group-item list-group-item-action active" style="font-weight: unset">

                                                    <div class="main-info">
                                                        <div class="d-flex align-items-center" style="gap:
                                                        8px !important;">
                                                            <img src="${src}">
                                                            <h3 class="dropdown-item-title">${notification.name}</h3>
                                                        </div>
                                                        <div>
                                                            <p class="d-flex justify-content-start align-items-center float-right" style="gap:4px; font-size: 12px; margin:0 ">
                                                                <i class="far fa-clock " style="line-height: 1; font-size: 12px; color: #464a4c !important"></i>
                                                                ${time}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="media-body mt-2">

                                                        <p class="text-sm">${notification.msg}</p>

                                                    </div>

                                                </a>
                                            </div>
                                    `)

});


    }else
     if(from == 'admin'){
        Echo.private('App.Models.Company.' + companyId)
            .notification((notification) => {
                // let massege = `<a href="${host}/${lang}/admin/mark-read/${notification.id}">${notification.name} ${notification.msg}</a>`;
                // toastr.success(massege);

                let notify_number  = $('.notify-number').html();
                if(notify_number == undefined){
                    $('.notify').append('<span class="badge badge-danger navbar-badge notify-number">1</span>');
                }else{
                    let new_number  = $('.notify-number').text(parseInt(notify_number) + 1 );
                    $('.notify-number').append(new_number);
                }
                let name = notification.name ?? '';
                let src = `https://ui-avatars.com/api/?background=random&name=${name}`;
                if(notification.image) {
                    let image = notification.image;
                    src = host+'/'+image;
                  }

                $('#dropNotification').prepend(`<a href="${host}/${lang}/admin/mark-read/${notification.id}" class="dropdown-item unread">
                                                <div class="media">
                                               <img src="${src}" class="img-size-50 mr-3 img-circle image-avatar">

                                                    <div class="media-body">
                                                        <h3 class="dropdown-item-title">${notification.name}</h3>
                                                        <p class="text-sm">${notification.msg}</p>
                                                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>${time}</p>

                                                    </div>
                                                </div>
                                            </a>
                                        `);

        });
    }

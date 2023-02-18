import './bootstrap';

Echo.private('App.Models.Company.' + companyId)
    .notification((notification) => {
        console.log(notification);
     });


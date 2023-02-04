// Delete
$('.delete_form').on('submit', function(e) {
      e.preventDefault();

      let url = $(this).attr('action');

      let data = $(this).serialize();

      Swal.fire({
          title: 'Are you sure?',
          text: "It will be deleted",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#000',
          confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
          if (result.isConfirmed) {
              // send ajax request and delete post
              $.ajax({
                  type: 'post',
                  url: url,
                  data: data,
                  success: function(res) {
                      $('#row_' + res).remove();

                  }

              })

              const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 2000,
                  timerProgressBar: false,
                  didOpen: (toast) => {
                      toast.addEventListener('mouseenter', Swal.stopTimer)
                      toast.addEventListener('mouseleave', Swal.resumeTimer)
                  }
              })

              Toast.fire({
                  icon: 'error',
                  title: 'Delete Completed'
              })
          }
      })



  });
  

//   Restor 
$('.restor_form').on('submit', function(e) {
    e.preventDefault();

    let url = $(this).attr('action');

    let data = $(this).serialize();

    Swal.fire({
        title: 'Are you sure?',
        text: "It will be Restored",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#000',
        confirmButtonText: 'Yes, restore it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // send ajax request and resotre
            $.ajax({
                type: 'post',
                url: url,
                data: data,
                success: function(res) {
                    $('#row_' + res).remove();

                }

            })

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: false,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'info',
                title: 'Restored Successfully'
            })
        }
    })



});
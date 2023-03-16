// Delete
$('.delete_form').on('submit', function(e) {
      e.preventDefault();

      let url = $(this).attr('action');

      let data = $(this).serialize();

      Swal.fire({
          title: title,
          text: text,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#000',
          confirmButtonText: confirmButtonText,
          cancelButtonText: cancel
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
                  position: 'top',
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
                  title: deleteCompalete
              })
          }
      })
    //   console.log(tbody);


  });


//   Restor
$('.restor_form').on('submit', function(e) {
    e.preventDefault();

    let url = $(this).attr('action');

    let data = $(this).serialize();

    Swal.fire({
        title: title,
        text: text2,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#000',
        confirmButtonText: confirmButtonText2 ,
        cancelButtonText: cancel

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
                position: 'top',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: false,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: restoreComplete
            })
        }
    })

});



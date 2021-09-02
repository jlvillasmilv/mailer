$(document).ready(function () {
  window._token = $('meta[name="csrf-token"]').attr('content')

  $('[data-toggle="tooltip"]').tooltip()
  
  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

  $('.select2').select2()
   /*Notificaciones si hay mensaje de confirmacion*/

   if (document.body.dataset.notification == ""){

        var type = document.body.dataset.notificationType;
        var types = ['info', 'warning', 'success', 'error'];

    // Check if `type` is in our `types` array, otherwise default to info.
        Toast.fire({ icon: types.indexOf(type) !== -1 ? type : 'info', title: JSON.parse(document.body.dataset.notificationMessage) });
    
    }

     $('#table').on('click', '.btn-delete[data-remote]', function (e) { 
            e.preventDefault();
            var url = $(this).data('remote');
            
            Swal.fire({
            title: '¿Desea eliminar este registro?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText:'No',
            showLoaderOnConfirm: true,
                preConfirm: () => {

                      axios.delete(url).then(response => {

                        Toast.fire({
                          icon: 'success',
                          title: 'Operacion realizada con exito'
                        })
                        $('#table').DataTable().draw(false);
                      
                      }).catch(error => {
                        Toast.fire({
                          icon: 'error',
                          title: 'Errore de Conexion'
                        })

                      
                        console.error(error.response.data)
                      });

                }
           });
            
        });


      $('#table').on('click', '.btn-status[data-remote]', function (e) { 
          e.preventDefault();
          var url = $(this).data('remote');
          
          Swal.fire({
          title: '¿Desea solicitar desembolso?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Si',
          cancelButtonText:'No',
          cancelButtonColor: '#d33',
          showLoaderOnConfirm: true,
              preConfirm: () => {

                    axios.put(url).then(response => {
                      // document.getElementById(this).style.visibility = 'hidden';
                      Swal.fire({
                        icon: 'success',
                        title: 'Se ha solicitado el desembolso! ',
                    
                        timer: 5000,
                        timerProgressBar: true,
                        }).then((result) => {
                          /* Read more about handling dismissals below */
                          if (result.dismiss === Swal.DismissReason.timer) {
                            location.reload()
                          }
                        })

                        window.setTimeout(function(){location.reload()},3000)
                    
                    }).catch(error => {
                      Toast.fire({
                        icon: 'error',
                        title: 'Errore de Conexion'
                      })

                      console.error(error.response.data)
                    });

              }
         });
          
      });


      $('#table').on('click', '.btn-sync[data-remote]', function (e) { 
          e.preventDefault();
          var url = $(this).data('remote');
          let msg = $(this).data('type');
          
          Swal.fire({
          title: '¿Desea cargar ultimos 24 meses de '+msg+'?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Si',
          cancelButtonText:'No',
          cancelButtonColor: '#d33',
          showLoaderOnConfirm: true,
          preConfirm: () => {
            return fetch(url)
              .then(response => {
                if (!response.ok) {
                  console.log(response);
                  throw new Error(response.statusText)
                }
                return response.json()
              })
              .catch(error => {
               
                Swal.showValidationMessage(
                  `Falla al cargar: ${error}`
                )
                window.setTimeout(function(){location.reload()},3000)
              })
          },
          allowOutsideClick: () => !Swal.isLoading()
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire({
                icon: 'success',
                title: 'Carga generada con exito',
                
              })
            }
          })
          
      });


})

  
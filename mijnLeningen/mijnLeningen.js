document.getElementById('nietInBezit').addEventListener('click', function() {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, cancel it!'
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire(
        'Cancelled!',
        'Your reservation has been cancelled.',
        'success'
      );
      // Add any further actions here after cancellation confirmation
    }
  });
});

document.getElementById('welInBezit').addEventListener('click', function() {
  var button = this;
  if (button.textContent === 'Annuleren') {
    Swal.fire({
      title: 'Are you sure?',
      text: "Would you like to cancel the extension?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, cancel it!'
    }).then((result) => {
      if (result.isConfirmed) {
        button.textContent = 'Verlengen';
        Swal.fire(
          'Cancelled!',
          'Your extension has been cancelled.',
          'success'
        );
        // Add any further actions here after cancellation confirmation
      }
    });
  } else {
    button.textContent = 'Annuleren';
  }
});
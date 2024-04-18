// JavaScript code to handle button clicks
document.getElementById('nietInBezit').addEventListener('click', function() {
  var button = this;
  if (button.textContent === 'Annuleren') {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
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
      button.textContent = 'Uitlenen';
      button.style.backgroundColor = 'green';
    }
  });
}else {
  button.textContent = 'Annuleren';
  button.style.backgroundColor = 'red';
}
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
        button.style.backgroundColor = 'green';
        // Add any further actions here after cancellation confirmation
      }
    });
  } else {
    button.textContent = 'Annuleren';
    button.style.backgroundColor = 'red';
  }
});
$(function () {
    $('input[name="daterange"]').daterangepicker({
        opens: 'center',
        minDate: moment().toDate(),
        maxDate: moment().add(3, 'weeks').toDate(),
        startDate: moment().toDate(),
    }, function (start, end, label) {
        let startDatum = start.format('YYYY-MM-DD');
        let eindDatum = end.format('YYYY-MM-DD');
        console.log("A new date selection was made: " + startDatum + ' to ' + eindDatum);

    });
});

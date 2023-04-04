// Call the dataTables jQuery plugin

$(document).ready(function() {
  $('#dataTable').DataTable( {
    "responsive": true,  "autoWidth": false
})
});
// $(document).ready(function() {
//   $('#dataTable').DataTable( {
//     "responsive": true,  "autoWidth": false,
//     'buttons': ["copy", "excel", "pdf", "print"]
// }).buttons().container().appendTo('#dataTable_wrapper .col-md-6:eq(0)');
// });
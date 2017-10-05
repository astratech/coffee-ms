$(document).ready(function(){ 

$('#cs-data-table').DataTable(
  {
      dom: 'Bfrtip',
    buttons: [
      {
         extend: 'collection',
         text: 'Export',
         buttons: [ 'pdfHtml5', 'csvHtml5', 'copyHtml5', 'excelHtml5','print' ]
      }
    ]
   }
  );

});



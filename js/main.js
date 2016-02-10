$(function() {
  $('.dbtable2databable').DataTable({
    "paging": dbtable2tableOptions.pagination,
    "dom": 'filrtp',
    "pageLength": dbtable2tableOptions.limit,
    "language" : {
    	"url" : "//cdn.datatables.net/plug-ins/1.10.10/i18n/"+ dbtable2tableOptions.language +".json"
    }
  });
});
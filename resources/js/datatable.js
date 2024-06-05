
require('datatables.net/js/jquery.dataTables')

// require('datatables.net')
require('datatables.net-bs4')

require( 'datatables.net-buttons')
require( 'datatables.net-buttons/js/buttons.colVis.js')
require( 'datatables.net-buttons/js/buttons.html5.js' )
require( 'datatables.net-buttons/js/buttons.flash.js' )
require( 'datatables.net-buttons/js/buttons.print.js' )
// require( 'datatables.net-buttons-bs4')

// require('datatables.net-responsive')
require('datatables.net-responsive-bs4')

// require('datatables.net-fixedHeader')
require('datatables.net-fixedHeader-bs4')

var $ = require('jquery')

// $('#mytable').DataTable(); 
$(document).ready(function()
{
    $('#mytable').setupDataTable( {
        // responsive: true,
        paging: false,
        fixedHeader: true,
        ordering:true,
        dom: 'Brtip',
        
		buttons: [
			{
                text: '<i class="fas fa-copy fa-1x"></i> Copy',
				extend: 'copy',
				exportOptions:{
					columns: ':visible'
				}
			},
			{
                text: '<i class="fas fa-file-csv"></i> CSV',
				extend: 'csv',
				exportOptions:{
					columns: ':visible'
				}
			},
            {
                text: '<i class="fas fa-sync"></i> Refresh',
                action: function(e, dt, node, config){
                    window.location.reload();
                }
            }
		]
    } )
})

$.fn.setupDataTable = function( option ){
	var myDT = this.DataTable(option);
    $('input.column_filter').on( 'keyup click', function () {
		filterColumn( $(this).parents().parents('div').attr('data-column'),myDT);
	} );
	$('select.column_filter').on( 'change', function () {
		filterColumn( $(this).parents().parents('div').attr('data-column'),myDT);
	} );
};

function filterColumn( i, table ){
	if(i==99){
		table.search(
			$('#col'+i+'_filter').val()
			,true
		).draw();
	}
	table.columns( i ).search(
		$('#col'+i+'_filter').val()
		,true
	).draw();
}
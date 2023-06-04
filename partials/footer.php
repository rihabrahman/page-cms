    </body>
</html>
<script src="https://cdn.tiny.cloud/1/6d60co0ye77h7jzv1r3d7ku4n6gpkr59pv0y2dhe7aeh6r2i/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>                    
<script>
     tinymce.init({
        selector: 'textarea',
        plugins: 'lists',
        plugins: 'table',
        toolbar: 'table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol',
        toolbar: 'numlist bullist'
    });
    
    $(function () {
        $('#data-table').DataTable({
            pageLength: 10,
            "bAutoWidth": false,
            "scrollX": true,
            //"ajax": './assets/demo/data/table_data.json',
            "dom": "Bfrtip",
            // //column visibility
            "buttons": [
                {
                    extend: 'colvis',
                    collectionLayout: 'fixed two-column'
                    // columns: ':not(.permanent)'
                },
                {
                    extend: 'print',
                    footer: true,
                    orientation: 'landscape',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ],
            'language': {
                'buttons': {
                    colvis: 'Column Visibility',
                    print: 'Print',
                    excel: 'Excel Export',
                    //

                }
            }
        });
    })
</script>
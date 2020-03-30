$(document).ready(function(){

  var dataTable=$('#example').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax":{
          url:"fetch.php",
          type:"post"
      }
  });

  $('#reset').click(function(){
    $('#nama_produk').val('');
    $('#harga_jual').val('');
    $('#stok').val('');
    $('#stok_min').val('');
    $('#harga_beli').val('');
  });

  // save data
  $(document).on('click', '#submit_btn', function(){

    if ($('#nama_produk').val()=='') {
        Metro.notify.create("Nama Produk harus diisi", "Informasi", {cls: "alert"});
    }else if ($('#harga_beli').val()=='') {
        Metro.notify.create("Harga Beli harus diisi", "Informasi", {cls: "alert"});
    }else if ($('#harga_jual').val()=='') {
        Metro.notify.create("Harga Jual harus diisi", "Informasi", {cls: "alert"});
    }else if ($('#stok').val()=='') {
        Metro.notify.create("Stok harus diisi", "Informasi", {cls: "alert"});
    }else if ($('#stok_min').val()=='') {
        Metro.notify.create("Min Stok harus diisi", "Informasi", {cls: "alert"});
    }else{
    var nama_produk = $('#nama_produk').val();
    var harga_jual = $('#harga_jual').val();
    var ukuran = $('#ukuran').val();
    var stok = $('#stok').val();
    var stok_min = $('#stok_min').val();
    var harga_beli = $('#harga_beli').val();
    $.ajax({
      url: '../../../application/admin/produk/crud_produk.php',
      type: 'POST',
      data: {
        'save': 1,
        'nama_produk': nama_produk,
        'harga_jual': harga_jual,
        'ukuran': ukuran,
        'stok': stok,
        'stok_min': stok_min,
        'harga_beli': harga_beli
      },
      success: function(response){
          Metro.notify.create("Input Sukses", "Informasi", {cls: "success"});
          var table = $('#example').DataTable();
          table.draw('page');
      }
    }); //akhir ajax
  }
}); //save data

  // delete data
  $(document).on('click', '#hapus', function(){
  	var id_produk = $(this).attr("data-id");
  	$clicked_btn = $(this);
  	$.ajax({
  	  url: '../../../application/admin/produk/crud_produk.php',
  	  type: 'GET',
  	  data: {
    	'delete': 1,
    	'id_produk': id_produk
      },
      success: function(response){
        Metro.notify.create("Delete Sukses", "Informasi", {cls: "success"});
        var table = $('#example').DataTable();
        table.draw('page');
      }
  	});
  }); //delete data

  //edit
  var idb;
  $('#example tbody').on( 'click', '#edit', function () {
    var data = dataTable.row( $(this).parents('tr') ).data();
    idb = data[0];
    $('#nama_produk').val(data[1]);
    $('#harga_beli').val(data[2]);
    $('#harga_jual').val(data[3]);
    $('#stok').val(data[4]);
    $('#stok_min').val(data[5]);
    $('#submit_btn').hide();
    $('#update').show();
} );

  //update data
  $(document).on('click', '#update', function(){
  	var edit_idb = idb;
    var nama_produk = $('#nama_produk').val();
    var harga_beli = $('#harga_beli').val();
    var harga_jual = $('#harga_jual').val();
    var stok = $('#stok').val();
    var stok_min = $('#stok_min').val();
  	$.ajax({
      url: '../../../application/admin/produk/crud_produk.php',
      type: 'POST',
      data: {
      	'update': 1,
      	'eid': edit_idb,
        'nama_produk': nama_produk,
        'harga_beli': harga_beli,
        'harga_jual': harga_jual,
        'stok': stok,
        'stok_min': stok_min
      },
      success: function(response){
        $('#nama_produk').val('');
        $('#stok').val('');
        $('#stok_min').val('');
        $('#harga_beli').val('');
        $('#harga_jual').val('');
        $('#submit_btn').show();
        $('#update').hide();
        Metro.notify.create("Update Sukses", "Informasi", {cls: "success"});
        var table = $('#example').DataTable();
        table.draw('page');

      }
  	});
  }); //update data

      // $(document).on('click','#hapus_trans',function(e){
      //     e.preventDefault();
      //     var per_id=$(this).data('id');
      //     $('#content-data').html('');
      //     $.ajax({
      //         url:'editdata_stok.php',
      //         type:'POST',
      //         data:'id='+per_id,
      //         dataType:'html'
      //     }).done(function(data){
      //         $('#content-data').html('');
      //         $('#content-data').html(data);
      //     }).fail(function(){
      //         $('#content-data').html('<p>Error</p>');
      //     });
      // });

      $('#example tbody').on('click', '#hapus_trans', function(){

        // console.log(updId);
          var data = dataTable.row( $(this).parents('tr') ).data();
          var delId = data[0];
          $('#dialog-confirm').show();

          $( "#dialog-confirm" ).dialog({
            resizable: false,
            height: "auto",
            width: "auto",
            modal: true,
            buttons: {
              "Ya": function() {
                	$.ajax({
                	  url: 'crud_produk.php',
                	  type: 'GET',
                	  data: {
                  	'delete': 1,
                  	'id_produk': delId
                    },
                    success: function(response){
                      Metro.notify.create("Delete Sukses", "Informasi", {cls: "success"});
                      console.log(response);
                      var table = $('#example').DataTable();
                      table.draw('page');
                    }
                	});
                  $( this ).dialog( "close" );
              },
              "Tidak": function() {
                $( this ).dialog( "close" );
              }
            }
          });


      });


}); //akhir doc ready

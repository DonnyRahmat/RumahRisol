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
    $('#nama_barang').val('');
    $('#ukuran').val('');
    $('#stok').val('');
    $('#stok_min').val('');
    $('#harga_beli').val('');
  });

  // save data
  $(document).on('click', '#submit_btn', function(){

    if ($('#nama_barang').val()=='') {
        Metro.notify.create("Nama Barang harus diisi", "Informasi", {cls: "alert"});
    }else if ($('#ukuran').val()=='') {
        Metro.notify.create("Ukuran harus diisi", "Informasi", {cls: "alert"});
    }else if ($('#stok').val()=='') {
        Metro.notify.create("Stok harus diisi", "Informasi", {cls: "alert"});
    }else if ($('#stok_min').val()=='') {
        Metro.notify.create("Min Stok harus diisi", "Informasi", {cls: "alert"});
    }else if ($('#harga_beli').val()=='') {
        Metro.notify.create("Harga Beli harus diisi", "Informasi", {cls: "alert"});
    }else{
    var nama_barang = $('#nama_barang').val();
    var satuan = $('#satuan').val();
    var ukuran = $('#ukuran').val();
    var stok = $('#stok').val();
    var stok_min = $('#stok_min').val();
    var harga_beli = $('#harga_beli').val();
    $.ajax({
      url: '../../../application/admin/stok/crud_bahanbaku.php',
      type: 'POST',
      data: {
        'save': 1,
        'nama_barang': nama_barang,
        'satuan': satuan,
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
  	var id_barang = $(this).attr("data-id");
  	$clicked_btn = $(this);
  	$.ajax({
  	  url: '../../../application/admin/stok/crud_bahanbaku.php',
  	  type: 'GET',
  	  data: {
    	'delete': 1,
    	'id_barang': id_barang
      },
      success: function(response){
        Metro.notify.create("Delete Sukses", "Informasi", {cls: "success"});
        var table = $('#example').DataTable();
        table.draw('page');
      }
  	});
  }); //delete data

  //edit
  var edit_id;
  var $edit_comment;

  // $(document).on('click', '#edit', function(){
  // 	edit_id = $(this).attr("data-id");
  // 	$edit_comment = $(this).parent();
  // 	// grab the comment to be editted
  // 	var nama_barang = $(this).siblings('.display_name').text();
  // 	var satuan = $(this).siblings('.comment_text').text();
  // 	// place comment in form
  // 	$('#nama_barang').val(edit_id);
  // 	$('#satuan').val(satuan);
  // 	$('#submit_btn').hide();
  // 	$('#update_btn').show();
  // }); //edit data
  var idb;
  $('#example tbody').on( 'click', '#edit', function () {
    var data = dataTable.row( $(this).parents('tr') ).data();
    idb = data[0];
    $('#nama_barang').val(data[1]);
    $('#satuan').val(data[2]);
    var uk = data[2].match(/\d+/);
    $('#ukuran').val(uk);
    $('#stok').val(data[3]);
    $('#stok_min').val(data[4]);
    $('#harga_beli').val(data[5]);
    $('#submit_btn').hide();
    $('#update').show();
} );

  //update data
  $(document).on('click', '#update', function(){
  	var edit_idb = idb;
    var nama_barang = $('#nama_barang').val();
    var satuan = $('#satuan').val();
    var ukuran = $('#ukuran').val();
    var stok = $('#stok').val();
    var stok_min = $('#stok_min').val();
    var harga_beli = $('#harga_beli').val();
  	$.ajax({
      url: '../../../application/admin/stok/crud_bahanbaku.php',
      type: 'POST',
      data: {
      	'update': 1,
      	'eid': edit_idb,
        'nama_barang': nama_barang,
        'satuan': satuan,
        'ukuran': ukuran,
        'stok': stok,
        'stok_min': stok_min,
        'harga_beli': harga_beli
      },
      success: function(response){
        $('#nama_barang').val('');
        $('#ukuran').val('');
        $('#stok').val('');
        $('#stok_min').val('');
        $('#harga_beli').val('');
        $('#submit_btn').show();
        $('#update').hide();
        Metro.notify.create("Update Sukses", "Informasi", {cls: "success"});
        var table = $('#example').DataTable();
        table.draw('page');

      }
  	});
  }); //update data

  //datatable render pake objek
//   $('#example').DataTable( {
//     processing: true,
//     "serverSide": true,
//     responsive: true,
//     ajax: "data_stok.php",
//     aoColumns: [
//       {mData: "id_barang"},
//       {mData: "nama_barang"},
//       {mData: "satuan"},
//       {mData: "ukuran"},
//       {mData: "stok"},
//       {mData: "stok_min"},
//       {mData: "harga_beli"},
//       {mData: "aksi"}
//     ]
// } ); //datatable

      $(document).on('click','#editData',function(e){
          e.preventDefault();
          var per_id=$(this).data('id');
          $('#content-data').html('');
          $.ajax({
              url:'editdata_stok.php',
              type:'POST',
              data:'id='+per_id,
              dataType:'html'
          }).done(function(data){
              $('#content-data').html('');
              $('#content-data').html(data);
          }).fail(function(){
              $('#content-data').html('<p>Error</p>');
          });
      });

}); //akhir doc ready

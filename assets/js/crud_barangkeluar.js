$(document).ready(function(){

  $(document).on('keydown', '.nmbarang', function() {

   var id = this.id;
   var splitid = id.split('_');
   var index = splitid[1];

 // Initialize jQuery UI autocomplete
 $( '#'+id ).autocomplete({
  source: function( request, response ) {
   $.ajax({
    url: "../../admin/barang_keluar/l_data.php",
    type: 'post',
    dataType: "json",
    data: {
     search: request.term,
     request:1
    },
    success: function( data ) {
     response( data );
    }
   });
  },
  select: function (event, ui) {
   $(this).val(ui.item.label); // display the selected text
   var id_barang = ui.item.value; // selected value

   // AJAX
   $.ajax({
    url: '../../admin/barang_keluar/l_data.php',
    type: 'post',
    data: {
      id_barang:id_barang,
      request:2
    },
    dataType: 'json',
    success:function(response){

     var len = response.length;

     if(len > 0){
      var idb  = response[0]['idb'];
      var nb   = response[0]['nb'];
      var u    = response[0]['u'];
      var s    = response[0]['s'];
      var hb   = response[0]['hb'];

      // Set value to textboxes

      document.getElementById('idbarang_'+index).value = idb;
      document.getElementById('stok_'+index).value = s;
      document.getElementById('ukuran_'+index).value = u;
      document.getElementById('harga_jual_'+index).value = hb;
      var numb = parseInt(s);
      var min = 1;

      // fungsi max stok dan min stok
      $('#jml_brgklr_'+index).attr("min", min);
      $('#jml_brgklr_'+index).attr("max", numb);
      $('#jml_brgklr_'+index).on('keydown keyup', function(e){

          if ($(this).val() > numb
              && e.keyCode !== 46
                && e.keyCode !== 8
             ) {
             e.preventDefault();
             $(this).val(numb);
          }
      });//akhir fungsi max min stok
     }
    }
   });
   return false;
  }
 });
});

// Add more
$('#addmore').click(function(){
 //
 // // Get last id
 var lastname_id = $('.tr_input input[type=text]:nth-child(1)').last().attr('id');
 // console.log(lastname_id);
 if (lastname_id == undefined) {
    var index = 1;
 }else{
    var split_id = lastname_id.split('_');
    var index = Number(split_id[1]) + 1;
 }


 // New index
 var html = "<tr class='tr_input'><td><input type='text' class='nmbarang' id='nmbarang_"+index+"' placeholder='Masukkan Nama Barang'><input type='number' class='idbarang' id='idbarang_"+index+"' name='idbarang[]' hidden></td><td><input type='text' class='stok' id='stok_"+index+"' readonly></td><td><input type='text' class='ukuran' id='ukuran_"+index+"' readonly></td><td><input type='number' class='harga_jual' id='harga_jual_"+index+"' name='harga_jual[]'></td><td><input type='number' class='jml_brgklr' id='jml_brgklr_"+index+"' name='jml_brgklr[]'></td><td><input type='button' value='Delete' class='delete'></td></tr>";

 // Append data
 $('.aut').append(html);
});//end add more

  //delete data
  $('table').on('click','.delete',function(){
      $(this).closest('tr').remove();
  });

  //save data
  $('#save').click(function(){
   var idbarang = [];
   var harga_jual = [];
   var jml_brgklr = [];
   var transaksi = [];
   $('.idbarang').each(function(){
    idbarang.push($(this).val());
   });
   $('.harga_jual').each(function(){
    harga_jual.push($(this).val());
   });
   $('.jml_brgklr').each(function(){
    jml_brgklr.push($(this).val());
   });
   $.ajax({
    url:"crud_brgklr.php",
    method:"POST",
    data:{
      idbarang:idbarang,
      harga_jual:harga_jual,
      jml_brgklr:jml_brgklr
    },
    success:function(data){
     console.log(data);
     Metro.notify.create("Input barang masuk sukses", "Informasi", {cls: "success"});
     $(".aut").empty();
     var res = "<tr class='tr_input'><td><input type='text' class='nmbarang' id='nmbarang_1' placeholder='Masukkan Nama Barang'><input type='number' class='idbarang' id='idbarang_1' name='idbarang[]' hidden><input type='text' class='id_detil_brgklr' id='id_detil_brgklr_1' hidden><input type='text' class='id_brgklr' id='id_brgklr_1' hidden><input type='text' class='stk_awal' id='stk_awal_1' hidden></td><td><input type='text' class='stok' id='stok_1' readonly></td><td><input type='text' class='ukuran' id='ukuran_1' readonly></td><td><input type='number' class='harga_jual' name='harga_jual[]' id='harga_jual_1' ></td><td><input type='number' class='jml_brgklr' name='jml_brgklr[]' id='jml_brgklr_1'></td><td><input type='button' value='Delete' class='delete'></td></tr>";
     $(".aut").append(res);
     var table = $('#example').DataTable();
     table.draw('page');
    }
   });
  });

  var dataTable=$('#example').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax":{
          url:"fetch.php",
          type:"post"
      }
  });

  $('#reset').click(function(){
    $('#nmbarang_1').val('');
    $('#id_barang_1').val('');
    $('#id_detil_brgklr_1').val('');
    $('#id_brgklr_1').val('');
    $('#stok_1').val('');
    $('#ukuran_1').val('');
    $('#harga_jual_1').val('');
    $('.jml_brgklr').val('');
  });

  $('#example tbody').on('click', '#edit', function(){
   // var id = $(this).attr('id');
   var data = dataTable.row( $(this).parents('tr') ).data();
   var updId = data[0];
   $('#addmore').hide();
   $('#save').hide();
   $('#update').show();
   $('#batal').show();
   $.ajax({
        url:"crud_brgklr.php",
        method:"POST",
        data:{
          'getUpd':1,
          'updId':updId
        },
        dataType:"json",
        success:function(data){
             $('#idbarang_1').val(data.id_barang);
             $('#nmbarang_1').val(data.nama_barang);
             $('#stok_1').val(data.stok);
             $('#ukuran_1').val(data.uk);
             $('#harga_jual_1').val(data.harga_brgklr);
             $('.jml_brgklr').val(data.jml_brgklr);
             $('#id_detil_brgklr_1').val(data.id_detil_brgklr);
             $('#id_brgklr_1').val(data.id_brgklr);
             $('#stk_awal_1').val(data.jml_brgklr);
             $('.delete').hide();
             // fungsi max stok dan min stok
             var s = data.stok;
             var numb = parseInt(s);
             var min = 1;
             $('#jml_brgklr_1').attr("min", min);
             $('#jml_brgklr_1').attr("max", numb);
             $('#jml_brgklr_1').on('keydown keyup', function(e){

                 if ($(this).val() > numb
                     && e.keyCode !== 46
                       && e.keyCode !== 8
                    ) {
                    e.preventDefault();
                    $(this).val(numb);
                 }//akhir fungsi max min stok
             });
        } //end success
   }); //end ajax edit
 }); //end edit func

  $(document).on('click', '#update', function(){
    var updId = $('#id_detil_brgklr_1').val();
    var idbar = $('#idbarang_1').val();
    var nmbar = $('#nmbarang_1').val();
    var stok = $('#stok_1').val();
    var ukuran = $('#ukuran_1').val();
    var harga_beli = $('#harga_jual_1').val();
    var jml = $('.jml_brgklr').val();
    var ibm = $('#id_brgklr_1').val();
    var ja = $('#stk_awal_1').val();
    $.ajax({
        url:"../../../application/admin/barang_keluar/crud_brgklr.php",
        type: 'POST',
        data:{
          'updateTrans':1,
          'updId':updId,
          'idbar':idbar,
          'ibm':ibm,
          'nm':nmbar,
          's':stok,
          'u':ukuran,
          'hb':harga_beli,
          'j':jml,
          'ja':ja
        },
        success:function(response){
          $('#nmbarang_1').val('');
          $('#stok_1').val('');
          $('#ukuran_1').val('');
          $('#harga_jual_1').val('');
          $('.jml_brgklr').val('');
          $('#id_detil_brgklr').val('');
          $('#addmore').show();
          $('#save').show();
          $('#update').hide();
          $('#batal').hide();
          Metro.notify.create("Update data barang masuk sukses", "Informasi", {cls: "success"});
          console.log('update sukses');
          var table = $('#example').DataTable();
          table.draw('page');
        }
    });
  });

  $('#batal').click(function(){
    $('#nmbarang_1').val('');
    $('#stok_1').val('');
    $('#ukuran_1').val('');
    $('#harga_jual_1').val('');
    $('.jml_brgklr').val('');
    $('#id_detil_brgklr').val('');
    $('#addmore').show();
    $('#save').show();
    $('#update').hide();
    $(this).hide();
    $('.delete').show();
  });

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
            	  url: 'crud_brgklr.php',
            	  type: 'GET',
            	  data: {
              	'delete': 1,
              	'delId': delId
                },
                success: function(response){
                  Metro.notify.create("Delete Sukses", "Informasi", {cls: "success"});
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

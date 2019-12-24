$(document).ready(function(){

  $(document).on('keydown', '.nmbarang', function() {

   var id = this.id;
   var splitid = id.split('_');
   var index = splitid[1];

 // Initialize jQuery UI autocomplete
 $( '#'+id ).autocomplete({
  source: function( request, response ) {
   $.ajax({
    url: "../../admin/barang_masuk/l_data.php",
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
    url: '../../admin/barang_masuk/l_data.php',
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
      document.getElementById('harga_beli_'+index).value = hb;
      // var numb = parseInt(idb);

      //fungsi max stok dan min stok
      // $('#idbarang_'+index).attr("max", numb);
      // $('#idbarang_'+index).attr("min", 0);
      // $('#idbarang_'+index).on('keydown keyup', function(e){
      //
      //     if ($(this).val() > numb
      //         && e.keyCode !== 46
      //           && e.keyCode !== 8
      //        ) {
      //        e.preventDefault();
      //        $(this).val(numb);
      //     } //akhir fungsi max min stok
      // });
     }
    }
   });
   return false;
  }
 });
});

// Add more
$('#addmore').click(function(){

 // Get last id
 var lastname_id = $('.tr_input input[type=text]:nth-child(1)').last().attr('id');
 var split_id = lastname_id.split('_');

 // New index
 var index = Number(split_id[1]) + 1;

 var html = "<tr class='tr_input'><td><input type='text' class='nmbarang' id='nmbarang_"+index+"' placeholder='Masukkan Nama Barang'><input type='number' class='idbarang' id='idbarang_"+index+"' name='idbarang[]' hidden></td><td><input type='text' class='stok' id='stok_"+index+"' readonly></td><td><input type='text' class='ukuran' id='ukuran_"+index+"' readonly></td><td><input type='number' class='harga_beli' id='harga_beli_"+index+"' name='harga_beli[]'></td><td><input type='number' class='jml_brgmsk' id='jml_brgmsk_"+index+"' name='jml_brgmsk[]'></td><td><input type='button' value='Delete' class='delete'></td></tr>";

 // Append data
 $('.aut').append(html);
});

  //delete data
  $('table').on('click','.delete',function(){
      $(this).closest('tr').remove();
  });

  //save data
  $('#save').click(function(){
   var idbarang = [];
   var harga_beli = [];
   var jml_brgmsk = [];
   var transaksi = [];
   $('.idbarang').each(function(){
    idbarang.push($(this).val());
   });
   $('.harga_beli').each(function(){
    harga_beli.push($(this).val());
   });
   $('.jml_brgmsk').each(function(){
    jml_brgmsk.push($(this).val());
   });
   $.ajax({
    url:"insert_brgmsk.php",
    method:"POST",
    data:{
      idbarang:idbarang,
      harga_beli:harga_beli,
      jml_brgmsk:jml_brgmsk
    },
    success:function(data){
     console.log(data);
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
    $('#nama_barang').val('');
    $('#ukuran').val('');
    $('#stok').val('');
    $('#stok_min').val('');
    $('#harga_beli').val('');
  });



}); //akhir doc ready

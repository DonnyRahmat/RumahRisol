$(document).ready(function(){

  $(document).on('keydown', '.nmproduk', function() {

   var id = this.id;
   var splitid = id.split('_');
   var index = splitid[1];

 // Initialize jQuery UI autocomplete
   $( '#'+id ).autocomplete({
    source: function( request, response ) {
     $.ajax({
      url: "../../admin/produk_masuk/l_data.php",
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
     var id_produk = ui.item.value; // selected value

     // AJAX
     $.ajax({
      url: '../../admin/produk_masuk/l_data.php',
      type: 'post',
      data: {
        id_produk:id_produk,
        request:2
      },
      dataType: 'json',
      success:function(response){

       var len = response.length;

       if(len > 0){
        var idb  = response[0]['idb'];
        var nb   = response[0]['nb'];
        var s    = response[0]['s'];
        var hb   = response[0]['hb'];

        document.getElementById('idproduk_'+index).value = idb;
        document.getElementById('stok_'+index).value = s;
        document.getElementById('harga_beli_'+index).value = hb;
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
   // console.log(lastname_id);
   if (lastname_id == undefined) {
      var index = 1;
   }else{
      var split_id = lastname_id.split('_');
      var index = Number(split_id[1]) + 1;
   }


   // New index
   var html = "<tr class='tr_input'><td><input type='text' class='nmproduk' id='nmproduk_"+index+"' placeholder='Masukkan Nama produk' required><input type='number' class='idproduk' id='idproduk_"+index+"' name='idproduk[]' hidden></td><td><input type='text' class='stok' id='stok_"+index+"' readonly required></td> <td><input type='number' class='harga_beli' id='harga_beli_"+index+"' name='harga_beli[]' required></td><td><input type='number' class='jml_prdmsk' id='jml_prdmsk_"+index+"' name='jml_prdmsk[]' required></td><td><input type='button' value='Delete' class='delete'></td></tr>";

   // Append data
   $('.aut').append(html);
  });//end add more

  //delete data
  $('table').on('click','.delete',function(){
      $(this).closest('tr').remove();
  });


  //save data
  $('#save').click(function(){
      var idproduk = [];
      var harga_beli = [];
      var jml_prdmsk = [];

      $('.idproduk').each(function(){
          idproduk.push($(this).val());
      });

      $('.harga_beli').each(function(){
          harga_beli.push($(this).val());
      });

      $('.jml_prdmsk').each(function(){
          jml_prdmsk.push($(this).val());
      });

      $.ajax({
       url:"crud_prdmsk.php",
       method:"POST",
       data:{
         idproduk:idproduk,
         harga_beli:harga_beli,
         jml_prdmsk:jml_prdmsk
       },
       success:function(data){
        Metro.notify.create(data, "Informasi", {cls: "info"});
        if (data=="Input Data Sukses") {
          $(".aut").empty();
          var res = "<tr class='tr_input'><td><input type='text' class='nmproduk' id='nmproduk_1' placeholder='Masukkan Nama produk'><input type='number' class='idproduk' id='idproduk_1' name='idproduk[]' hidden><input type='text' class='id_prdmsk' id='id_prdmsk_1' hidden><input type='text' id='jml_awal_1' class='jml_awal' hidden></td><td><input type='text' class='stok' id='stok_1' readonly><input type='text' class='stok_awal' id='stok_awal_1' readonly required hidden></td><td><input type='number' class='harga_beli' name='harga_beli[]' id='harga_beli_1' ></td><td><input type='number' class='jml_prdmsk'name='jml_prdmsk[]' id='jml_prdmsk_1'></td></tr>";
          $(".aut").append(res);
        }
        var table = $('#example').DataTable();
        table.draw('page');
       }
      });
  });//end func save

  var dataTable=$('#example').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax":{
          url:"fetch.php",
          type:"post"
      }
  });

  $('#reset').click(function(){
    $('#nmproduk_1').val('');
    $('#id_produk_1').val('');
    $('#id_detil_prdmsk_1').val('');
    $('#id_prdmsk_1').val('');
    $('#stok_1').val('');
    $('#ukuran_1').val('');
    $('#harga_beli_1').val('');
    $('.jml_prdmsk').val('');
  });

  $('#example tbody').on('click', '#edit', function(){
   // var id = $(this).attr('id');
   var data = dataTable.row( $(this).parents('tr') ).data();
   var updId = data[0];
   $('#addmore').hide();
   $('#save').hide();
   $('#update').show();
   $('#batal').show();
   $('.delete').hide();
   $.ajax({
        url:"crud_prdmsk.php",
        method:"POST",
        data:{
          'getUpd':1,
          'updId':updId
        },
        dataType:"json",
        success:function(data){
          // console.log(data);
             $('#idproduk_1').val(data.id_produk);
             $('#nmproduk_1').val(data.nama_produk);
             $('#harga_beli_1').val(data.harga_beli);
             $('#stok_1').val(data.stok);
             $('.jml_prdmsk').val(data.jml_prdmsk);
             $('#id_prdmsk_1').val(data.id_prdmsk);
             $('.stok_awal').val(data.jml_prdmsk);
        } //end success
   }); //end ajax edit
 }); //end edit func

  $(document).on('click', '#update', function(){
    var idprd = $('#idproduk_1').val();
    var ipm = $('#id_prdmsk_1').val();
    var nmprd = $('#nmproduk_1').val();
    var stok = $('#stok_1').val();
    var harga_beli = $('#harga_beli_1').val();
    var jml = $('#jml_prdmsk_1').val();
    var ja = $('#stok_awal_1').val();
    $.ajax({
        url:"../../../application/admin/produk_masuk/crud_prdmsk.php",
        method: 'POST',
        data:{
          'updateTrans':1,
          'idprd':idprd,
          'ipm':ipm,
          'nm':nmprd,
          'hb':harga_beli,
          's':stok,
          'j':jml,
          'ja':ja
        },
        success:function(response){
          $('#nmproduk_1').val('');
          $('#stok_1').val('');
          $('#ukuran_1').val('');
          $('#harga_beli_1').val('');
          $('.jml_prdmsk').val('');
          $('.stok_awal').val('');
          $('#addmore').show();
          $('#save').show();
          $('#update').hide();
          $('#batal').hide();
          Metro.notify.create("Update data produk masuk sukses", "Informasi", {cls: "success"});
          console.log(response);
          var table = $('#example').DataTable();
          table.draw('page');
        }
    });
  });

  $('#batal').click(function(){
    $('.delete').show();
    $('#nmproduk_1').val('');
    $('#stok_1').val('');
    $('#ukuran_1').val('');
    $('#harga_beli_1').val('');
    $('.jml_prdmsk').val('');
    $('#id_detil_prdmsk').val('');
    $('#addmore').show();
    $('#save').show();
    $('#update').hide();
    $(this).hide();
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
            	  url: 'crud_prdmsk.php',
            	  type: 'GET',
            	  data: {
              	'delete': 1,
              	'delId': delId
                },
                success: function(response){
                  // Metro.notify.create("Delete Sukses", "Informasi", {cls: "success"});
                  console.log(response)
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



  // delete data
  // $(document).on('click', '#hapus', function(){
  // 	var id_produk = $(this).attr("data-id");
  // 	$clicked_btn = $(this);
  // 	$.ajax({
  // 	  url: '../../../application/admin/stok/crud_bahanbaku.php',
  // 	  type: 'GET',
  // 	  data: {
  //   	'delete': 1,
  //   	'id_produk': id_produk
  //     },
  //     success: function(response){
  //       Metro.notify.create("Delete Sukses", "Informasi", {cls: "success"});
  //       var table = $('#example').DataTable();
  //       table.draw('page');
  //     }
  // 	});
  // }); //delete data


}); //akhir doc ready

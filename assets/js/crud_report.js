$(document).ready(function(){

  var dataTable=$('#example').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax":{
          url:"fetch.php",
          type:"post"
      }
  });

  $('#cust').click(function() {
      $('.opt').show();
  });

  $('.aopt').click(function() {
      $('.opt').hide();
  });

  $('#reset').click(function() {
    var tgl1 = $('#tgl1').val('');
    var tgl2 = $('#tgl2').val('');
    $('#d1').val('');
    $('#d2').val('');
    $('.opt').hide();
    // $('#getLap').empty();
    $("#getLap tbody").empty();
  });


  $('#submit_btn').click(function() {
     if($('#1hr').is(':checked')) {
       $.ajax({
         url:"getLaporan.php",
         type:"post",
         dataType: 'JSON',
         data:{
           hr:1
         },
         success: function(response){

             var len = response.length;
             for(var i=0; i<len-1; i++){
               var nm = response[i].nm_bar;
               var msk = response[i].brg_msk;
               var hbm = response[i].hbm;
               var klr = response[i].brg_klr;
               var hbk = response[i].hbk;
               var stok = response[i].stok;
               var ns = response[i].ns;
               var tambah = "<tr class='data_lap'>" +
                             "<td align='center'>" + nm + "</td>" +
                             "<td align='center'>" + msk + "</td>" +
                             "<td align='center' bgcolor='#8FBC8F'>" + hbm + "</td>" +
                             "<td align='center'>" + klr + "</td>" +
                             "<td align='center' bgcolor='#8FBC8F'>" + hbk + "</td>" +
                             "<td align='center'>" + stok + "</td>" +
                             "<td align='center' bgcolor='#E6E6FA'>" + ns + "</td>" +
                           "</tr>";
                 $("#getLap tbody").append(tambah);
             }

             var tot = response.pop();
             var tjm = tot[Object.keys(tot)[0]];
             var thm = tot[Object.keys(tot)[1]];
             var tjk = tot[Object.keys(tot)[2]];
             var thk = tot[Object.keys(tot)[3]];
             var ts = tot[Object.keys(tot)[4]];
             var tns = tot[Object.keys(tot)[5]];

             var ht = "<tr>" +
                          "<td align='center'><b>Total</b></td>" +
                          "<td align='center'><b>" + tjm + "</b></td>" +
                          "<td align='center' bgcolor='yellow'><b>" + thm + "</b></td>" +
                          "<td align='center'><b>" + tjk + "</b></td>" +
                          "<td align='center' bgcolor='yellow'><b>" + thk + "</b></td>" +
                          "<td align='center'><b>" + ts + "</b></td>" +
                          "<td align='center' bgcolor='yellow'><b>" + tns + "</b></td>" +
                       "</tr>";
            $("#getLap tbody").append(ht);
            $(".fp").show();
            $("#o, #ox").val('hr');
         } //end success
       }); //end ajax
     }else if($('#1mg').is(':checked')) {
       $.ajax({
         url:"getLaporan.php",
         type:"post",
         dataType: 'JSON',
         data:{
           mg:1
         },
         success: function(response){

             var len = response.length;
             for(var i=0; i<len-1; i++){
               var nm = response[i].nm_bar;
               var msk = response[i].brg_msk;
               var hbm = response[i].hbm;
               var klr = response[i].brg_klr;
               var hbk = response[i].hbk;
               var stok = response[i].stok;
               var ns = response[i].ns;
               var tambah = "<tr class='data_lap'>" +
                             "<td align='center'>" + nm + "</td>" +
                             "<td align='center'>" + msk + "</td>" +
                             "<td align='center' bgcolor='#8FBC8F'>" + hbm + "</td>" +
                             "<td align='center'>" + klr + "</td>" +
                             "<td align='center' bgcolor='#8FBC8F'>" + hbk + "</td>" +
                             "<td align='center'>" + stok + "</td>" +
                             "<td align='center' bgcolor='#E6E6FA'>" + ns + "</td>" +
                           "</tr>";
                 $("#getLap tbody").append(tambah);
             }

             var tot = response.pop();
             var tjm = tot[Object.keys(tot)[0]];
             var thm = tot[Object.keys(tot)[1]];
             var tjk = tot[Object.keys(tot)[2]];
             var thk = tot[Object.keys(tot)[3]];
             var ts = tot[Object.keys(tot)[4]];
             var tns = tot[Object.keys(tot)[5]];

             var ht = "<tr>" +
                          "<td align='center'><b>Total</b></td>" +
                          "<td align='center'><b>" + tjm + "</b></td>" +
                          "<td align='center' bgcolor='yellow'><b>" + thm + "</b></td>" +
                          "<td align='center'><b>" + tjk + "</b></td>" +
                          "<td align='center' bgcolor='yellow'><b>" + thk + "</b></td>" +
                          "<td align='center'><b>" + ts + "</b></td>" +
                          "<td align='center' bgcolor='yellow'><b>" + tns + "</b></td>" +
                       "</tr>";
            $("#getLap tbody").append(ht);
            $(".fp").show();
            $("#o, #ox").val('mg');
         } //end success
       }); //end ajax
     }else if($('#1bln').is(':checked')) {
       $.ajax({
         url:"getLaporan.php",
         type:"post",
         dataType: 'JSON',
         data:{
           bln:1
         },
         success: function(response){

             var len = response.length;
             for(var i=0; i<len-1; i++){
               var nm = response[i].nm_bar;
               var msk = response[i].brg_msk;
               var hbm = response[i].hbm;
               var klr = response[i].brg_klr;
               var hbk = response[i].hbk;
               var stok = response[i].stok;
               var ns = response[i].ns;
               var tambah = "<tr class='data_lap'>" +
                             "<td align='center'>" + nm + "</td>" +
                             "<td align='center'>" + msk + "</td>" +
                             "<td align='center' bgcolor='#8FBC8F'>" + hbm + "</td>" +
                             "<td align='center'>" + klr + "</td>" +
                             "<td align='center' bgcolor='#8FBC8F'>" + hbk + "</td>" +
                             "<td align='center'>" + stok + "</td>" +
                             "<td align='center' bgcolor='#E6E6FA'>" + ns + "</td>" +
                           "</tr>";
                 $("#getLap tbody").append(tambah);
             }

             var tot = response.pop();
             var tjm = tot[Object.keys(tot)[0]];
             var thm = tot[Object.keys(tot)[1]];
             var tjk = tot[Object.keys(tot)[2]];
             var thk = tot[Object.keys(tot)[3]];
             var ts = tot[Object.keys(tot)[4]];
             var tns = tot[Object.keys(tot)[5]];

             var ht = "<tr>" +
                          "<td align='center'><b>Total</b></td>" +
                          "<td align='center'><b>" + tjm + "</b></td>" +
                          "<td align='center' bgcolor='yellow'><b>" + thm + "</b></td>" +
                          "<td align='center'><b>" + tjk + "</b></td>" +
                          "<td align='center' bgcolor='yellow'><b>" + thk + "</b></td>" +
                          "<td align='center'><b>" + ts + "</b></td>" +
                          "<td align='center' bgcolor='yellow'><b>" + tns + "</b></td>" +
                       "</tr>";
            $("#getLap tbody").append(ht);
            $(".fp").show();
            $("#o, #ox").val('bln');
         } //end success
       }); //end ajax
     }else if ($('#cust').is(':checked')) {
       var tgl1 = $('#tgl1').val();
       var tgl2 = $('#tgl2').val();
       $("#d1, #d1x").val(tgl1);
       $("#d2, #d2x").val(tgl2);
       $.ajax({
         url:"getLaporan.php",
         type:"post",
         dataType: 'JSON',
         data:{
           cust_tgl:1,
           tgl1:tgl1,
           tgl2:tgl2
         },
         success: function(response){

             var len = response.length;
             for(var i=0; i<len-1; i++){
               var nm = response[i].nm_bar;
               var msk = response[i].brg_msk;
               var hbm = response[i].hbm;
               var klr = response[i].brg_klr;
               var hbk = response[i].hbk;
               var stok = response[i].stok;
               var ns = response[i].ns;
               var tambah = "<tr class='data_lap'>" +
                             "<td align='center'>" + nm + "</td>" +
                             "<td align='center'>" + msk + "</td>" +
                             "<td align='center' bgcolor='#8FBC8F'>" + hbm + "</td>" +
                             "<td align='center'>" + klr + "</td>" +
                             "<td align='center' bgcolor='#8FBC8F'>" + hbk + "</td>" +
                             "<td align='center'>" + stok + "</td>" +
                             "<td align='center' bgcolor='#E6E6FA'>" + ns + "</td>" +
                           "</tr>";
                 $("#getLap tbody").append(tambah);
             }

             var tot = response.pop();
             var tjm = tot[Object.keys(tot)[0]];
             var thm = tot[Object.keys(tot)[1]];
             var tjk = tot[Object.keys(tot)[2]];
             var thk = tot[Object.keys(tot)[3]];
             var ts = tot[Object.keys(tot)[4]];
             var tns = tot[Object.keys(tot)[5]];

             var ht = "<tr>" +
                          "<td align='center'><b>Total</b></td>" +
                          "<td align='center'><b>" + tjm + "</b></td>" +
                          "<td align='center' bgcolor='yellow'><b>" + thm + "</b></td>" +
                          "<td align='center'><b>" + tjk + "</b></td>" +
                          "<td align='center' bgcolor='yellow'><b>" + thk + "</b></td>" +
                          "<td align='center'><b>" + ts + "</b></td>" +
                          "<td align='center' bgcolor='yellow'><b>" + tns + "</b></td>" +
                       "</tr>";
            $("#getLap tbody").append(ht);
            $(".fp").show();
            $("#o, #ox").val('cust');
         } //end success
       }); //end ajax
     }//end if
  });


});

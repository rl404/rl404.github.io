// Convert inputted key to upper case
function upperCaseF(a){
 setTimeout(function(){
  a.value = a.value.toUpperCase();
}, 1);
}

var loadFileOld = function(event) {
  var output = document.getElementById('outputold');
  output.src = URL.createObjectURL(event.target.files[0]);
};

var loadFileNew = function(event) {
  var output = document.getElementById('outputnew');
  output.src = URL.createObjectURL(event.target.files[0]);
};

// Submit form
function submitForm(a) {
  document.getElementById(a).submit();
}

function deletevave(a){
   $.ajax({
      type: 'POST',
      url:  'vavedelete.php',
      data: { vaveid: a }
   })
      .done( function (responseText) {
         $('#deletevavecontent').html(responseText);
      })

   $(".ui.basic.modal.deletemodal").modal('show');
}

// When ajax starts, show loading gif
$(document).ajaxStart(function(){
  $('#ajaxloading').show();
});

// When ajax ends, hide loading gif
$(document).ajaxStop(function(){
  $('#ajaxloading').hide();

  var x = document.getElementsByClassName("table"); 
  sorttable.makeSortable(x[0]);

  $('.resultdetail').popup();
});

// Jquery
$(document).ready(function() {

 // init_echarts();

   var calendarOpts = {
      type: 'date',
      formatter: {
        date: function (date, settings) {
             if (!date) return '';
             var day = date.getDate() + '';
             if (day.length < 2) {
               day = '0' + day;
              }
            var month = settings.text.monthsShort[date.getMonth()];
            var year = date.getFullYear();
            return year + '-' + month + '-' + day;
        }
     }

  };

  $('.calendarinput').calendar(calendarOpts);

  $('#3000list').DataTable({
       columnDefs: [
          { type: 'natural-nohtml', targets: 0 },
          { "targets": [ 2 ],
             "visible": false,
             "searchable": true },
          { "targets": [ 8 ],
             "visible": false,
             "searchable": true }
       ]
  });

  var $table = $('#vavelist');
  $table.floatThead({top: 43});

  $("#removeold").click(function () {
      $("#scanold").val("");

      var imageurl = document.getElementById('outputold').src;
      $.ajax({
        type: 'POST',
        url:  'deleteimage.php',
        data: { image: imageurl}
      })
      .done( function (responseText) {
        $('#ajaxold').html(responseText);
      })

      document.getElementById('outputold').src = "";
  });

  $("#removenew").click(function () {
      $("#scannew").val("");

      var imageurl = document.getElementById('outputnew').src;
      $.ajax({
        type: 'POST',
        url:  'deleteimage.php',
        data: { image: imageurl}
      })
      .done( function (responseText) {
        $('#ajaxnew').html(responseText);
      })

      document.getElementById('outputnew').src = "";
  });

  $(".container").on("change","#otherideatype", function(event){
    if($('#otherideatype').val() == "Other"){
         $('#otheridea').show();
      }else{
         $('#otheridea').hide();
      }
  });

  if($('#otherideatype').val() == "Other"){
    $('#otheridea').show();
  }else{
    $('#otheridea').hide();
  }

  $('.resultdetail').popup();

   // Jquery for checkbox (from Semantic-ui)
   $('.ui.checkbox').checkbox();

   // Jquery for message (from Semantic-ui)
   $(".container").on("click",".message .close", function(event){
    $(this).closest('.message').transition('fade');
  });

   
   // Send all data in table to pdf creator on export/export2convert.php
   $('#coverletterconvertbutton').click(function (event) {
      event.preventDefault();  // Do not run the default action
      var submittedsetdate = 0;
      var submittedreqdate = document.getElementById("reqdate").value; 
      var submittedsupplier = document.getElementById("suppliername").value;
      var submittedts = [];
      $("input[name='tsno']").each(function() {submittedts.push($(this).val());});
      var submittedrev = [];
      $("input[name='rev']").each(function() {submittedrev.push($(this).val());});       
      var submittedmodel = [];
      $("input[name='model']").each(function() {submittedmodel.push($(this).val());});
      var submittedpart = [];
      $("input[name='part']").each(function() {submittedpart.push($(this).val());});

      if ($('#senddate').is(':checked')) {
        submittedsetdate = 1;
     }

     $.ajax({
        type: 'POST',
        url:  'export2convert1.php',
        data: { supplier: submittedsupplier, 
          ts: submittedts, 
          rev: submittedrev,
          model: submittedmodel,
          part: submittedpart,
          setdate: submittedsetdate,
          reqdate: submittedreqdate }
       })
     .done( function (responseText) {
      $('#requestconvert').html(responseText);
   })
  });

   // Send all data in the form to pdf creator on export/exportmanual.php
   $(".container").on("click", "#coverlettercreatebutton", function(event){
      event.preventDefault();  // Do not run the default action
      var submittedsupp = document.getElementById("inputsupp").value;
      
      var submittedts = $("input[id='inputts']").map(function(){return $(this).val();}).get();
      var submittedrev = $("input[id='inputrev']").map(function(){return $(this).val();}).get();
      var submittedmodel = $("input[id='inputmodel']").map(function(){return $(this).val();}).get();
      var submittedpart = $("input[id='inputpart']").map(function(){return $(this).val();}).get();
      
      var submittedday = document.getElementById("reqday").value;
      var submittedmonth = document.getElementById("reqmonth").value;
      var submittedyear = document.getElementById("reqyear").value;

      $.ajax({
        type: 'POST',
        url:  'export2convert1.php',
        data: { ts: submittedts, rev: submittedrev, supplier: submittedsupp,
         model: submittedmodel, part: submittedpart, day: submittedday,
         month: submittedmonth, year: submittedyear }
      })
      .done( function (responseText) {
       $('#manualconvert').html(responseText);
    })
   });

   // Send all data in table to pdf creator on export/export2convert.php
   $(".container").on("keyup", "#graphyearbox", function(event){
      event.preventDefault();  // Do not run the default action
      var submittedgraphyear = document.getElementById("graphyearbox").value; 

      $.ajax({
        type: 'POST',
        url:  'homepage2.php',
        data: { graphyear: submittedgraphyear}
     })
      .done( function (responseText) {
       $('#homepagecontent').html(responseText);
    })
   });

   // download.php
   $(".container").on("change", "#model", function(event){
      event.preventDefault();  // Do not run the default action
      var submittedmodel = document.getElementById("model").value; 
      var submittedmonth = document.getElementById("downloadmonth").value; 
      var submittedyear = document.getElementById("downloadyear").value; 

      $.ajax({
        type: 'POST',
        url:  'downloadview.php',
        data: { model: submittedmodel, month: submittedmonth, year: submittedyear}
     })
      .done( function (responseText) {
       $('#downloadcontent').html(responseText);
    })
   });

   $(".container").on("change", "#downloadmonth", function(event){
      event.preventDefault();  // Do not run the default action
      var submittedmodel = document.getElementById("model").value; 
      var submittedmonth = document.getElementById("downloadmonth").value; 
      var submittedyear = document.getElementById("downloadyear").value; 

      $.ajax({
        type: 'POST',
        url:  'downloadview.php',
        data: { model: submittedmodel, month: submittedmonth, year: submittedyear}
     })
      .done( function (responseText) {
       $('#downloadcontent').html(responseText);
    })
   });

   $(".container").on("keyup", "#downloadyear", function(event){
      event.preventDefault();  // Do not run the default action
      var submittedmodel = document.getElementById("model").value; 
      var submittedmonth = document.getElementById("downloadmonth").value; 
      var submittedyear = document.getElementById("downloadyear").value; 

      $.ajax({
        type: 'POST',
        url:  'downloadview.php',
        data: { model: submittedmodel, month: submittedmonth, year: submittedyear}
     })
      .done( function (responseText) {
       $('#downloadcontent').html(responseText);
    })
   });

   // report/cost.php
   $(".container").on("change", "#costmonth", function(event){
      var submittedmonth = document.getElementById("costmonth").value; 
      var submittedyear = document.getElementById("costyear").value; 

      $.ajax({
        type: 'POST',
        url:  'costtable.php',
        data: { month: submittedmonth, year: submittedyear}
     })
      .done( function (responseText) {
       $('#reportcosttable').html(responseText);
    })
   });

   $(".container").on("keyup", "#costyear", function(event){
      var submittedmonth = document.getElementById("costmonth").value; 
      var submittedyear = document.getElementById("costyear").value; 

      $.ajax({
        type: 'POST',
        url:  'costtable.php',
        data: { month: submittedmonth, year: submittedyear}
     })
      .done( function (responseText) {
       $('#reportcosttable').html(responseText);
    })
   });

   // report/process.php
   $(".container").on("keyup", "#processmodel", function(event){
      var submittedmodel = document.getElementById("processmodel").value; 
      var submittedmonth = document.getElementById("processmonth").value; 
      var submittedyear = document.getElementById("processyear").value; 

      $.ajax({
        type: 'POST',
        url:  'processtable.php',
        data: { model: submittedmodel, month: submittedmonth, year: submittedyear}
     })
      .done( function (responseText) {
       $('#reportprocesstable').html(responseText);
    })
   });

   $(".container").on("change", "#processmonth", function(event){
      var submittedmodel = document.getElementById("processmodel").value; 
      var submittedmonth = document.getElementById("processmonth").value; 
      var submittedyear = document.getElementById("processyear").value; 

      $.ajax({
        type: 'POST',
        url:  'processtable.php',
        data: { model: submittedmodel, month: submittedmonth, year: submittedyear}
     })
      .done( function (responseText) {
       $('#reportprocesstable').html(responseText);
    })
   });

   $(".container").on("keyup", "#processyear", function(event){
      var submittedmodel = document.getElementById("processmodel").value; 
      var submittedmonth = document.getElementById("processmonth").value; 
      var submittedyear = document.getElementById("processyear").value; 

      $.ajax({
        type: 'POST',
        url:  'processtable.php',
        data: { model: submittedmodel,month: submittedmonth, year: submittedyear}
     })
      .done( function (responseText) {
       $('#reportprocesstable').html(responseText);
    })
   });

   // check manufacturer
   $(".container").on("keyup", "#manufacturerno", function(event){
    event.preventDefault(); 
    var submittedno = document.getElementById("manufacturerno").value; 

    if(submittedno){
      $.ajax({
        type: 'POST',
        url:  'checkmanufacturer.php',
        data: { manufacturerno: submittedno}
      })
      .done( function (responseText) {
       $('#checkmanufacturer').html(responseText);
     })
    }
  });


   // check proposer
   $(".container").on("keyup", "#proposerno", function(event){
    event.preventDefault(); 
    var submittedno = document.getElementById("proposerno").value; 

    if(submittedno){
      $.ajax({
        type: 'POST',
        url:  'checkproposer.php',
        data: {teardownno: submittedno}
      })
      .done( function (responseText) {
       $('#checkproposer').html(responseText);
     })
    }
  });

});

// Add new row to bottom of table
function addNewRow(){        
  new_elem = $("#emptyrow").clone().appendTo("#newrow").show();     
};



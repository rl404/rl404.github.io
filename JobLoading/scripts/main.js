function upperCaseF(a){
  setTimeout(function(){
    a.value = a.value.toUpperCase();
 }, 1);
}

function submitForm(a) {
   document.getElementById(a).submit();
}

function editJob(){
   $(".ui.modal.editmodal").modal('show');
}

function deleteJob(){
   $(".ui.basic.modal.deletemodal").modal('show');
}

function editProject(){ 
   $(".ui.modal.editmodal").modal('show');
}

function deleteProject(){
   $(".ui.basic.modal.deletemodal").modal('show');
}

function editStaff(){
   $(".ui.modal.editmodal").modal('show');
}

function deleteStaff(){
   $(".ui.basic.modal.deletemodal").modal('show');
}

function editDept(){
   $(".ui.modal.editmodal").modal('show');
}

function deleteDept(){
   $(".ui.basic.modal.deletemodal").modal('show');
}

$(document).ajaxStart(function(){
   $('#ajaxloading').show();
});

$(document).ajaxStop(function(){
   var x = document.getElementsByClassName("table"); 
   sorttable.makeSortable(x[0]);

   $('#ajaxloading').hide();
   $('.detailjobview').popup();
});

$(document).ready(function() {
   $('.ui.checkbox').checkbox(); 
   $('.ui.search.dropdown').dropdown(); 

   var $table = $('table');
   $table.floatThead({top: 43});

   $('#oldprojectcheck').change(function () {
      if (this.checked) {
       $('.oldproject').fadeIn('slow');
    } else {
      $('.oldproject').fadeOut('slow');
   }

});

   $('#olddeptcheck').change(function () {
      if (this.checked) {
       $('.olddept').fadeIn('slow');
    } else {
      $('.olddept').fadeOut('slow');
   }
});


   $(".container").on("click",".message .close", function(event){
      $(this).closest('.message').transition('fade');
   });

   $("#editjob").click(function(event){
      $(".ui.modal").modal('show');
   });

   // input/project.php
   $(".container").on("keyup",'#projectcode',function (event) {
      event.preventDefault();  // Do not run the default action
      var submittedproject = document.getElementById("projectcode").value;
      $.ajax({
         type: 'POST',
         url:  'projectchecker.php',
         data: { project: submittedproject }
      })
      .done( function (responseText) {
         $('#projectcheck').html(responseText);
      })
   });

    // input/staff.php
    $('#noreginput').keyup(function (event) {
      event.preventDefault();  // Do not run the default action
      var submittedstaff = document.getElementById("noreginput").value;
      $.ajax({
         type: 'POST',
         url:  'staffchecker.php',
         data: { staff: submittedstaff }
      })
      .done( function (responseText) {
         $('#staffcheck').html(responseText);
      })
   });

   // update/update.php
   $("#inputhourtable").on("change","#jobweek", function(event){
     event.preventDefault();  // Do not run the default action
     var submittedweek = document.getElementById("jobweek").value;
     var submittedmonth = document.getElementById("jobmonth").value;
     var submittedyear = document.getElementById("jobyear").value;
     $.ajax({
      type: 'POST',
      url:  'updatetable.php',
      data: { week: submittedweek, month: submittedmonth, year: submittedyear }
   })
     .done( function (responseText) {
      $('#inputhourtable').html(responseText);
   })
  });

   $("#inputhourtable").on("change","#jobmonth", function(event){
     event.preventDefault();  // Do not run the default action
     var submittedweek = document.getElementById("jobweek").value;
     var submittedmonth = document.getElementById("jobmonth").value;
     var submittedyear = document.getElementById("jobyear").value;
     $.ajax({
      type: 'POST',
      url:  'updatetable.php',
      data: { week: submittedweek, month: submittedmonth, year: submittedyear }
   })
     .done( function (responseText) {
      $('#inputhourtable').html(responseText);
   })
  });

   var delayTimer;
   $("#inputhourtable").on("keyup","#jobyear", function(event){
      event.preventDefault();  // Do not run the default action
      var submittedweek = document.getElementById("jobweek").value;
      var submittedmonth = document.getElementById("jobmonth").value;
      var submittedyear = document.getElementById("jobyear").value;

      clearTimeout(delayTimer);
      delayTimer = setTimeout(function() {         
         $.ajax({
            type: 'POST',
            url:  'updatetable.php',
            data: { week: submittedweek, month: submittedmonth, year: submittedyear }
         })
         .done( function (responseText) {
            $('#inputhourtable').html(responseText);
         })
      }, 500);       
   });

   // homepage.php
   $('#homepage').on("change","#jobmonth", function (event) {
      event.preventDefault();  // Do not run the default action
      var submittedmonth = document.getElementById("jobmonth").value;
      var submittedyear = document.getElementById("jobyear").value;
      $.ajax({
         type: 'POST',
         url:  'summary.php',
         data: { month: submittedmonth, year: submittedyear }
      })
      .done( function (responseText) {
         $('#summarytable').html(responseText);
      })
   });  

   $('#homepage').on("keyup","#jobyear", function (event) {
      event.preventDefault();  // Do not run the default action
      var submittedmonth = document.getElementById("jobmonth").value;
      var submittedyear = document.getElementById("jobyear").value;
      $.ajax({
         type: 'POST',
         url:  'summary.php',
         data: { month: submittedmonth, year: submittedyear }
      })
      .done( function (responseText) {
         $('#summarytable').html(responseText);
      })
   });

   // viewer/viewer.php
   $('#worklisttable').on("change","#jobweek", function (event) {
      event.preventDefault();  // Do not run the default action
      var submittedweek = document.getElementById("jobweek").value;
      var submittedmonth = document.getElementById("jobmonth").value;
      var submittedyear = document.getElementById("jobyear").value;
      $.ajax({
         type: 'POST',
         url:  'worklist.php',
         data: { week: submittedweek, month: submittedmonth, year: submittedyear }
      })
      .done( function (responseText) {
         $('#worklisttable').html(responseText);
      })
   });

   $('#worklisttable').on("change","#jobmonth", function (event) {
      event.preventDefault();  // Do not run the default action
      var submittedweek = document.getElementById("jobweek").value;
      var submittedmonth = document.getElementById("jobmonth").value;
      var submittedyear = document.getElementById("jobyear").value;
      $.ajax({
         type: 'POST',
         url:  'worklist.php',
         data: { week: submittedweek, month: submittedmonth, year: submittedyear }
      })
      .done( function (responseText) {
         $('#worklisttable').html(responseText);
      })
   });

   var delayTimer;
   $('#worklisttable').on("keyup","#jobyear", function (event) {
      event.preventDefault();  // Do not run the default action
      var submittedweek = document.getElementById("jobweek").value;
      var submittedmonth = document.getElementById("jobmonth").value;
      var submittedyear = document.getElementById("jobyear").value;

      clearTimeout(delayTimer);
      delayTimer = setTimeout(function() { 
         $.ajax({
            type: 'POST',
            url:  'worklist.php',
            data: { week: submittedweek, month: submittedmonth, year: submittedyear }
         })
         .done( function (responseText) {
            $('#worklisttable').html(responseText);
         })      
      }, 500); 
   });

   // report/project.php
   $('#homepage').on("input","#projectname", function (event) {
      event.preventDefault();  // Do not run the default action
      var submittedproject = document.getElementById("projectname").value;
      var submittedmonth = document.getElementById("projectmonth").value;
      var submittedyear = document.getElementById("projectyear").value;
      $.ajax({
         type: 'POST',
         url:  'projecttable.php',
         data: { project: submittedproject, month: submittedmonth, year: submittedyear }
      })
      .done( function (responseText) {
         $('#reportprojecttable').html(responseText);
      })
   });

   $('#homepage').on("change","#projectmonth", function (event) {
      event.preventDefault();  // Do not run the default action
      var submittedproject = document.getElementById("projectname").value;
      var submittedmonth = document.getElementById("projectmonth").value;
      var submittedyear = document.getElementById("projectyear").value;
      $.ajax({
         type: 'POST',
         url:  'projecttable.php',
         data: { project: submittedproject, month: submittedmonth, year: submittedyear }
      })
      .done( function (responseText) {
         $('#reportprojecttable').html(responseText);
      })
   });

   $('#homepage').on("keyup","#projectyear", function (event) {
      event.preventDefault();  // Do not run the default action
      var submittedproject = document.getElementById("projectname").value;
      var submittedmonth = document.getElementById("projectmonth").value;
      var submittedyear = document.getElementById("projectyear").value;
      $.ajax({
         type: 'POST',
         url:  'projecttable.php',
         data: { project: submittedproject, month: submittedmonth, year: submittedyear }
      })
      .done( function (responseText) {
         $('#reportprojecttable').html(responseText);
      })
   });

   // report/job.php
   $('#homepage').on("input","#jobname", function (event) {
      event.preventDefault();  // Do not run the default action
      var submittedjob = document.getElementById("jobname").value;
      var submittedmonth = document.getElementById("jobmonth").value;
      var submittedyear = document.getElementById("jobyear").value;
      $.ajax({
         type: 'POST',
         url:  'jobtable.php',
         data: { job: submittedjob, month: submittedmonth, year: submittedyear }
      })
      .done( function (responseText) {
         $('#reportjobtable').html(responseText);
      })
   });

   $('#homepage').on("change","#jobmonth", function (event) {
      event.preventDefault();  // Do not run the default action
      var submittedjob = document.getElementById("jobname").value;
      var submittedmonth = document.getElementById("jobmonth").value;
      var submittedyear = document.getElementById("jobyear").value;
      $.ajax({
         type: 'POST',
         url:  'jobtable.php',
         data: { job: submittedjob, month: submittedmonth, year: submittedyear }
      })
      .done( function (responseText) {
         $('#reportjobtable').html(responseText);
      })
   });

   $('#homepage').on("keyup","#jobyear", function (event) {
      event.preventDefault();  // Do not run the default action
      var submittedjob = document.getElementById("jobname").value;
      var submittedmonth = document.getElementById("jobmonth").value;
      var submittedyear = document.getElementById("jobyear").value;
      $.ajax({
         type: 'POST',
         url:  'jobtable.php',
         data: { job: submittedjob, month: submittedmonth, year: submittedyear }
      })
      .done( function (responseText) {
         $('#reportjobtable').html(responseText);
      })
   });

   // report/dept.php
   $('#homepage').on("input","#deptname", function (event) {
      event.preventDefault();  // Do not run the default action
      var submitteddept = document.getElementById("deptname").value;
      var submittedmonth = document.getElementById("deptmonth").value;
      var submittedyear = document.getElementById("deptyear").value;
      $.ajax({
         type: 'POST',
         url:  'depttable.php',
         data: { dept: submitteddept, month: submittedmonth, year: submittedyear }
      })
      .done( function (responseText) {
         $('#reportdepttable').html(responseText);
      })
   });

   $('#homepage').on("change","#deptmonth", function (event) {
      event.preventDefault();  // Do not run the default action
      var submitteddept = document.getElementById("deptname").value;
      var submittedmonth = document.getElementById("deptmonth").value;
      var submittedyear = document.getElementById("deptyear").value;
      $.ajax({
         type: 'POST',
         url:  'depttable.php',
         data: { dept: submitteddept, month: submittedmonth, year: submittedyear }
      })
      .done( function (responseText) {
         $('#reportdepttable').html(responseText);
      })
   });

   $('#homepage').on("keyup","#deptyear", function (event) {
      event.preventDefault();  // Do not run the default action
      var submitteddept = document.getElementById("deptname").value;
      var submittedmonth = document.getElementById("deptmonth").value;
      var submittedyear = document.getElementById("deptyear").value;
      $.ajax({
         type: 'POST',
         url:  'depttable.php',
         data: { dept: submitteddept, month: submittedmonth, year: submittedyear }
      })
      .done( function (responseText) {
         $('#reportdepttable').html(responseText);
      })
   });

   // report/staff.php
   $('#homepage').on("input","#deptname2", function (event) {
      event.preventDefault();  // Do not run the default action
      var submitteddept = document.getElementById("deptname2").value;
      var submittedmonth = document.getElementById("staffmonth").value;
      var submittedyear = document.getElementById("staffyear").value;
      $.ajax({
         type: 'POST',
         url:  'stafftable.php',
         data: { dept: submitteddept, month: submittedmonth, year: submittedyear }
      })
      .done( function (responseText) {
         $('#reportstafftable').html(responseText);
      })
   });

   $('#homepage').on("change","#staffmonth", function (event) {
      event.preventDefault();  // Do not run the default action
      var submitteddept = document.getElementById("deptname2").value;
      var submittedmonth = document.getElementById("staffmonth").value;
      var submittedyear = document.getElementById("staffyear").value;
      $.ajax({
         type: 'POST',
         url:  'stafftable.php',
         data: { dept: submitteddept, month: submittedmonth, year: submittedyear }
      })
      .done( function (responseText) {
         $('#reportstafftable').html(responseText);
      })
   });

   $('#homepage').on("keyup","#staffyear", function (event) {
      event.preventDefault();  // Do not run the default action
      var submitteddept = document.getElementById("deptname2").value;
      var submittedmonth = document.getElementById("staffmonth").value;
      var submittedyear = document.getElementById("staffyear").value;
      $.ajax({
         type: 'POST',
         url:  'stafftable.php',
         data: { dept: submitteddept, month: submittedmonth, year: submittedyear }
      })
      .done( function (responseText) {
         $('#reportstafftable').html(responseText);
      })
   });

});


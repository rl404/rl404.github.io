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
   $('#ajaxloading').hide();
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
});


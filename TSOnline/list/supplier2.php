<html>
	<?php include "../header.php" ?>
	<div class="ui container">
		<h1 class='ui center aligned header' id='titleheader1'>SUPPLIER x PART NO x TS NO</h1>
		<div class="ui divider"></div>
		<div class='ui grid'>
			<div class='three column row'>
				<div class='column'>

					<!-- Search box + title -->
					<div class='ui form'>
						<div class="inline fields">		
							<div class='field'><label id='titleheader2'>Supplier Name</label></div>		
						    <!-- <div class='inline fields'> -->
							    <div class='field'>
							    	<div class='ui icon input'>
									    <input type="text" id='supplierinputsearch'>
									    <i class="search link icon"></i>
									</div>
								</div>
								<!-- <div class='field'>
									<a href='datasupplierdownload.php' class='ui inverted green labeled icon button'>
										<i class='link file excel outline icon'></i>
										Download
									</a>
								</div> -->
							<!-- </div> -->
						</div>					
					</div>

					<!-- Supplier list (on the left of the page) -->
					<div id='supplierresultsearch'>
						<?php include "suppliersearch2.php" ?>
					</div>

				</div>

				<div class='column'>
					<div id='supplierxpartnoresult'>

					</div>
				</div>
				<div class='column'>
					<div id='partnoxtsresult'>

					</div>
				</div>
			</div>
		</div>	
	</div>

	<div class="ui divider"></div>

	<!-- Modal for edit dept -->
	<div class="ui modal editmodal">
	  	<div class="header modalform" id='titleheader2'>DELIVER UPDATE</div>
	  	<div class="content modalform" id='editsendcontent'></div>
	  	<div class="actions modalform">		   
		    <div class="ui green button" onclick="submitForm2();">Update</div>
		    <div class="ui red cancel button">Cancel</div>
  		</div>
	</div>
</body>
</html>
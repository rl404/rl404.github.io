<?php
	echo "
		<div class='ui two steps'>
		  <div class='active step'>
		    <i class='search icon' id='titleheader2'></i>
		    <div class='content'>
		      <div class='title' id='titleheader2'>Search Request</div>
		    </div>
		  </div>
		  <div class='disabled step'>
		    <i class='file icon'></i>
		    <div class='content'>
		      <div class='title'>Convert to Cover Letter</div>
		    </div>
		  </div>
		</div>

		<div class='ui grid'>
			<div class='three column row'>
				<div class='column'>
					<div class='ui form'>
						<div class='inline fields'>		
							<div class='field'><label id='titleheader2'>Supplier Name</label></div>		
						    <div class='field'>
						    	<div class='ui icon input'>
								    <input type='text' id='exportsuppliersearchinput'>
								    <i class='search link icon'></i>
								</div>
							</div>
						</div>					
					</div>
					<div id='requestsearch'>";

					include "export1search1.php";

		echo "		</div>
				</div>
				<div class='column'>
					<div id='requestsearch1'></div>
				</div>
				<div class='column'>
					<div id='requestsearch2'></div>
				</div>
			</div>
		</div>";

?>
<!DOCTYPE html>
<?php
	$conn = mysqli_connect("localhost","jobloading_admin","toyota123","job_loading");

	// Check connection
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
?>
<html lang="en" >
<head>
	<title>EDTIMS</title>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
	<script type="text/javascript" src="js/jquery.js"></script>
	<!-- Edit Below -->		
	<link rel="stylesheet" type="text/css" href="css/semantic.min.css">		
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/semantic.min.js"></script>
	<script src="js/main.js"></script>	
</head>
<body>	  
	<div class='ui segment' style='background-color: rgba(107, 122, 143, 0.5);' id='superheader'>
		<h1 class='ui inverted center aligned header' id='supertitle'>
			ENGINEERING DIVISION <br />
			TECHNICAL EDUCATION MATERIAL
		</h1>
		<a href='http://10.16.22.11/EDTIMS/index.html'><img src="images/logo.png" id='toyotalogo' alt='toyota'></a>
	</div>

	<div class='ui container'>
		<div class="ui five column grid">
			<?php
				$selectSql = "SELECT * FROM edportal order by dateAdded";
				$selectResult = $conn->query($selectSql);
				while($row = mysqli_fetch_assoc($selectResult)) {
					echo "
						<div class='column'>
							<i class='large link yellow edit icon materialedit' onclick='editDoc(&quot;$row[id]&quot;);' style='display:none;position:absolute;left:-10px;top:20px;'></i>
							<i class='large link red remove icon materialedit' onclick='deleteDoc(&quot;$row[id]&quot;);' style='display:none;position:absolute;left:-12px;top:40px;'></i>
							
							<a onclick='window.open(&quot;files/$row[docName].pdf&quot;, 
								&quot;newwindow&quot;, &quot;width=800,height=500&quot;);return false;'>
								<div class='ui segment docsegment'>
									<img class='ui centered image' src='cover/$row[docName].png'>
									<h3 class='ui dividing header'>$row[docName]</h3>
									$row[docDesc]
								</div>
							</a>
						</div>";
				}
			?>

			<div class='column materialedit' style='display: none;'>
				<div class='ui compact segment'>
					<button class='ui inverted blue button' onclick="addNewDoc();">Add New Material</button>
				</div>
			</div>		    		
		</div>
	</div>
	
	<div class="ui modal editmodal">
		<i class="close icon"></i>
		<div class="header">
			New Material
		</div>
		<div class="content">
			<div class='ui two column grid' id='editdoccontent'>				
				<?php include "modal.php"; ?>
			</div>
		</div>
		<div class="actions">
			<div class="ui red cancel button">
				Cancel
			</div>
			<button class="ui green button" onclick="submitForm('newmaterialform');">
				Submit
			</button>
		</div>
	</div>

	<div class="ui basic modal deletemodal">
		<div class="ui icon header">
			Are you sure to delete this material?
		</div>
		<div class="content" id='deletedoccontent'>
			<?php include "modaldelete.php"; ?>	
		</div>
		<div class="actions">
			<div class="ui red basic cancel inverted button">				
				No
			</div>
			<div class="ui green ok inverted button"  onclick="submitForm('deletematerialform');">
				Yes
			</div>
		</div>
	</div>

	<script>
		var letter = {e: 69};
		var visible = false;

	 	$(document).ready(function() {
	        $("body").keydown(function(event) {
	            if(!visible && event.shiftKey && event.which === letter.e) {
		            visible = true;
		            $(".materialedit").slideDown("fast");
		        } else if(visible && event.shiftKey && event.which === letter.e) {
		            visible = false;
		            $(".materialedit").slideUp("fast");
		        }
	        });
	    });
	</script>
</body>
</html>
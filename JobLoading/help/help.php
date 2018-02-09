<html>
	<?php 
	if(session_id() == '') {
	    session_start();
	}
	include "../header.php"; ?>

	<div class="ui container">
		<h2 class='ui right floated header' >
			<a href='howto.pdf' id='titleheader2' target="_blank">
				<i class='file pdf outline icon'></i>
			SOP</a>
		</h2>
		<h1 class='ui center aligned dividing header' id='titleheader'>
			FAQ
		</h1>		
		<h4 class="ui header" id='titleheader'>
		  <div id='titleheader2'>
		  Q: How do I reveal input suggestion?<br></div>
		  A: For Internet Explorer, left-click one time the input text box. For Mozilla Firefox, left-click two times the input text box.
		  You can reveal the suggestion by typing the keyword too. Not all input has suggestion though. Try it here.
		</h4>

		<div class='ui input'>
			<input type='text' list='helplist' placeholder='Click it.'>
		</div>
		<datalist id='helplist'>
			<option>Good</option>
			<option>Job</option>
			<option>I</option>
			<option>Know</option>
			<option>You</option>
			<option>Can</option>
			<option>Do</option>
			<option>It</option>
		</datalist>

		<h4 class="ui header" id='titleheader'>
		  <div id='titleheader2'>
		  Q: I want to update my Job Hour but my job name is not in the list. What should I do?<br></div>
		  A: The list shows only the job from your department for the convenience or maybe your job is inside one of your department job description. 
		</h4>

		<h4 class="ui header" id='titleheader'>
		  <div id='titleheader2'>
		  Q: What if it is still not there?<br></div>
		  A: Please ask and discuss with your manager to add it to the system.
		</h4>

		<h4 class="ui header" id='titleheader'>
		  <div id='titleheader2'>
		  Q: What if my project code is not in the list?<br></div>
		  A: Please ask and discuss with EA members to add it to the system. For easier to manage, only EA members can add and edit the project list. 
		</h4>

		<?php if($_SESSION['titlerank']>=3){ ?>
		
		<h4 class="ui header" id='titleheader'>
		  <div id='titleheader2'>
		  Q: When I'm adding a new job, my department code is not in the list.<br></div>
		  A: Please go to <a href='../input/dept.php'>this</a> page to add a new one.
		</h4>	

		<?php } ?>

		<h4 class="ui header" id='titleheader'>
		  <div id='titleheader2'>
		  Q: How about the job title?<br></div>
		  A: There are only 3 choices for it. Dept. Head, Sect. Head, and Staff. Please choose only one of these or you will destroy the system. (Just kidding)
		</h4>

		<h4 class="ui header" id='titleheader'>
		  <div id='titleheader2'>
		  Q: What is the password for the new account?<br></div>
		  A: The default password is 1234. Let the account owner to change it later in the <a href='../setting/setting.php'>setting</a> page.
		</h4>

		<h4 class="ui header" id='titleheader'>
		  <div id='titleheader2'>
		  Q: Can I sort the data in the table?<br></div>
		  A: Yes, you can (except the job hour table one). Just click the table header and that's it. Try it here.
		</h4>

		<table class='ui center aligned selectable compact sortable table'>
			<tr><th id='tableheader'>header1</th><th id='tableheader'>header2</th><th id='tableheader'>header3</th></tr>
			<tr><td>1.</td><td>b</td><td>z</td></tr>
			<tr><td>2.</td><td>a</td><td>x</td></tr>
			<tr><td>3.</td><td>c</td><td>y</td></tr>
		</table>

		<h4 class="ui header" id='titleheader'>
		  <div id='titleheader2'>
		  Q: Sometimes, the table header does not follow when I scroll down.<br></div>
		  A: Yes, sometimes that bug happens. Don't worry about it.
		</h4>

		<h4 class="ui header" id='titleheader'>
		  <div id='titleheader2'>
		  Q: In the viewer page, after I sort the table, I can't see the <span data-tooltip='This is what we call data tooltip.' style="color:blue;">data tooltip</span> anymore.<br></div>
		  A: That's also a bug. Please refresh the page and try not to sort the table. :(
		</h4>

		<h4 class="ui header" id='titleheader'>
		  <div id='titleheader2'>
		  Q: I inputted the wrong job name or project code. How to delete it?<br></div>
		  A: Write 0 in the already inputted job hour, click update, then click delete empty job hour button. And... it's gone.
		</h4>

		<h4 class="ui header" id='titleheader'>
		  <div id='titleheader2'>
		  Q: I inputted the wrong job hour. How to delete it?<br></div>
		  A: Write 0 in the already inputted job hour, click update, then click delete empty job hour button.
		</h4>

		<h4 class="ui header" id='titleheader'>
		  <div id='titleheader2'>
		  Q: The graph does not show up on the report page.<br></div>
		  A: You must be connected to the internet to show the graph because it's using <a href='https://developers.google.com/chart/interactive/docs/gallery' target="_blank">Google Chart</a>.
		</h4>

		<h4 class="ui header" id='titleheader'>
		  <div id='titleheader2'>
		  Q: In the report by staff, the hours are red? What happen?<br></div>
		  A: That means the actual hour does not (yet) reach the ideal hour. Please work harder...
		</h4>

		<h4 class="ui header" id='titleheader'>
		  <div id='titleheader2'>
		  Q: Why I can't do this or that?<br></div>
		  A: The system does not have a feature for it. You can suggest the feature to the developer though.
		</h4>

		<h4 class="ui header" id='titleheader'>
		  <div id='titleheader2'>
		  Q: I don't like the website design and too hard to use.<br></div>
		  A: That's not even a question. I try my best to make it simple but my best is still not enough (for you). Sorry...
		</h4>

		<h4 class='ui center aligned header'>
		<?php
			$a = rand(0,2);
			switch($a){
				case "0": echo '"Don\'t believe in yourself. Believe in others who believe in you."'; break;
				case "1": echo '"Never give up. Once you give up, you lose everything."'; break;
				case "2": echo '"Become a person who others can rely on."'; break;
				
				default: echo '"We are human. We are allowed to make mistake."';
			}

		?>
		</h4>
		<div class='ui divider'></div>
	</div>
</body>
</html>
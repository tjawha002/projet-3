<div class="col-4" style="border: 1px solid blackk">
		<h5><?php echo $i['_source']['aspect'] ?></h5>
		<a href='../jsonFiles/dataset/<?php echo "{$i['_source']['patentID']}-D0000{$x}png"; ?>' target='_blank'>
			<img src='../jsonFiles/dataset/<?php echo "{$i['_source']['patentID']}-D0000{$x}.png"; ?>'  width='50%'  />
			
			
			
		</a>
		
		

		<p>
		<?php
		// echo $dd; // description
		echo $i['_source']['origreftext']; // description
		?>
			
		</p>
		<button type="button" class="btn btn-sm save" title="Save to profile" data-user_email="<?php echo $_SESSION['username'] ?>" data-source='<?php echo json_encode($i['_source']) ?>'>
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="blue" width="18px" height="18px"><path d="M0 0h24v24H0z" fill="none"/><path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/></svg>
		</button>
		<a href="#" class="btn btn-sm btn-primary show-desc"
			data-image='../jsonFiles/dataset/<?php echo "{$i['_source']['patentID']}-D0000{$x}.png"; ?>'
			data-aspect='<?php echo $aspect ?>'
			data-origreftext='<?php echo $i['_source']['origreftext'] ?>'
			data-dd='<?php echo $i['_source']['description'] ?>'
		>Show More</a>
		
	</div>
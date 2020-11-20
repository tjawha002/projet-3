<?php
	include "db_connection.php";
	
	$search = isset($_POST['Search']) ? mysqli_real_escape_string($db,$_POST['Search']) : "";
	$sName = isset($_POST['Rname']) ? mysqli_real_escape_string($db,$_POST['Rname']) : "";
	$sCountry = isset($_POST['Rcountry']) ? mysqli_real_escape_string($db,$_POST['Rcountry']) : "";
	$sType = isset($_POST['Rtype']) ? mysqli_real_escape_string($db,$_POST['Rtype']) : "";
	$sRate = isset($_POST['Rrate']) ? mysqli_real_escape_string($db,$_POST['Rrate']) : "";
	
	$limit = 50;
	$page = '';
	$output = "";
	
	if(isset($_POST['page'])){
		$page = $_POST['page'];
	}
	else{
		$page = 1;
	}
	
	$start = ($page-1)*$limit;
	
	if($search !=''){
		$query = mysqli_query($db,"Select * from restaurants where r_name like '%$search%' or r_address like '%$search%' or r_country like '%$search%' 
		or r_rate like '%$search%' or r_type like '%$search%' limit $start, $limit");
		$query2 = mysqli_query($db,"Select * from restaurants where r_name like '%$search%' or r_address like '%$search%' or r_country like '%$search%' 
		or r_rate like '%$search%' or r_type like '%$search%'" );
	}
	else if($search == '' && $sName == '' && $sCountry == '' && $sType == '' && $sRate == ''){
		//$query = mysqli_query($db,"Select * from restaurants limit $start, $limit");
		//$query2 = mysqli_query($db,"Select * from restaurants");
		echo"<div class='alert alert-danger'>Opps!! You do not insert any search text</div>";
		return;
	}
	else{
		if($sName != '' && $sCountry != '' && $sType != '' && $sRate != ''){
			$query = mysqli_query($db,"Select * from restaurants where r_name like '%$sName%' and r_country like '%$sCountry%' and r_type like '%$sType%' and ROUND(r_rate,0) = '$sRate' limit $start, $limit");
			$query2 = mysqli_query($db,"Select * from restaurants where r_name like '%$sName%' and r_country like '%$sCountry%' and r_type like '%$sType%' and ROUND(r_rate,0) = '$sRate'");
		}

		else if($sName != '' && $sCountry != '' && $sType != ''){
			$query = mysqli_query($db,"Select * from restaurants where r_name like '%$sName%' and r_country like '%$sCountry%' and r_type like '%$sType%' limit $start, $limit");
			$query2 = mysqli_query($db,"Select * from restaurants where r_name like '%$sName%' and r_country like '%$sCountry%' and r_type like '%$sType%'");
		}
		
		else if($sName != '' && $sCountry != '' && $sRate != ''){
			$query = mysqli_query($db,"Select * from restaurants where r_name like '%$sName%' and ROUND(r_rate,0) = '$sRate' and r_country like '%$sCountry%' limit $start, $limit");
			$query2 = mysqli_query($db,"Select * from restaurants where r_name like '%$sName%' and ROUND(r_rate,0) = '$sRate' and r_country like '%$sCountry%'");
		}

		else if($sName != '' && $sType != '' && $sRate != ''){
			$query = mysqli_query($db,"Select * from restaurants where r_name like '%$sName%' and ROUND(r_rate,0) = '$sRate' and r_type like '%$sType%' limit $start, $limit");
			$query2 = mysqli_query($db,"Select * from restaurants where r_name like '%$sName%' and ROUND(r_rate,0) = '$sRate' and r_type like '%$sType%'");
		}

		else if($sCountry != '' && $sType != '' && $sRate){
			$query = mysqli_query($db,"Select * from restaurants where r_country like '%$sCountry%' and r_type like '%$sType%' and ROUND(r_rate,0) = '$sRate' limit $start, $limit");
			$query2 = mysqli_query($db,"Select * from restaurants where r_country like '%$sCountry%' and r_type like '%$sType%' and ROUND(r_rate,0) = '$sRate'");
		}
		//*************************************************************************
		else if($sName != '' && $sCountry != ''){
			$query = mysqli_query($db,"Select * from restaurants where r_name like '%$sName%' and r_country like '%$sCountry%' limit $start, $limit");
			$query2 = mysqli_query($db,"Select * from restaurants where r_name like '%$sName%' and r_country like '%$sCountry%'");
		}

		else if($sName != '' && $sType != ''){
			$query = mysqli_query($db,"Select * from restaurants where r_name like '%$sName%' and r_type like '%$sType%' limit $start, $limit");
			$query2 = mysqli_query($db,"Select * from restaurants where r_name like '%$sName%' and r_type like '%$sType%'");
		}

		else if($sName != '' && $sRate != ''){
			$query = mysqli_query($db,"Select * from restaurants where r_name like '%$sName%' and ROUND(r_rate,0) = '$sRate' limit $start, $limit");
			$query2 = mysqli_query($db,"Select * from restaurants where r_name like '%$sName%' and ROUND(r_rate,0) = '$sRate'");
		}

		else if($sCountry != '' && $sType != ''){
			$query = mysqli_query($db,"Select * from restaurants where r_country like '%$sCountry%' and r_type like '%$sType%' limit $start, $limit");
			$query2 = mysqli_query($db,"Select * from restaurants where r_country like '%$sCountry%' and r_type like '%$sType%'");
		}

		else if($sCountry != '' && $sRate != ''){
			$query = mysqli_query($db,"Select * from restaurants where r_country like '%$sCountry%' and ROUND(r_rate,0) = '$sRate' limit $start, $limit");
			$query2 = mysqli_query($db,"Select * from restaurants where r_country like '%$sCountry%' and ROUND(r_rate,0) = '$sRate'");
		}

		else if($sType != '' && $sRate != ''){
			$query = mysqli_query($db,"Select * from restaurants where r_type like '%$sType%' and ROUND(r_rate,0) = '$sRate' limit $start, $limit");
			$query2 = mysqli_query($db,"Select * from restaurants where r_type like '%$sType%' and ROUND(r_rate,0) = '$sRate'");
		}
		//****************************************************************************
		else if($sName != ''){
			$query = mysqli_query($db,"Select * from restaurants where r_name like '%$sName%' limit $start, $limit");
			$query2 = mysqli_query($db,"Select * from restaurants where r_name like '%$sName%'");
		}

		else if($sCountry != ''){
			$query = mysqli_query($db,"Select * from restaurants where r_country like '%$sCountry%' limit $start, $limit");
			$query2 = mysqli_query($db,"Select * from restaurants where r_country like '%$sCountry%'");
		}

		else if($sType != ''){
			$query = mysqli_query($db,"Select * from restaurants where r_type like '%$sType%' limit $start, $limit");
			$query2 = mysqli_query($db,"Select * from restaurants where r_type like '%$sType%'");
		}

		else if($sRate != ''){
			$query = mysqli_query($db,"Select * from restaurants where ROUND(r_rate,0) = '$sRate' limit $start, $limit");
			$query2 = mysqli_query($db,"Select * from restaurants where ROUND(r_rate,0) = '$sRate'");
		}
	}
	
	
	if(mysqli_num_rows($query) > 0){
		$count = mysqli_num_rows($query2);			
		$output .="<center>
			<nav aria-label='Page navigation'>
				<ul class='pagination'>";
		$total_pages = ceil($count/$limit);
		$previews = $page-1;
		$next = $page+1;
		if($total_pages <=20){
			if($page > 1){
				$output .="<li class='page-item'>
							<span class='page-link pagination_link' style='cursor:pointer;' id='$previews' aria-label='Previous'>
								<span aria-hidden='true'>&laquo; Previous</span>
							</span>
						</li>";
			}
			
			for($j=1; $j <= $total_pages; $j++){
				$output .="<li class='page-item'>
							<span class='page-link pagination_link' style='cursor:pointer;' id='$j'>$j</span>
						</li>";
			}
			
			if($j > $page && $page != $total_pages){
				$output .="<li class='page-item'>
							<span class='page-link pagination_link' style='cursor:pointer;' id='$next' aria-label='Next'>
								<span aria-hidden='true'>Next &raquo;</span>
							</span>
						</li>";
			}
		}
		else{
			if($total_pages > 1){
				$output .="<li class='page-item'>
					<span class='page-link pagination_link' style='cursor:pointer;' id='$previews' aria-label='Previous'>
						<span aria-hidden='true'>&laquo; Previous</span>
					</span>
				</li>
				<li class='page-item'>
					<span class='page-link pagination_link' style='cursor:pointer;' id='1'>First</span>
				</li>
				<li class='page-item'>
					<span class='page-link pagination_link' style='cursor:pointer;' id='$total_pages'>Last</span>
				</li>
				<li class='page-item'>
					<span class='page-link pagination_link' style='cursor:pointer;' id='$next' aria-label='Next'>
						<span aria-hidden='true'>Next &raquo;</span>
					</span>
				</li>";
			}
		}
		
		
		$output .= "</ul>
				</nav></center>";
				
		$output .= "<div class='row'>
			<div class='col-6'>
				<p class='text-secondary'>About $count results</p>
			</div>
			<div class='col-6 text-right'>
				<p class='text-secondary'>Page $page of $total_pages ($limit) records per page</p>
			</div>
		</div>";
		
		while($row = mysqli_fetch_array($query)){
			$id = $row['r_id'];
			$Rname = $row['r_name'];
			$Rimage = $row['image'];
			$Raddress = $row['r_address'];
			$Ravg = $row['r_avg'];
			$Rcurrency = $row['r_currency'];
			$Rcountry = $row['r_country'];
			$Rtype = $row['r_type'];
			$Rate = round($row['r_rate']);
			$output .= "<div class='alert alert-secondary py-2'>
					<img src='$Rimage' width='100' height='100' class='img-thumbnail' />
					<b> <a href='restaurantInfo.php?restaurant=$id'>$Rname</a></b><br>
					<span>$Raddress </span><br>
					<span>$Rcountry</span><br>
					<span>$Rtype</span><br>
					<span>";
				for($i=1; $i<=$Rate; $i++)
					$output .= "⭐";
			$output .="</span>
					</div>";
		}
	}
	else{
		$output .= "<div class='alert alert-secondary py-2'>There is no such record match your search criteria</div>";
	}
	
	echo $output;
	
?>
<?php
session_start();
// Report all errors except E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);

if(isset($_SESSION['username'])){
	$email = $_SESSION['username'];
	$name = substr($_SESSION['fname'], 0, 1) . substr($_SESSION['lname'], 0, 1);
	$name = "<div class='login-icon'>$name</div>";
	$profile = "<a href='profile.php?email=$email'>Profile</a>";
	//$adminPage = "<a href='admin_board.php'>Add New Restaurant</a>";
	$logout = "<a href='logout.php' class='text-danger'>Logout</a>";
}
else{
	header('Location: index.php');
}
?>

<html>
	<head>
	
	

		<title>Search Engine</title>
		  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>VisImageNavigator</title>

    <!-- Bootstrap core CSS -->
    <link href="public/stylesheets/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles -->
    <link href="public/stylesheets/bio_style.css" rel="stylesheet">
    <link href="public/stylesheets/myPagination.css" rel="stylesheet">
    <link rel="stylesheet" href="public/stylesheets/ion.rangeSlider.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
	</head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="js/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<style type="text/css">
		.login-icon {
			background-color: #0275d8;
			color: white;
			font-weight: bold;
			font-size: 20px;
			padding: 5px;
			text-align: center;
			border-radius: 20px;

		}
		.highlighted {
			background-color: yellow;
		}
		
	</style>

	<body>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		  <a class="navbar-brand" href="add.php">add</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>
		  <div class="collapse navbar-collapse" id="navbarNavDropdown">
			<ul class="navbar-nav">
			  <li class="nav-item active">
				<a class="nav-link" href="index.php">Home</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="profile.php">Profile</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="search.php">Search</a>
			  </li>
			</ul>
		  </div>
		</nav>
	
		<div class="container">
		<div class="row py-5">
			<div class="col-10 mx-auto">
			<form action="search.php" method="get">
				<div class="row">
						<div class="col-10">
							<input type="text" name="q" value="<?php echo isset($_REQUEST['q']) ? $_REQUEST['q']: '' ?>" id="search" placeholder="search at josndata" class="form-control" required> 
						</div>
						<div class="col-2">
							<button type="submit" class="btn btn-primary" name="searchButton">Search</button><br>
						</div>

			
					</div>
		
				<div  style="background: #F8F9F9; border-radius: 5px;">
					
				
						<div class="row py-2">
							<div class="col-6">
							
							
							
								
							
								<label>Search in datajosn by:</label>
								<select " name="s" style=" height: 25px;cursor: pointer; " id="s">
								
								<option value="1" <?php echo isset($_REQUEST) && $_REQUEST['s'] == 1 ? 'selected': '' ?> >Description</option>
								<option value="2" <?php echo isset($_REQUEST) && $_REQUEST['s'] == 2 ? 'selected': '' ?> >Figure ID</option>
								
								
								</select>


		 
						
							</div>

							
							
						</div>

						
					</form>
					<?php if($_REQUEST['q']) { ?>
						<h5>Showing results for <strong><?php echo htmlspecialchars($_REQUEST['q']) ?></strong></h5>
					<?php } ?>
				</div>
			</div>



		
<div class='col-10 mx-auto'>
<div class="row">
<?php
require 'vendor/autoload.php';

use Elasticsearch\ClientBuilder;

$client = ClientBuilder::create() // (2)
->build(); // (3)

if(isset($_REQUEST['searchButton'])) { // (4)

$q = $_REQUEST['q'];

$searchby=$_REQUEST['s'];



$q=preg_replace("/<|>/i", "",$q);


if($searchby=="1")
{
//-- Change Here -->
$query = $client->search([
'body' => [
	'query' => [ // (5)
		'bool' => [
			'should' => [
				'match' => [
					'description'  => $q
				],
			]
		]
	]
]
]);


}

if($searchby=="2")
{
//-- Change Here -->
$query = $client->search([
'body' => [
'query' => [ // (5)
'bool' => [
'should' => [
'match' => ['figid'  => $q],



]
]
]
]
]);

}


if($query['hits']['total'] >=1 ) { // (6)
$results = $query['hits']['hits'];

// pagiantion on results array
$results_total = count($results);
////echo '<pre>';
//var_dump($query);
//echo '</pre>';
//die();
$count = isset($_REQUEST['count']) ? $_REQUEST['count']: 3;
$page = isset($_REQUEST['page']) ? $_REQUEST['page']: 1;
$pages_count = ceil(count($results) / $count); // round up to get total pages

$from = $count * ($page-1);
$results = array_slice($results, $from, $count);

// highlight the items in search
$results = array_map(function($result) use ($q) {
	$repalce = "<span class=\"highlighted\">{$q}</span>";
	$result['_source']['description'] = ucfirst(str_replace(strtolower($q), $repalce, strtolower($result['_source']['description'])));
	// var_dump($result['_source']['description']); 
	// die();
	$result['_source']['figid'] = ucfirst(str_replace(strtolower($q), $repalce, strtolower($result['_source']['figid'])));
	return $result;
}, $results);


$x = 0;
 foreach ($results as $i)
 {
	 
	
	 


$qq=$i['_source']['patentID'];
$dd=$i['_source']['description'];

?>



	<div class="col-4" style="border: 1px solid blackk">
		<h5><?php echo ucfirst($i['_source']['aspect']) ?></h5>
		
			<img src='../jsonFiles/dataset/<?php echo "{$i['_source']['patentID']}-D0000{$x}.png"; ?>'  width='50%'  />
		
		

		<p class="muted-text">
		<?php
		echo $i['_source']['origreftext']; // title
		?>
			
		</p>
		<p>
		<?php
		// echo $dd; // description
		echo $i['_source']['description']; // description
		?>
			
		</p>
		<button type="button" class="btn btn-sm save" title="Save to profile" data-user_email="<?php echo $_SESSION['username'] ?>" data-source='<?php echo json_encode($i['_source']) ?>'>
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="blue" width="18px" height="18px"><path d="M0 0h24v24H0z" fill="none"/><path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/></svg>
		</button>
		<a href="#" class="btn btn-sm btn-primary show-desc"
			data-image='../jsonFiles/dataset/<?php echo "{$i['_source']['patentID']}-D0000{$x}.png"; ?>'
			data-aspect='<?php echo ucfirst($i['_source']['aspect']) ?>'
			data-origreftext='<?php echo $i['_source']['origreftext'] ?>'
			data-dd='<?php echo $i['_source']['description'] ?>'
		>Show More</a>
		
	</div>
	
	
	
<?php

	$x++;
 }
 





}
}


	if(isset($_RESQUEST['advanceSearchButton'])){
		$Rname = $_RESQUEST['Rname'];
		$Rtype = $_RESQUEST['Rtype'];
		$Rname=preg_replace("/<|>/i", "",$Rname);
		$Rtype=preg_replace("/<|>/i", "",$Rtype);



		//-- Change Here -->
		$query = $client->search([
		'body' => [
		'query' => [ // (5)
		'bool' => [
		'should' => [
		'match' => ['patentID'  => $Rname],
		'match' => ['aspect'  => $Rtype],


		]
		]
		]
		]
		]);
		if($query['hits']['total'] >=1 ) { // (6)
		$results = $query['hits']['hits'];
		$x = 0;
		 foreach ($results as $i)
		 {
			$qq=$i['_source']['patentID'];
		
		if($Rname !="" || $Rtype != ""){
		?>
			<div class="col-3"  style="border: 1px solid black">
				<a href='../jsonFiles/dataset/<?php echo "$qq"."-D0000".$x.".png"; ?>'>
					<img src='../jsonFiles/dataset/<?php echo "$qq"."-D0000".$x.".png"; ?>'  width="90%"  height="250px" />
				</a>
			</div>
			
		<?php
		}
		
			$x++;
		 }
		}
	}

?>
</div>
</div>

<div class="col-10 mt-5 mx-auto">
				<nav aria-label="Page navigation example">
					<ul class="pagination">
						<li class="page-item <?php echo $page == 1 ? 'disabled': '' ?>">
							<a class="page-link" href="/webproject/search.php?q=<?php echo $q ?>&searchButton=&s=<?php echo $searchby ?>&count=<?php echo $count ?>&page=<?php echo $page - 1 ?>"  <?php echo $page == 1 ? 'tabindex="-1"': '' ?>>
								Previous
							</a>
						</li>
						<?php for ($i=1; $i < $pages_count+1; $i++): ?>
							<li class="page-item <?php echo $i == $page ? 'active': '' ?>">
								<a class="page-link" href="/webproject/search.php?q=<?php echo $q ?>&searchButton=&s=<?php echo $searchby ?>&count=<?php echo $count ?>&page=<?php echo $i ?>">
									<?php echo $i ?>
								</a>
							</li>
						<?php endfor; ?>
						<li class="page-item <?php echo $page == $pages_count ? 'disabled': '' ?>">
							<a class="page-link" href="/webproject/search.php?q=<?php echo $q ?>&searchButton=&s=<?php echo $searchby ?>&count=<?php echo $count ?>&page=<?php echo $page + 1 ?>" <?php echo $page == 1 ? 'tabindex="-1"': '' ?>>
								Next
							</a>
						</li>
					</ul>
				</nav>
				<p>Total results: <?php echo $results_total ?></p>
				<p>Page: <?php echo $page ?> of <?php echo $pages_count ?></p>
			</div>
			</div>

<?php include('inc/item-modal.php') ?>
<script type="text/javascript">
$(function() {
	var $body = $('body')


	$body.on('click', '.show-desc', function(e) {
		e.preventDefault();
		console.log('Modal', this, e)
		var $modal = $('#desc-modal').modal()
			$this = $(this)


		console.log($this.data('aspect'))

		var html = '<img src="'+$this.data('image')+'" height="200" >'+
					'<p class="text-muted">'+$this.data('origreftext')+'</p>'+
					'<p class="">'+$this.data('dd')+'</p>'

		$modal.find('.modal-title').html($this.data('aspect'))
		$modal.find('.modal-body').html(html)

		$modal.modal('show')
	})


	$body.on('click', 'button.save', function(e) {
		var $this = $(this),
			url = "ajax/save.php",
			data = {
				value: $this.data('source'),
				user_email: $this.data('user_email')
			}

		$this.prop('disabled', true)
		var jqxhr = $.post( url, data)
		.done(function(res) {
			console.log(res)
			alert( res );
		})
		.fail(function() {
			alert( "error" );
		})
		.always(function() {
			$this.prop('disabled', false)
			// alert( "finished" );
		});

	})
})
</script>
</body>
</html>

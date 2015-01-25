<?php if (!isset($_GET['dvd'])) {
 header('Location: search.php');   
} ?>
<?php require 'include.php'; ?>
<?
$dvd = $_GET['dvd'];
//PDO()//PHP DATA OBJECT. CAN WORK WITH any type of database. a lot of frameworks use this.
$host = 'itp460.usc.edu';
$dbname = 'dvd';
$user = 'student';
$password = 'ttrojan';
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);//pass a connection string. use double quotes.

$sql = "
SELECT title, genre_name, format_name, rating_name
FROM dvds
INNER JOIN genres
ON dvds. genre_id = genres.id
INNER JOIN formats
ON dvds.format_id = formats.id
INNER JOIN ratings
ON dvds.rating_id = ratings.id
WHERE title LIKE ?
";
$statement = $pdo->prepare($sql);
$like = '%' . $dvd . '%';
$statement->bindParam(1, $like);//binding it to like ?. the 1 is the first question mark in that sql. or it's the first object in the array...? bind param has to be after prepare. 
$statement->execute();
$movies = $statement->fetchAll(PDO::FETCH_OBJ);
$row=$statement->rowCount();
?>
<h3>You searched for <?php echo $dvd; ?></h3>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Title</th>
            <th>Genre</th>
            <th>Format</th>
            <th>Rating</th>
        </tr>
    </thead>
  <?php if ($row > 0 ) : ?>
    <tbody>
		<?php foreach ($movies as $movie) : ?>
			<tr> 
				<td><? echo $movie->title ?></td>
				<td><? echo $movie->genre_name?></td>
				<td><? echo $movie->format_name?></td>
				<td>
					<a href="ratings.php?rating_name=<?php echo $movie->rating_name ?>"> 
						<? echo $movie->rating_name; ?> 
					</a>
				</td>
		     </tr> 
		<?php endforeach ?>
   </tbody>
<? else : ?>
	<? echo $dvd . ' returned no results. <a href="search.php"> Try another search! </a>' ; ?>
<? endif ?>
</table>

<?php require 'footer.php'; ?>
<?php require 'include.php'; ?>
<?php $id = $_GET['rating_name']; ?>



<?php

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
WHERE rating_name = '$id'
";
$statement = $pdo->prepare($sql);
//$like = '%' . $dvd . '%';
$statement->bindParam(1, $like);//binding it to like ?. the 1 is the first question mark in that sql. or it's the first object in the array...? bind param has to be after prepare. 
$statement->execute();
$movies = $statement->fetchAll(PDO::FETCH_OBJ);


?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Title</th>
            <th>Genre</th>
            <th>Format</th>
            <th>Rating</th>
        </tr>
    </thead>
 
    <tbody>
		<?php foreach ($movies as $movie) : ?>
			<tr> 
				<td><?php echo $movie->title ?></td>
				<td><?php echo $movie->genre_name?></td>
				<td><?php echo $movie->format_name?></td>
				<td><?php echo $movie->rating_name; ?></td>
		     </tr> 
		<?php endforeach ?>
   </tbody>
</table>

<?php require 'footer.php'; ?>
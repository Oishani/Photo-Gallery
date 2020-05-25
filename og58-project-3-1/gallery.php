<?php include("includes/init.php");
$title_page = "Gallery";


$tag_records = exec_sql_query($db, "SELECT * FROM tags")->fetchAll(PDO::FETCH_ASSOC);


$current_tag_id = $_GET['id'];

$params = array(
  'current_tag_id' => $current_tag_id
);
$active_tag = exec_sql_query($db, "SELECT tag FROM tags WHERE id= :current_tag_id;", $params)->fetchAll(PDO::FETCH_ASSOC);
$tag_imgs = exec_sql_query($db, "SELECT * FROM gallery INNER JOIN image_tags ON gallery.id = image_tags.gallery_id WHERE image_tags.tag_id = :current_tag_id;", $params)->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Wanderlust</title>
  <link rel="stylesheet" type="text/css" href="styles/site.css" media="all" />
</head>


<body>
  <?php include("includes/header.php"); ?>


  <main>
    <div class="albums">
      <h2 class="album-title"><?php echo htmlspecialchars($title_page); ?></h2>

      <div id="full-gallery">
        <?php
        foreach ($tag_imgs as $record) {
        ?>
          <div class="gallery">
            <a href="image.php?id=<?php echo $record['gallery_id'] ?>"><img class="image-layout" src="uploads/gallery/<?php echo $record['gallery_id'] . "." . $record["file_ext"] ?>" alt="<?php echo htmlspecialchars($record['file_name']) ?>"></a>

            <a target="_blank" href="image.php?id=<?php echo $record['gallery_id'] ?>">
              <h4 class="image-caption"><?php echo htmlspecialchars($record["caption"]) ?></h4>
            </a>
          </div>
        <?php
        }
        ?>
      </div>

      <!-- Source: https://www.visualpharm.com/free-icons/add%20image-595b40b85ba036ed117dbead -->
      <a href="add.php" class="upload-image"><img src="images/upload.png" alt="upload image"></a>
    </div>

    <p class="citation-upload">Source: <cite><a href="https://www.visualpharm.com/free-icons/add%20image-595b40b85ba036ed117dbead">visualpharm.com</a></cite></p>

    <div class="scroll-bar">
      <p class="active-tag">Viewing: <?php echo htmlspecialchars($active_tag[0]["tag"]) ?></p>
      <?php
      foreach ($tag_records as $tag_record) {
      ?>
        <a href="gallery.php?id=<?php echo $tag_record['id'] ?>" class="tag button button2"><?php echo htmlspecialchars($tag_record["tag"]) ?></a>
      <?php } ?>

      <!-- Source: https://media.timeout.com/images/105617718/630/472/image.jpg -->
      <p class="citation-pics">Miami Beach source: <cite><a href="https://media.timeout.com/images/105617718/630/472/image.jpg">media.timeout.com</a></cite></p>

      <!-- Source: https://i.ytimg.com/vi/8-6ORyUirSw/maxresdefault.jpg -->
      <p class="citation-pics">Gulmarg source: <cite><a href="https://i.ytimg.com/vi/8-6ORyUirSw/maxresdefault.jpg">i.ytimg.com</a></cite></p>

      <!-- Source: https://specials-images.forbesimg.com/imageserve/1022328666/960x0.jpg?fit=scale -->
      <p class="citation-pics">Nassau source: <cite><a href="https://specials-images.forbesimg.com/imageserve/1022328666/960x0.jpg?fit=scale">special-images.forbesimg.com</a></cite></p>

      <!-- Source: https://imagevars.gulfnews.com/2019/09/29/Dubai-skyline_16d7de0fdce_large.jpg -->
      <p class="citation-pics">Dubai source: <cite><a href="https://imagevars.gulfnews.com/2019/09/29/Dubai-skyline_16d7de0fdce_large.jpg">imagevars.gulfnews.com</a></cite></p>

      <!-- Source: https://ca-times.brightspotcdn.com/dims4/default/5ce43de/2147483647/strip/true/crop/1366x768+0+0/resize/1366x768!/quality/90/?url=https%3A%2F%2Fcalifornia-times-brightspot.s3.amazonaws.com%2F33%2F23%2F08069f9b8dde8473af3933c5a5c7%2Fla-1563236392-8jpmca5tpq-snap-image -->
      <p class="citation-pics">Disnayland source: <cite><a href="https://ca-times.brightspotcdn.com/dims4/default/5ce43de/2147483647/strip/true/crop/1366x768+0+0/resize/1366x768!/quality/90/?url=https%3A%2F%2Fcalifornia-times-brightspot.s3.amazonaws.com%2F33%2F23%2F08069f9b8dde8473af3933c5a5c7%2Fla-1563236392-8jpmca5tpq-snap-image">ca-times.brightspotcdn.com</a></cite></p>

      <!-- Source: https://cdn.britannica.com/86/170586-050-AB7FEFAE/Taj-Mahal-Agra-India.jpg -->
      <p class="citation-pics">Taj Mahal source: <cite><a href="https://cdn.britannica.com/86/170586-050-AB7FEFAE/Taj-Mahal-Agra-India.jpg">cdn.britannica.com</a></cite></p>

      <!-- Source: https://bountifulsafaris.com/wp-content/uploads/2017/01/wildebeest-mara-migration.jpg -->
      <p class="citation-pics">Masai Mara source: <cite><a href="https://bountifulsafaris.com/wp-content/uploads/2017/01/wildebeest-mara-migration.jpg">bountifulsafaris.com</a></cite></p>

      <!-- Source: https://lp-cms-production.imgix.net/features/2016/04/Santorini-53c9e0dca77b.jpg?format=auto -->
      <p class="citation-pics">Santorini source: <cite><a href="https://lp-cms-production.imgix.net/features/2016/04/Santorini-53c9e0dca77b.jpg?format=auto">lp-cms-production.imgix.net</a></cite></p>

      <!-- Source: https://cdn.britannica.com/65/162465-050-9CDA9BC9/Alps-Switzerland.jpg -->
      <p class="citation-pics">Switzerland source: <cite><a href="https://cdn.britannica.com/65/162465-050-9CDA9BC9/Alps-Switzerland.jpg">cdn.britannica.com</a></cite></p>

      <!-- Source: https://upload.wikimedia.org/wikipedia/commons/9/90/Gir_lion-Gir_forest%2Cjunagadh%2Cgujarat%2Cindia.jpeg -->
      <p class="citation-pics">Gir Forest source: <cite><a href="https://upload.wikimedia.org/wikipedia/commons/9/90/Gir_lion-Gir_forest%2Cjunagadh%2Cgujarat%2Cindia.jpeg">upload.wikimedia.org</a></cite></p>

    </div>
  </main>
</body>

</html>

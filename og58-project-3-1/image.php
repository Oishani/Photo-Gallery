<?php include("includes/init.php");
$title_page = "Image";


$current_image_id = $_GET['id'];
$params_img_tags = array(
  'current_image_id' => $current_image_id
);


$img_tags = exec_sql_query($db, "SELECT tags.tag FROM tags INNER JOIN image_tags ON image_tags.tag_id = tags.id WHERE image_tags.gallery_id = :current_image_id;", $params_img_tags)->fetchAll(PDO::FETCH_ASSOC);

$current_image = exec_sql_query($db, "SELECT * FROM gallery WHERE id= :current_image_id;", $params_img_tags)->fetchAll(PDO::FETCH_ASSOC);
$current_image = $current_image[0];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  //filtering input
  $album_name = $_POST['album'];
  $album_name = trim($album_name);
  $album_name = filter_var($album_name, FILTER_SANITIZE_STRING);

  if (empty($album_name) && $_POST['adding']) {
    $show_add_feedback = TRUE;
  }

  //filtering input
  $album_del_name = $_POST['album_remove'];
  $album_del_name = trim($album_del_name);
  $album_del_name = filter_var($album_del_name, FILTER_SANITIZE_STRING);

  if (empty($album_del_name) && $_POST['removing']) {
    $show_remove_feedback = TRUE;
  }

  // adding a tag
  if (!empty($album_name)) {
    $tag_name = $album_name;
    $params_tag = array(
      ':tag_name' => $tag_name
    );
    $tag_names = exec_sql_query($db, "SELECT tag FROM tags WHERE tag = :tag_name;", $params_tag)->fetchAll(PDO::FETCH_ASSOC);


    if (empty($tag_names[0])) {
      $params1 = array(
        ':tag_name' => $tag_name
      );
      $sql_add_tag = "INSERT INTO tags (tag) VALUES (:tag_name);";
      exec_sql_query($db, $sql_add_tag, $params1);


      $last_tag_id = $db->lastInsertId("id");
    } else {

      $last_tag_id = exec_sql_query($db, "SELECT id FROM tags WHERE tag = :tag_name;", $params_tag)->fetchAll(PDO::FETCH_ASSOC);
      $last_tag_id = $last_tag_id[0]["id"];
    }

    $params2 = array(
      ':img_id' => $current_image_id,
      ':tag_id' => $last_tag_id
    );

    if (empty($tag_names[0])) {
      $sql_connect = "INSERT INTO image_tags (gallery_id, tag_id) VALUES (:img_id, :tag_id);";
      exec_sql_query($db, $sql_connect, $params2);
    }


    $params_img_tags = array(
      'current_image_id' => $current_image_id
    );
    $img_tags = exec_sql_query($db, "SELECT tags.tag FROM tags INNER JOIN image_tags ON image_tags.tag_id = tags.id WHERE image_tags.gallery_id = :current_image_id;", $params_img_tags)->fetchAll(PDO::FETCH_ASSOC);
  } elseif (!empty($album_del_name)) {


    //deleting tag
    $tag_del = $album_del_name;
    $params = array(
      ':del_tag' => $tag_del
    );
    $tag_del_id = exec_sql_query($db, "SELECT id FROM tags WHERE tag = :del_tag;", $params)->fetchAll(PDO::FETCH_ASSOC);
    $tag_del_id = $tag_del_id[0]['id'];

    $params = array(
      ':del_id' => $tag_del_id
    );

    $req_tag = exec_sql_query($db, "SELECT tag FROM tags WHERE id = :del_id", $params)->fetchAll(PDO::FETCH_ASSOC);
    $req_tag = $req_tag[0]["tag"];

    $tag_array = array();
    foreach ($img_tags as $img_tag) {
      array_push($tag_array, $img_tag['tag']);
    }

    if (!in_array($req_tag, $tag_array)) {
      $no_tag_feedback = TRUE;
    }

    $tag_del_names = $img_tags;
    if (!empty($tag_del_names)) {
      $params = array(
        ':del_tag' => $tag_del_id,
        ':img_id' => $current_image_id
      );
      $sql_del = "DELETE FROM image_tags WHERE tag_id = :del_tag AND gallery_id = :img_id;";
      exec_sql_query($db, $sql_del, $params);


      $params_img_tags = array(
        'current_image_id' => $current_image_id
      );
      $img_tags = exec_sql_query($db, "SELECT tags.tag FROM tags INNER JOIN image_tags ON image_tags.tag_id = tags.id WHERE image_tags.gallery_id = :current_image_id;", $params_img_tags)->fetchAll(PDO::FETCH_ASSOC);


      $params = array(
        ':del_tag' => $tag_del_id
      );
      $imgs_remaining = "SELECT * from image_tags WHERE tag_id = :del_tag;";
      $result = exec_sql_query($db, $imgs_remaining, $params)->fetchAll(PDO::FETCH_ASSOC);


      if (empty($result)) {
        exec_sql_query($db, "DELETE FROM tags WHERE id = :del_tag;", $params);
      }
    }
  } elseif (isset($_POST['yes'])) {

    // deleting image
    $img_id = $current_image_id;
    $params = array(
      'curr_id' => $img_id
    );
    exec_sql_query($db, "DELETE FROM gallery WHERE id=:curr_id;", $params)->fetchAll(PDO::FETCH_ASSOC);
    exec_sql_query($db, "DELETE FROM image_tags WHERE gallery_id=:curr_id;", $params)->fetchAll(PDO::FETCH_ASSOC);
    unlink('uploads/gallery/' . $current_image['id'] . "." . $current_image['file_ext']);


    foreach ($img_tags as $img_tag) {
      $tag_del = $img_tag["tag"];
      $params = array(
        ':del_tag' => $tag_del
      );
      $tag_del_id = exec_sql_query($db, "SELECT id FROM tags WHERE tag = :del_tag;", $params)->fetchAll(PDO::FETCH_ASSOC);
      $tag_del_id = $tag_del_id[0]['id'];


      $params = array(
        ':del' => $tag_del_id
      );
      $imgs_remaining = "SELECT * from image_tags WHERE tag_id = :del;";
      $result = exec_sql_query($db, $imgs_remaining, $params)->fetchAll(PDO::FETCH_ASSOC);


      if (empty($result)) {
        exec_sql_query($db, "DELETE FROM tags WHERE id = :del;", $params);
      }
    }

?>

    <?php
    $title_page = "Your image has been successfully deleted!";
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <title>Wanderlust</title>
      <link rel="stylesheet" type="text/css" href="styles/site.css" media="all" />
      <script src="scripts/modal.js" type="text/javascript"></script>

    </head>


    <body>
      <?php include("includes/header.php"); ?>


      <main>
        <div class="image-title">
          <h2><?php echo htmlspecialchars($title_page); ?></h2>
        </div>

        <div class="back-arrow">
          <a href="gallery.php?id=1" class="deets1 button-add button3">&leftarrow; Back to gallery</a>
        </div>

      </main>
    </body>

    </html>
<?php }
}

?>

<?php
if (!isset($_POST['yes'])) {
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Wanderlust</title>
    <link rel="stylesheet" type="text/css" href="styles/site.css" media="all" />
    <script src="scripts/modal.js" type="text/javascript"></script>

  </head>


  <body>
    <?php include("includes/header.php"); ?>


    <main>
      <div class="back-arrow">
        <a href="gallery.php?id=1" class="deets button-add button3">&leftarrow;</a>
      </div>

      <div class="image-title">
        <h2><?php echo htmlspecialchars($title_page); ?></h2>
      </div>

      <div id="full-details">
        <div class="single-image">
          <img class="single-layout" src="uploads/gallery/<?php echo $current_image['id'] . "." . $current_image["file_ext"] ?>" alt="<?php echo htmlspecialchars($current_image['file_name']) ?>">
          <!-- Source: https://getdrawings.com/free-icon/recycle-bin-icon-png-70.png -->
          <a href="" id="btn2" class="delete button-del"><img src="images/trash.png" alt="delete"></a>

          <div id="modal2" class="modal2">
            <div class="modal-content2">
              <form id="modal2" action="" method="post">
                <div class="content">
                  <p>Are you sure you want to delete this image?</p>
                  <input type="submit" id="yes" name="yes" value="Yes">
                  <input type="button" id="cancel" name="cancel" value="Cancel">
                </div>
              </form>
            </div>
          </div>
          <p class="citation-trash">Trash icon source: <cite><a href="https://getdrawings.com/free-icon/recycle-bin-icon-png-70.png">getdrawings.com</a></cite></p>

        </div>

        <div class="image-details">
          <table>
            <tr>
              <td class="info">TITLE: </td>
              <td><?php echo htmlspecialchars($current_image["caption"]) ?></td>
            </tr>
            <tr>
              <td class="info">DATE: </td>
              <td><?php echo htmlspecialchars($current_image["date_taken"]) ?></td>
            </tr>
            <tr>
              <td class="info">FORMAT: </td>
              <td>&nbsp;<?php echo htmlspecialchars(strtoupper($current_image["file_ext"])) ?></td>
            </tr>
            <tr>
              <td class="info">ALBUMS: </td>
              <td><?php
                  foreach ($img_tags as $img_tag) {
                    echo htmlspecialchars($img_tag['tag']); ?>&nbsp;
              <?php } ?>
              </td>
            </tr>
            <tr>
              <td class="info"><button id="btn" class="album-add-drop" onclick="window.location.href = '';" alt="add album">Add to an album</button>
              </td>
              <td><button id="btn1" class="album-add-drop" onclick="window.location.href = '';" alt="remove album">Remove from an album</button>
              </td>
            </tr>
          </table>
          <div>
            <p class="no-tag">
              <?php if ($no_tag_feedback) { ?>
                Album "<?php echo htmlspecialchars($req_tag) ?>" could not be removed since it doesn't belong to this image.
              <?php } ?></p>

            <p class="no-tag" id="add-tag">
              <?php
              if ($show_add_feedback) { ?>
                Oops! No album was added since album name was blank.
              <?php } ?></p>

            <p class="no-tag" id="remove-tag">
              <?php
              if ($show_remove_feedback) { ?>
                Oops! No album was removed since album name was blank.
              <?php } ?></p>

          </div>

        </div>

        <div id="modal" class="modal">

          <div class="modal-content">
            <span class="close">&times;</span>

            <form id="modal-form" action="" method="post">

              <div>
                <label class="lbl" for="album-add">Album name:</label>
                <input type="text" placeholder="Enter album name" name="album" class="album-name" id="add_album">
                <input class="album-add" type="submit" name="adding" value="Add to image">

              </div>

            </form>
          </div>

        </div>

        <div id="modal1" class="modal1">

          <div class="modal-content1">
            <span class="close1">&times;</span>

            <form id="modal1-form" action="" method="post">

              <div>
                <label class="lbl1" for="album_remove">Enter the album you want to remove from the image</label>
                <div>
                  <input type="text" placeholder="Enter album name" name="album_remove" class="album-del-name">
                  <input class="remove" type="submit" name="removing" value="Remove album">
                </div>
              </div>

            </form>
          </div>

        </div>


      </div>

    </main>
  </body>

  </html>
<?php } ?>

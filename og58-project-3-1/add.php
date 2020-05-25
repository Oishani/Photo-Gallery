<?php include("includes/init.php");
$title_page = "Add Photo";


// Default is to show form
$show_form = TRUE;


// Default to no feedback
$show_title_feedback = FALSE;
$show_date_feedback = FALSE;
$show_upload_feedback = FALSE;
$show_size_feedback = FALSE;

// Set maximum file size for uploaded files.
// MAX_FILE_SIZE must be set to bytes
// 1 MB = 1000000 bytes
const MAX_FILE_SIZE = 1000000;


// uploading files
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // Assume the form is valid
  $is_form_valid = TRUE;


  //filter input
  $title = $_POST["title"];
  $title = trim($title);
  $title = filter_var($title, FILTER_SANITIZE_STRING);

  if (empty($title)) {
    $is_form_valid = FALSE;
    $show_title_feedback = TRUE;
  }


  //filter input
  $date = $_POST["date"];
  $date = trim($date);
  $date = filter_var($date, FILTER_SANITIZE_STRING);

  if (empty($date)) {
    $is_form_valid = FALSE;
    $show_date_feedback = TRUE;
  }


  //filter input
  $album = $_POST["album"];
  $album = trim($album);
  $album = filter_var($album, FILTER_SANITIZE_STRING);


  $upload_info = $_FILES["image_file"];
  $upload = $upload_info;


  if (empty($upload["tmp_name"])) {
    $is_form_valid = FALSE;
    $show_upload_feedback = TRUE;
  }


  if ($upload['error'] == UPLOAD_ERR_OK) {
    if ($upload['size'] >= MAX_FILE_SIZE) {
      $is_form_valid = FALSE;
      $show_size_feedback = TRUE;
    }
    $file_name_full = ($upload_info["name"]);


    $ext = strtolower(pathinfo($file_name_full, PATHINFO_EXTENSION));


    $file_name = basename($file_name_full, "." . $ext);


    $params = array(
      ':file_name' => $file_name_full,
      ':caption' => $title,
      ':date' => $date,
      ':ext' => $ext
    );
    $sql = "INSERT INTO gallery (file_name, caption, date_taken, file_ext) VALUES (:file_name, :caption, :date, :ext);";
    $result = exec_sql_query($db, $sql, $params)->fetchAll(PDO::FETCH_ASSOC);


    $last_id = $db->lastInsertId("id");


    $params = array(
      ':last_id' => $last_id
    );
    $sql1 = "INSERT INTO image_tags (gallery_id, tag_id) VALUES (:last_id, 1);";
    $result1 = exec_sql_query($db, $sql1, $params)->fetchAll(PDO::FETCH_ASSOC);


    $new_path = "uploads/gallery/" . $last_id . "." . $ext;


    move_uploaded_file($upload_info["tmp_name"], $new_path);
  }
  if (!empty($album)) {
    $tag_name = $album;
    $params_tag = array(
      ':tag_name' => $tag_name
    );
    $tag_names = exec_sql_query($db, "SELECT tag FROM tags WHERE tag = :tag_name;", $params_tag)->fetchAll(PDO::FETCH_ASSOC);


    if (empty($tag_names)) {
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
      ':img_id' => $last_id,
      ':tag_id' => $last_tag_id
    );
    $sql_connect = "INSERT INTO image_tags (gallery_id, tag_id) VALUES (:img_id, :tag_id);";
    exec_sql_query($db, $sql_connect, $params2);
  }
?>
<?php

  $show_form = !$is_form_valid;
}
?>

<?php
if ($show_form) {
?>
  <?php
  $title_page = "Add Photo";
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
      <h2 class="add-title"><?php echo htmlspecialchars($title_page); ?></h2>

      <div class="img-form">

        <div>
          <a href="gallery.php?id=1" class="button-add button3">&leftarrow;</a>
        </div>

        <!-- Source: https://img.icons8.com/officel/2x/add-image.png -->
        <img class="add-image" src="images/add-image.png" alt="add image">
        <p class="citation-add-img">Source: <cite><a href="https://img.icons8.com/officel/2x/add-image.png">img.icons8.com</a></cite></p>

        <form class="img-form-actual" action="" autocomplete="on" enctype="multipart/form-data" method="post">

          <div>
            <?php
            if ($show_title_feedback) { ?>
              <div class="error-msg">Please enter a title for your image</div>
            <?php } ?>
            <label class="form_title" for="title">Title: </label>
            <input class="full title-input" id="title" type="text" name="title" value="" />
          </div>

          <div>
            <?php
            if ($show_date_feedback) { ?>
              <div class="error-msg">Please enter the date your image was taken</div>
            <?php } ?>
            <label class="form_title" for="date">Date taken: </label>
            <input class="full date-input" id="date" type="date" name="date" value="" />
          </div>

          <div>
            <label class="form_title" for="album">Album: </label>
            <input class="full album-input" id="album" type="text" name="album" value="" />
          </div>

          <!-- MAX_FILE_SIZE must precede the file input field -->
          <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />

          <div>
            <?php
            if ($show_upload_feedback) { ?>
              <div class="error-msg">Please upload an image</div>
            <?php } ?>
            <?php
            if ($show_size_feedback) { ?>
              <div class="error-msg">File size is too big! Files must be less than 1MB</div>
            <?php } ?>
            <label class="form_title" for="image_file">Upload image: </label>
            <input class="full file-input" type="file" id="image_file" name="image_file" value="">
          </div>

          <input class="create" type="submit" name="final_submit" value="+ Add to gallery"></input>

        </form>

      </div>

    </main>
  </body>

  </html>
<?php
} else { ?>
  <?php
  $title_page = "Your image has been successfully added!";
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
?>

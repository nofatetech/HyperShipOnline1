<?php


if (isset($_POST['post_title']) && isset($_POST['post_name'])) {
    $title = sanitize_text_field($_POST['post_title']);
    $slug = sanitize_title($_POST['post_name']);

    // Get the post ID from the URL or form
    $post_id = $app_id; // isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;

    // var_dump($post_id);die();

    if ($post_id > 0) {
        // Update the post
        $post_data = array(
            'ID' => $post_id,
            'post_title' => $title,
            'post_name' => $slug
        );

        $result = wp_update_post($post_data);

        if ($result) {
        } else {
        }
    } else {
    }
}


if (isset($_POST['save_file']) && isset($_POST['file_editor_nonce'])) {
    if (wp_verify_nonce($_POST['file_editor_nonce'], 'file_editor_action')) {
        publishwebapp($app_id);
        // die('xx');
    }
}

function publishwebapp($app_id) {

    // Get post title and slug
    $post = get_post($app_id);
    $slug = $post->post_name;

    // Create folder path
    $folder_path = ABSPATH . $slug;

    // Create folder if it doesn't exist
    if (!file_exists($folder_path)) {
        wp_mkdir_p($folder_path);
    }

    // Create index.html with empty content
    $index_path = $folder_path . '/index.html';
    $editor_content = isset($_POST['editor_content']) ? stripslashes($_POST['editor_content']) : '';
    file_put_contents($index_path, $editor_content);
    return;
}

function get_app_index_content($app_id) {
    // Get post slug
    $post = get_post($app_id);
    $slug = $post->post_name;

    // Get folder path
    $folder_path = ABSPATH . $slug;
    $index_path = $folder_path . '/index.html';

    // Check if file exists and return content
    if (file_exists($index_path)) {
        return file_get_contents($index_path);
    }

    return '';
}




?>



<!-- <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css"> -->
<!-- <script src="http://code.jquery.com/jquery-1.9.1.js"></script> -->
<!-- <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> -->
<script type="text/javascript">
  // var jui = jQuery.noConflict();
  // jui(function () {
  //   jui('#btn1').button();
  // })
</script>
<!-- <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/default/easyui.css"> -->
<!-- <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/icon.css"> -->
<!-- <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.min.js"></script> -->
<!-- <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.easyui.min.js"></script> -->


<div>

  <h1>Frontend Apps Builder</h1>


  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .header {
      background-color: #2c3e50;
      color: white;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .header .info {
      font-size: 14px;
    }

    .header .actions {
      color: #e74c3c;
    }

    .nav {
      background-color: #3498db;
      padding: 10px;
      color: white;
    }

    .nav a {
      color: white;
      margin-right: 10px;
      text-decoration: none;
    }

    .file-area {
      padding: 20px;
      text-align: center;
    }

    .buttons {
      margin-bottom: 20px;
    }

    .buttons button {
      background-color: #e74c3c;
      color: white;
      border: none;
      padding: 10px 20px;
      margin-right: 10px;
      cursor: pointer;
    }

    .file-grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
    }

    .file-item {
      border: 1px solid #ddd;
      padding: 10px;
      width: 100px;
      height: 100px;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #fff;
    }

    .drag-area {
      border: 2px dashed #ccc;
      padding: 20px;
      color: #888;
    }
  </style>

  <div class="header">
    <div class="info">
      Welcome to My Website!<br>
      Last updated 15 seconds ago
    </div>
    <div class="actions">
      Using 0.0% (29.48 KB) of 1 GB Storage<br>
      Used 382.6 KB of bandwidth this month.<br>
      Need more space? Become a supporter!
    </div>
  </div>
  <div class="nav">
    <a href="#">Home</a>
  </div>



  <div class="post-editor">
    <form method="post" action="">
      <?php wp_nonce_field('update_post_title_slug', 'post_title_slug_nonce'); ?>

      <div class="form-group">
        <label for="post_title">Post Title:</label>
        <input type="text" id="post_title" name="post_title" value="<?php echo esc_attr(get_the_title($app_id)); ?>" class="regular-text">
      </div>

      <div class="form-group">
        <label for="post_name">Post Slug:</label>
        <input type="text" id="post_name" name="post_name" value="<?php echo esc_attr(get_post_field('post_name', $app_id)); ?>" class="regular-text">
      </div>

      <div class="form-group">
        <input type="submit" name="update_post_title_slug" value="Update Title & Slug" class="button button-primary">
      </div>
    </form>
  </div>

  <style>
    .post-editor {
      background: #fff;
      padding: 20px;
      margin: 20px 0;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .form-group {
      margin-bottom: 15px;
    }
    .form-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }
    .form-group input[type="text"] {
      width: 100%;
      max-width: 400px;
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 4px;
    }
  </style>






  <div class="file-area">
    <div class="buttons">
      <button>Preview</button>
      <button>Publish</button>
    </div>
    <div class="buttons">
      <button>New File</button>
      <button>New Folder</button>
      <button>Upload</button>
    </div>
    <div class="file-grid">
      <div class="file-item">index.html</div>
      <div class="file-item">neocities.png</div>
      <div class="file-item">not_found.html</div>
      <div class="file-item">robots.txt</div>
      <div class="file-item">script.js</div>
      <div class="file-item">style.css</div>
    </div>
    <div class="drag-area">
      drag and drop files here to upload
    </div>
  </div>





  <div>
    <div class="file-editor">
      <style>
        .file-editor {
          width: 100%;
          max-width: 800px;
          margin: 0 auto;
          padding: 20px;
          border: 2px solid #00ff00;
          background-color: #000000;
          color: #00ff00;
          font-family: 'Courier New', Courier, monospace;
          box-shadow: 0 0 10px #00ff00;
        }

        .file-editor select {
          width: 100%;
          padding: 8px;
          margin-bottom: 10px;
          border: 1px solid #00ff00;
          background-color: #000000;
          color: #00ff00;
          font-family: 'Courier New', Courier, monospace;
        }

        .file-editor textarea {
          width: 100%;
          height: 400px;
          padding: 10px;
          border: 1px solid #00ff00;
          background-color: #000000;
          color: #00ff00;
          font-family: 'Courier New', Courier, monospace;
          resize: vertical;
        }

        .editor-buttons {
          margin-top: 10px;
          text-align: right;
        }

        .editor-buttons button {
          padding: 8px 16px;
          margin-left: 10px;
          border: 1px solid #00ff00;
          background-color: #000000;
          color: #00ff00;
          font-family: 'Courier New', Courier, monospace;
          cursor: pointer;
        }

        .editor-buttons button:hover {
          background-color: #003300;
        }
      </style>
      <form method="post" action="">
        <?php wp_nonce_field('file_editor_action', 'file_editor_nonce'); ?>
        <select name="file_select" id="file-select">
          <option value="index.html">index.html</option>
          <option value="script.js">script.js</option>
          <option value="style.css">style.css</option>
          <option value="not_found.html">not_found.html</option>
        </select>
        <textarea name="editor_content" id="editor-content" placeholder="Start editing your file here..."><?php echo get_app_index_content($app_id); //echo esc_textarea(get_option('file_editor_content')); ?></textarea>
        <div class="editor-buttons">
          <button type="button" class="cancel-btn">Cancel</button>
          <button type="submit" name="save_file" class="save-btn">Save</button>
        </div>
      </form>
    </div>

  </div>




</div>
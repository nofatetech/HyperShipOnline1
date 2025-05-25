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
      <select id="file-select">
        <option value="index.html">index.html</option>
        <option value="script.js">script.js</option>
        <option value="style.css">style.css</option>
        <option value="not_found.html">not_found.html</option>
      </select>
      <textarea id="editor-content" placeholder="Start editing your file here..."></textarea>
      <div class="editor-buttons">
        <button class="cancel-btn">Cancel</button>
        <button class="save-btn">Save</button>
      </div>
    </div>


  </div>




</div>
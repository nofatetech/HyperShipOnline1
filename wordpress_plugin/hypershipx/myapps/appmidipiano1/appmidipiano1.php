<?php

namespace HyperShipX;

use HyperShipX\HyperShipXApp;


class AppMidiPiano1 extends HyperShipXApp {


  public function init(): void {
    die('ppppppp');
    add_action('plugins_loaded', function () {
      die(">>> AppMidiPiano1 plugins_loaded");
    });


  }
  // routes, auth



  public function app_details_page_before(): void {


    ?>
    <div>app_details_page_before piano</div>
    <?php


  }



}


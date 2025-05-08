<div style="border: 0px solid black; margin-bottom: 11px;">

  <div class="hypership-card-user-info">


    <div>
      <?php
      $avatar_url = get_avatar_url($tuser->ID, ['size' => 40]);
      ?>
      <img src="<?php echo esc_url($avatar_url); ?>" alt="<?php echo esc_attr($tuser->display_name); ?>'s avatar"
        style="width: 40px; height: 40px; border-radius: 50%; border: 2px solid rgba(255, 255, 255, 0.3); margin-right: 12px;">

      <strong>
        <?php echo esc_html($tuser->user_login); ?>

      </strong>
    </div>
    <div>
      Registered: <?php echo date('M j, Y', strtotime($tregistration->post_date)); ?>
      (<?php echo date('F j, Y', strtotime($tregistration->post_date)); ?>)
    </div>


    <div>
      <div>
        <?php echo esc_html($tuser->user_email); ?>
      </div>
    </div>
    <!-- <div><?php //echo esc_html($titem['email']);
    ?></div> -->
    <div>
      Points: 33
    </div>
    <div>
      <a href="#">Deactivate</a>
      \
      <a href="/wp-admin/post.php?post=<?php //echo $titem['id']; ?>&action=edit">Edit</a>
      \
      <a href="#">Send notice</a>
    </div>
    <div><?php //echo esc_html($user->user_email);
    ?></div>
    <div><?php //echo esc_html($user->display_name);
    ?></div>




  </div>
</div>
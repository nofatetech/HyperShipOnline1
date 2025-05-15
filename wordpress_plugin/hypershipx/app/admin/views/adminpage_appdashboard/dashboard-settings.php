<!-- Settings Section -->
<div class="hypership-card">
  <h2
    style="font-family: 'Elite', monospace; text-transform: uppercase; letter-spacing: 2px; border-bottom: 2px solid #007cba; padding-bottom: 10px;">
    ⚙️ Settings 🔧</h2>

  <style>
    .allblured {
      filter: blur(5px);
      transition: filter 0.3s ease;
    }
  </style>
  <div class="xxxallblured">

    <div style="font-size: 14px; color: #888; margin-bottom: 15px;">
      🚧 Under construction 🚧<br>
    </div>

    <p>App Status: <span
        class="status"><?php echo esc_html(get_post_status($app_id) === 'publish' ? 'Active' : 'Inactive'); ?></span>
    </p>
    <p>Last Updated: <?php echo esc_html(get_post_modified_time('F j, Y', false, $app_id)); ?></p>
    <p><a href="<?php echo get_edit_post_link($app_id); ?>">Edit App Settings</a></p>


    <div class="support-section"
      style="margin: 20px 0; padding: 20px; background: #ccc; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
      <h3 style="margin-top: 0; margin-bottom: 15px; font-size: 16px; color: #333;">Need Help with HyperShip? Contact
        Support</h3>

      <div class="support-options" style="margin-bottom: 20px;">
        <p>📱 Talk with us on X (Twitter): <a href="https://twitter.com/NoFateTech" target="_blank">@NoFateTech</a></p>
      </div>

      <form id="support-form" style="display: flex; flex-direction: column; gap: 15px;">
        <div class="form-group">
          <label for="support-email" style="display: block; margin-bottom: 5px; font-weight: 500;">Your Email</label>
          <input type="email" id="support-email" name="support-email" required
            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
        </div>

        <div class="form-group">
          <label for="support-type" style="display: block; margin-bottom: 5px; font-weight: 500;">Type of
            Message</label>
          <select id="support-type" name="support-type" required
            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            <option value="">Select a type...</option>
            <option value="bug">Bug Report</option>
            <option value="feature">Feature Request</option>
            <option value="question">General Question</option>
            <option value="billing">Billing Issue</option>
            <option value="careers">Careers</option>
            <option value="other">Other</option>
          </select>
        </div>

        <div class="form-group">
          <label for="support-message" style="display: block; margin-bottom: 5px; font-weight: 500;">Message</label>
          <textarea id="support-message" name="support-message" rows="4" required
            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"></textarea>
        </div>

        <button type="submit"
          style="padding: 10px 20px; background: #007cba; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 500;">
          Send Message
        </button>
      </form>
    </div>





    <script>
      document.getElementById('support-form').addEventListener('submit', function (e) {
        e.preventDefault();
        // TODO: Implement form submission logic
        alert('Thank you for your message. We will get back to you soon!');
        this.reset();
      });
    </script>


  </div>
  <!-- /allblured -->


</div>
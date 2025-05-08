<!-- Support Dashboard Section -->
<div class="hypership-card">
  <h2
    style="font-family: 'Elite', monospace; text-transform: uppercase; letter-spacing: 2px; border-bottom: 2px solid #007cba; padding-bottom: 10px;">
    Marketing
  </h2>

  <!-- Marketing Overview Section -->
  <div class="marketing-overview" style="margin-bottom: 25px;">
    <div class="stats-grid"
      style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px;">
      <div class="stat-card"
        style="background: #fff; padding: 15px; border-radius: 8px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <div style="font-size: 24px; font-weight: bold; color: #007cba;">0</div>
        <div style="font-size: 14px; color: #666;">Active Campaigns</div>
      </div>
      <div class="stat-card"
        style="background: #fff; padding: 15px; border-radius: 8px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <div style="font-size: 24px; font-weight: bold; color: #28a745;">0</div>
        <div style="font-size: 14px; color: #666;">News Mentions</div>
      </div>
      <div class="stat-card"
        style="background: #fff; padding: 15px; border-radius: 8px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <div style="font-size: 24px; font-weight: bold; color: #dc3545;">0</div>
        <div style="font-size: 14px; color: #666;">Press Releases</div>
      </div>
    </div>
  </div>

  <!-- Marketing Campaigns Section -->
  <div class="marketing-campaigns" style="margin-bottom: 25px;">
    <h3 style="font-size: 18px; margin-bottom: 15px;">🎯 Active Campaigns</h3>
    <div class="campaigns-grid"
      style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px;">
      <div class="campaign-card"
        style="background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <h4 style="margin: 0 0 10px 0;">No Active Campaigns</h4>
        <p style="margin: 0; font-size: 14px; color: #666;">Create your first marketing campaign to get started.</p>
        <button
          style="margin-top: 10px; padding: 8px 15px; background: #007cba; color: white; border: none; border-radius: 4px; cursor: pointer;">Create
          Campaign</button>
      </div>
    </div>
  </div>

  <!-- Press & Media Section -->
  <div class="press-media" style="margin-bottom: 25px;">
    <h3 style="font-size: 18px; margin-bottom: 15px;">📰 Press & Media</h3>
    <div class="media-grid"
      style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px;">
      <div class="media-card"
        style="background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <h4 style="margin: 0 0 10px 0;">Latest Press Releases</h4>
        <p style="margin: 0; font-size: 14px; color: #666;">No press releases found.</p>
        <button
          style="margin-top: 10px; padding: 8px 15px; background: #007cba; color: white; border: none; border-radius: 4px; cursor: pointer;">Create
          Press Release</button>
      </div>
      <div class="media-card"
        style="background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <h4 style="margin: 0 0 10px 0;">Media Mentions</h4>
        <p style="margin: 0; font-size: 14px; color: #666;">No media mentions found.</p>
        <button
          style="margin-top: 10px; padding: 8px 15px; background: #007cba; color: white; border: none; border-radius: 4px; cursor: pointer;">Add
          Media Mention</button>
      </div>
    </div>
  </div>

  <!-- CRM Integration Section -->
  <div class="crm-integration" style="margin-bottom: 25px;">
    <h3 style="font-size: 18px; margin-bottom: 15px;">🤝 CRM Integration</h3>
    <div class="crm-grid"
      style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px;">
      <div class="crm-card"
        style="background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <h4 style="margin: 0 0 10px 0;">CRM Status</h4>
        <p style="margin: 0; font-size: 14px; color: #666;">No CRM integration configured.</p>
        <button
          style="margin-top: 10px; padding: 8px 15px; background: #007cba; color: white; border: none; border-radius: 4px; cursor: pointer;">Configure
          CRM</button>
      </div>
      <div class="crm-card"
        style="background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <h4 style="margin: 0 0 10px 0;">Lead Management</h4>
        <p style="margin: 0; font-size: 14px; color: #666;">No leads found.</p>
        <button
          style="margin-top: 10px; padding: 8px 15px; background: #007cba; color: white; border: none; border-radius: 4px; cursor: pointer;">Manage
          Leads</button>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Add click handlers for buttons
      const buttons = document.querySelectorAll('button');
      buttons.forEach(button => {
        button.addEventListener('click', function () {
          // TODO: Implement button click handlers
          console.log('Button clicked:', this.textContent);
        });
      });
    });
  </script>


</div>
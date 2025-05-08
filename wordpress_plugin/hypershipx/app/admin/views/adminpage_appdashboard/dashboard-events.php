<!-- Events Section -->
<div class="hypership-card">
  <h2
    style="font-family: 'Elite', monospace; text-transform: uppercase; letter-spacing: 2px; border-bottom: 2px solid #007cba; padding-bottom: 10px;">
    🎉 Events 📅</h2>

  <div style="border: 0px solid black;">
    <strong>Past Events</strong>
    <div>Total: 11</div>
    <div>Attendees: 33</div>
    <div>Revenue: $333</div>
  </div>
  <div style="border: 0px solid black;">
    <strong>Coming Events</strong>
    <div>Attendees: 33 (15 not sold yet)</div>
    <div>Total: 33</div>
  </div>


  <div class="events-dashboard">
    <!-- Stats Overview -->
    <div class="stats-grid"
      style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px;">
      <div class="stat-card" style="padding: 12px; border-radius: 6px; border-left: 3px solid #007cba;">
        <div style="font-size: 20px; font-weight: 500; color: #007cba;">
          <?php echo esc_html(get_post_meta($app_id, 'total_events', true) ?: '0'); ?> 📅
        </div>
        <div style="font-size: 12px; color: #666;">Events</div>
      </div>

      <div class="stat-card" style="padding: 12px; border-radius: 6px; border-left: 3px solid #28a745;">
        <div style="font-size: 20px; font-weight: 500; color: #28a745;">
          <?php echo esc_html(get_post_meta($app_id, 'total_attendees', true) ?: '0'); ?> 👥
        </div>
        <div style="font-size: 12px; color: #666;">Attendees</div>
      </div>

      <div class="stat-card" style="padding: 12px; border-radius: 6px; border-left: 3px solid #ffc107;">
        <div style="font-size: 20px; font-weight: 500; color: #ffc107;">
          <?php echo esc_html(get_post_meta($app_id, 'upcoming_events', true) ?: '0'); ?> 🔜
        </div>
        <div style="font-size: 12px; color: #666;">Upcoming</div>
      </div>

      <div class="stat-card" style="padding: 12px; border-radius: 6px; border-left: 3px solid #dc3545;">
        <div style="font-size: 20px; font-weight: 500; color: #dc3545;">
          <?php echo esc_html(get_post_meta($app_id, 'event_revenue', true) ?: '$0'); ?> 💰
        </div>
        <div style="font-size: 12px; color: #666;">Revenue</div>
      </div>
    </div>

    <!-- Events Timeline -->
    <div
      style="display: none; background: #fff; border-radius: 8px; padding: 20px; margin-bottom: 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
      <h3 style="margin-top: 0; margin-bottom: 15px; font-size: 16px; color: #333;">Upcoming Events</h3>
      <?php
      $upcoming_events = get_posts([
        'post_type' => 'hypership-event',
        'posts_per_page' => 3,
        'meta_query' => [
          [
            'key' => 'event_date',
            'value' => date('Y-m-d'),
            'compare' => '>=',
            'type' => 'DATE'
          ],
          [
            'key' => 'hypership_app',
            'value' => $app_id,
            'compare' => '='
          ]
        ],
        'orderby' => 'meta_value',
        'meta_key' => 'event_date',
        'order' => 'ASC'
      ]);

      foreach ($upcoming_events as $event) {
        $event_date = get_post_meta($event->ID, 'event_date', true);
        $attendees = get_post_meta($event->ID, 'attendees_count', true);
        $capacity = get_post_meta($event->ID, 'capacity', true);
        ?>
        <div style="display: flex; align-items: center; padding: 12px; border-bottom: 1px solid #eee;">
          <div style="flex: 1;">
            <div style="font-weight: 500;"><?php echo esc_html($event->post_title); ?></div>
            <div style="font-size: 13px; color: #666;">
              <?php echo date('M j, Y', strtotime($event_date)); ?> •
              <?php echo esc_html($attendees); ?>/<?php echo esc_html($capacity); ?> attendees
            </div>
          </div>
          <div>
            <a href="#" style="color: #007cba; text-decoration: none; font-size: 13px;">View Details →</a>
          </div>
        </div>
      <?php } ?>
    </div>

    <!-- Quick Actions -->
    <div style="display: flex; gap: 10px; margin-bottom: 25px; display: none; ">
      <a href="#" class="button button-primary" style="text-decoration: none;">Create New Event</a>
      <a href="#" class="button" style="text-decoration: none;">View All Events</a>
      <a href="#" class="button" style="text-decoration: none;">Export Data</a>
    </div>

    <!-- Event Performance Chart -->
    <div style="background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); ">
      <h3 style="margin-top: 0; margin-bottom: 15px; font-size: 16px; color: #333;">Event Performance</h3>
      [GRAPH]
      <canvas id="eventPerformanceChart" style="height: 200px;"></canvas>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      return;
      const ctx = document.getElementById('eventPerformanceChart');
      if (!ctx) return;

      new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
          datasets: [{
            label: 'Event Revenue',
            data: [1200, 1900, 1500, 2800, 2200, 3000],
            borderColor: '#007cba',
            backgroundColor: 'rgba(0, 124, 186, 0.1)',
            tension: 0.4,
            fill: true
          }, {
            label: 'Attendees',
            data: [45, 52, 48, 55, 60, 58],
            borderColor: '#28a745',
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            tension: 0.4,
            fill: true
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'top',
            }
          },
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    });
  </script>





</div>
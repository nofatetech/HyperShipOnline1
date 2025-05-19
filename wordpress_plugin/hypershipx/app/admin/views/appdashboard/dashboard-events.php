<!-- Events Section -->
<div class="hypership-card">
  <h2
    style="font-family: 'Elite', monospace; text-transform: uppercase; letter-spacing: 2px; border-bottom: 2px solid #007cba; padding-bottom: 10px;">
    🎉 Events 📅
  </h2>

  <style>
    .events-dashboard {
      filter: blur(5px);
      transition: filter 0.3s ease;
    }
    .events-dashboard:hover {
      /* filter: blur(0); */
    }
  </style>

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

    <!-- Calendar and Events List -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
      <!-- Calendar -->
      <div style="background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <div id="calendar"></div>
      </div>

      <!-- Events List -->
      <div style="background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <h3 style="margin-top: 0; margin-bottom: 15px; font-size: 16px; color: #333;">Events for <span
            id="selected-date"></span></h3>
        <div id="events-list"></div>
      </div>
    </div>

    <!-- Event Performance Chart -->
    <div style="background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
      <h3 style="margin-top: 0; margin-bottom: 15px; font-size: 16px; color: #333;">Event Performance</h3>
      <canvas id="eventPerformanceChart" style="height: 200px;"></canvas>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Initialize Calendar
      const calendarEl = document.getElementById('calendar');
      const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek'
        },
        events: <?php
        $events = get_posts([
          'post_type' => 'hypership-event',
          'posts_per_page' => -1,
          'meta_query' => [
            [
              'key' => 'hypership_app',
              'value' => $app_id,
              'compare' => '='
            ]
          ]
        ]);

        $calendar_events = array_map(function ($event) {
          $event_date = get_post_meta($event->ID, 'event_date', true);
          return [
            'title' => $event->post_title,
            'start' => $event_date,
            'url' => get_edit_post_link($event->ID)
          ];
        }, $events);

        echo json_encode($calendar_events);
        ?>,
        dateClick: function (info) {
          const selectedDate = info.dateStr;
          document.getElementById('selected-date').textContent = new Date(selectedDate).toLocaleDateString();

          // Fetch events for selected date
          const eventsList = document.getElementById('events-list');
          eventsList.innerHTML = '';

          <?php foreach ($events as $event): ?>
            if ('<?php echo get_post_meta($event->ID, 'event_date', true); ?>' === selectedDate) {
              const eventDiv = document.createElement('div');
              eventDiv.style.padding = '10px';
              eventDiv.style.borderBottom = '1px solid #eee';
              eventDiv.innerHTML = `
                <div style="font-weight: 500;"><?php echo esc_js($event->post_title); ?></div>
                <div style="font-size: 13px; color: #666;">
                  <?php echo esc_js(get_post_meta($event->ID, 'attendees_count', true)); ?>/<?php echo esc_js(get_post_meta($event->ID, 'capacity', true)); ?> attendees
                </div>
              `;
              eventsList.appendChild(eventDiv);
            }
          <?php endforeach; ?>
        }
      });
      calendar.render();

      // Initialize Performance Chart
      const ctx = document.getElementById('eventPerformanceChart');
      if (ctx) {
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
      }
    });
  </script>
</div>
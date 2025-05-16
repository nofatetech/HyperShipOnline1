<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <p>Welcome to the HyperShip Dashboard. Manage your apps from the <a
            href="<?php echo admin_url('edit.php?post_type=hypership-app'); ?>">Apps</a> page.</p>
</div>

<?php if (false) { ?>


    <div class="dashboard-container" style="padding: 2rem;">
    <div class="row mb-4">
        <div class="col">
            <h1 class="display-4 text-white mb-0">My Apps</h1>
            <p class="text-light-50">Manage your HyperShip applications</p>
        </div>
    </div>

    <div class="row g-4" id="apps-grid">
        <?php
        $apps = get_posts([
            'post_type' => 'hypership-app',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
            'author' => get_current_user_id()
        ]);

        foreach ($apps as $app) {
            ?>
            <div class="col-md-4">
                <div class="app-card" onclick="window.location.href='<?php echo admin_url('admin.php?page=hypershipx_adminpage_appdashboard&app_id=' . $app->ID); ?>'">
                    <div class="app-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h3 class="app-title"><?php echo esc_html($app->post_title); ?></h3>
                    <p class="app-description"><?php echo esc_html($app->post_excerpt); ?></p>
                    <div class="app-meta">
                        <span>Created: <?php echo date('M j, Y', strtotime($app->post_date)); ?></span>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<style>
    .app-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 1.5rem;
        height: 100%;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
        cursor: pointer;
    }

    .app-card:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.15);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .app-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #00c6fb, #005bea);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        color: white;
        font-size: 1.5rem;
    }

    .app-title {
        color: white;
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .app-description {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .app-meta {
        display: flex;
        justify-content: space-between;
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.8rem;
    }

    .app-status {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .status-active {
        background: rgba(40, 167, 69, 0.2);
        color: #28a745;
    }

    .status-draft {
        background: rgba(255, 193, 7, 0.2);
        color: #ffc107;
    }
</style>

<script>
    $(document).ready(function () {
        // Load apps using WordPress REST API
        $.ajax({
            url: '/wp-json/wp/v2/hypership_app',
            method: 'GET',
            data: {
                author: currentUserId, // You'll need to pass this from PHP
                per_page: 100
            },
            success: function (apps) {
                const grid = $('#apps-grid');

                apps.forEach(app => {
                    const card = `
          <div class="col-md-4 col-lg-3">
            <div class="app-card" onclick="window.location.href='${app.link}'">
              <div class="app-icon">
                <i class="bi bi-${getAppIcon(app)}"></i>
              </div>
              <h3 class="app-title">${app.title.rendered}</h3>
              <p class="app-description">${app.excerpt.rendered}</p>
              <div class="app-meta">
                <span class="app-status status-${app.status}">${app.status}</span>
                <span>Updated ${formatDate(app.modified)}</span>
              </div>
            </div>
          </div>
        `;
                    grid.append(card);
                });

                // Animate cards in with GSAP
                gsap.from(".app-card", {
                    duration: 0.8,
                    y: 30,
                    opacity: 0,
                    stagger: 0.1,
                    ease: "power2.out"
                });
            }
        });
    });

    function getAppIcon(app) {
        // Map app types to Bootstrap icons
        const iconMap = {
            'default': 'app',
            'game': 'controller',
            'tool': 'tools',
            'social': 'people',
            'content': 'file-text'
        };

        return iconMap[app.app_type] || iconMap.default;
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diff = now - date;

        // If less than 24 hours ago
        if (diff < 86400000) {
            return 'today';
        }
        // If less than 7 days ago
        if (diff < 604800000) {
            return Math.floor(diff / 86400000) + ' days ago';
        }
        // Otherwise return formatted date
        return date.toLocaleDateString();
    }
</script>

<?php } ?>

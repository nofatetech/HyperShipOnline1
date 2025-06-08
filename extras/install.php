#!/usr/bin/env php
<?php
/**
 * HyperShipX Secondary Installer
 * A wrapper script that uses newsite.php for WordPress/Laravel installation
 *
 * Xdebug Configuration:
 * 1. Install Xdebug:
 *    sudo apt-get install php-xdebug
 *
 * 2. Configure php.ini (usually in /etc/php/8.x/cli/php.ini):
 *    [xdebug]
 *    xdebug.mode=debug
 *    xdebug.start_with_request=yes
 *    xdebug.client_host=127.0.0.1
 *    xdebug.client_port=9003
 *    xdebug.idekey=PHPSTORM
 *
 * 3. Run with Xdebug:
 *    php -dxdebug.remote_enable=1 extras/install.php <appname>
 *
 * 4. In your IDE (e.g., PHPStorm):
 *    - Set up a PHP Remote Debug configuration
 *    - Set the IDE key to PHPSTORM
 *    - Start listening for PHP Debug Connections
 *    - Set breakpoints in the code
 *
 * @category WebApp
 * @package  HyperShipX
 * @author   Developer <developer@example.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/yourusername/hypershipx
 */

class HyperShipXSecondaryInstaller
{
    private string $_serverName;
    private string $_currentDir;
    private string $_baseDir;
    private string $_domain;

    /**
     * Constructor
     *
     * @param string $serverName The server name to use
     */
    public function __construct(string $serverName)
    {
        $this->_serverName = $serverName;
        $this->_currentDir = getcwd();
        $this->_baseDir = "/home/user1/dev/hosts/$serverName";
        $this->_domain = "$serverName.localhost";
    }

    /**
     * Logs a message with an info emoji
     *
     * @param string $msg The message to log
     *
     * @return void
     */
    private function _logMessage(string $msg): void
    {
        echo "💬 $msg\n";
    }

    /**
     * Logs a message with a wrench emoji
     *
     * @param string $msg The message to log
     *
     * @return void
     */
    private function _shout(string $msg): void
    {
        echo "🔧 $msg\n";
    }

    /**
     * Logs a message with a fire emoji
     *
     * @param string $msg The message to log
     *
     * @return void
     */
    private function _yell(string $msg): void
    {
        echo "🔥 $msg\n";
    }

    /**
     * Runs a shell command
     *
     * @param string $cmd   The command to run
     * @param bool   $check Whether to check the return code
     *
     * @return array The command output
     */
    private function _run(string $cmd, bool $check = true): array
    {
        $this->_shout("Running: $cmd");
        exec("$cmd 2>&1", $output, $returnCode);

        if ($returnCode !== 0) {
            $this->_yell("🚨 Command failed with return code: $returnCode");
            $this->_yell("Error output:");
            foreach ($output as $line) {
                echo "   $line\n";
            }
            if ($check) {
                exit(1);
            }
        }
        return $output;
    }

    /**
     * Downloads and sets up the repository
     *
     * @return void
     */
    private function _setupRepository(): void
    {
        $this->_logMessage("📦 Setting up repository...");
        $repoDir = "{$this->_currentDir}/_hypership_repo_{$this->_serverName}";

        // Cleanup any existing repo directory
        if (file_exists($repoDir)) {
            $this->_logMessage("🧹 Cleaning up existing repository directory...");
            $this->_run("rm -rf $repoDir");
        }

        // Create fresh repository directory
        $this->_run("mkdir -p $repoDir");

        // Clone the repository
        $this->_logMessage("📥 Downloading repository...");
        $repoUrl = "git@github.com:nofatetech/HyperShipOnline1.git";
        $this->_run("git clone $repoUrl $repoDir");

        $this->_logMessage("✅ Repository setup completed");
        $this->_logMessage("Repository location: $repoDir");
    }

    /**
     * Sets up the plugin
     *
     * @return void
     */
    private function _setupPlugin(): void
    {
        $this->_logMessage("Setting up plugin...");
        $pluginDir = "{$this->_baseDir}/wp-content/plugins/hypershipx";
        $repoDir = "{$this->_currentDir}/_hypership_repo_{$this->_serverName}";
        $pluginSource = "$repoDir/wordpress_plugin/hypershipx";

        // Check if plugin source exists
        if (!file_exists($pluginSource)) {
            $this->_yell("Plugin source not found at: $pluginSource");
            $this->_yell("Please ensure the plugin is in the wordpress_plugin/hypershipx directory");
            exit(1);
        }

        // Create plugin directory with sudo
        $this->_run("sudo mkdir -p $pluginDir");
        $this->_run("sudo chown -R www-data:www-data $pluginDir");
        $this->_run("sudo chmod -R 755 $pluginDir");

        // Create symlink from plugin source to plugin directory
        $this->_run("sudo ln -sf $pluginSource/* $pluginDir/");

        // Ensure proper ownership of the symlink
        $this->_run("sudo chown -R www-data:www-data $pluginDir");

        $this->_logMessage("✅ Plugin setup completed");
        $this->_logMessage("Plugin source: $pluginSource");
        $this->_logMessage("Plugin target: $pluginDir");
    }

    /**
     * Sets up WordPress installation with tables and admin user
     *
     * @return void
     */
    private function _setupWordPress(): void
    {
        $this->_logMessage("Setting up WordPress installation...");

        // Check if wp-cli is installed
        exec('which wp', $output, $returnCode);
        if ($returnCode !== 0) {
            $this->_yell("wp-cli is not installed. Please install it first.");
            exit(1);
        }

        // Generate a random password
        $adminPassword = bin2hex(random_bytes(8)); // 16 characters of random hex
        $adminPassword = "172s31s23d1g2s3JDdjjSHyhdNDhdhDJnsgSj9d6!";

        // Set up WordPress using wp-cli
        $this->_logMessage("Creating WordPress installation...");
        $this->_run("cd {$this->_baseDir} && wp core install --url=http://{$this->_domain} --title='WordPress Site' --admin_user=admin --admin_password='$adminPassword' --admin_email=admin@{$this->_domain} --skip-email");

        // Store the password in a JSON file for reference
        $dataDir = "{$this->_currentDir}/_hypership_data_{$this->_serverName}";
        $passwordFile = "$dataDir/credentials.json";

        // Create data directory if it doesn't exist
        if (!file_exists($dataDir)) {
            $this->_run("mkdir -p $dataDir");
        }

        // Ensure directory is writable
        $this->_run("sudo chown -R www-data:www-data $dataDir");
        $this->_run("sudo chmod -R 755 $dataDir");

        // Write password file using sudo
        $credentials = [
            'admin' => [
                'username' => 'admin',
                'password' => $adminPassword,
                'email' => "admin@{$this->_domain}",
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Create a temporary file with the credentials
        $tmpFile = "/tmp/hypership_credentials.json";
        file_put_contents($tmpFile, json_encode($credentials, JSON_PRETTY_PRINT));

        // Move the file to the final location with sudo
        $this->_run("sudo mv $tmpFile $passwordFile");
        $this->_run("sudo chown www-data:www-data $passwordFile");
        $this->_run("sudo chmod 600 $passwordFile");

        $this->_logMessage("✅ WordPress installation completed");
        $this->_logMessage("Admin username: admin");
        $this->_logMessage("Admin password has been saved to: $passwordFile");
    }

    /**
     * Creates sample posts for demonstration
     *
     * @return void
     */
    public function createSamplePosts(): void
    {
        $this->_logMessage("Creating sample posts...");

        // Create the backend app
        $this->_logMessage("Creating backend app...");
        $this->_run("cd {$this->_baseDir} && wp post create --post_type=hypership-app --post_title='My First Hyper App Backend' --post_status=publish");

        // Get the app ID
        $appId = $this->_run("cd {$this->_baseDir} && wp post list --post_type=hypership-app --format=ids")[0];

        // Create routes for the app
        $routes = array('serious-stuff', 'fun-stuff');
        foreach ($routes as $route) {
            $this->_logMessage("Creating route: $route");
            $this->_run("cd {$this->_baseDir} && wp post create --post_type=hypership-route --post_title='$route' --post_status=publish --post_parent=$appId");
        }

        // Create the frontend app
        $this->_logMessage("Creating frontend app...");
        $this->_run("cd {$this->_baseDir} && wp post create --post_type=hypership-frapp --post_title='My First Hyper App' --post_status=publish");

        $this->_logMessage("✅ Sample posts created successfully");
    }

    /**
     * Displays the installation summary
     *
     * @return void
     */
    private function _displaySummary(): void
    {
        // Read the admin credentials from JSON file
        $dataDir = "{$this->_currentDir}/_hypership_data_{$this->_serverName}";
        $passwordFile = "$dataDir/credentials.json";
        $adminUsername = 'admin';
        $adminPassword = 'Password file not found';
        $adminEmail = "admin@{$this->_domain}";

        if (!file_exists($dataDir)) {
            $this->_yell("Data directory not found: $dataDir");
        } elseif (!file_exists($passwordFile)) {
            $this->_yell("Credentials file not found: $passwordFile");
        } else {
            $content = file_get_contents($passwordFile);
            if ($content === false) {
                $this->_yell("Failed to read credentials file: $passwordFile");
            } else {
                $credentials = json_decode($content, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $this->_yell("Invalid JSON in credentials file: " . json_last_error_msg());
                } elseif (isset($credentials['admin'])) {
                    $adminUsername = $credentials['admin']['username'];
                    $adminPassword = $credentials['admin']['password'];
                    $adminEmail = $credentials['admin']['email'];
                } else {
                    $this->_yell("Admin credentials not found in JSON file");
                }
            }
        }

        echo "\n";
        echo "    ╭───────────────────────────────────────────────────────────────╮\n";
        echo "    │  🚀  HyperShipX Installation Complete!  🚀                    │\n";
        echo "    ╰───────────────────────────────────────────────────────────────╯\n\n";

        echo "    📡  Quick Links\n";
        echo "       ─────────────\n";
        echo "       Frontend: http://{$this->_domain}/\n";
        echo "       Admin:    http://{$this->_domain}/wp-admin\n";
        echo "       API:      http://{$this->_domain}/wp-json\n\n";

        echo "    🔐  Admin Credentials\n";
        echo "       ─────────────────\n";
        echo "       Username: $adminUsername\n";
        echo "       Password: $adminPassword\n";
        echo "       Email:    $adminEmail\n\n";

        echo "    📁  Project Structure\n";
        echo "       ─────────────────\n";
        echo "       Root:     {$this->_baseDir}\n";
        echo "       Plugin:   {$this->_baseDir}/wp-content/plugins/hypershipx\n";
        echo "       Config:   {$this->_baseDir}/wp-config.php\n";
        echo "       Data:     $dataDir\n\n";

        echo "    ⚡  Getting Started\n";
        echo "       ───────────────\n";
        echo "       1. Log in to wp-admin\n";
        echo "       2. Activate the HyperShipX plugin\n";
        echo "       3. Create your first Hyper App\n";
        echo "       4. Start building your routes\n\n";

        echo "    ╭───────────────────────────────────────────────────────────────╮\n";
        echo "    │  🎮  Ready to HyperShip?  🎮                                 │\n";
        echo "    │                                                               │\n";
        echo "    │  ██╗  ██╗██╗   ██╗██████╗ ███████╗███████╗██╗  ██╗██╗██████╗  │\n";
        echo "    │  ██║  ██║╚██╗ ██╔╝██╔══██╗██╔════╝██╔════╝██║  ██║██║██╔══██╗ │\n";
        echo "    │  ███████║ ╚████╔╝ ██████╔╝█████╗  ███████╗███████║██║██████╔╝ │\n";
        echo "    │  ██╔══██║  ╚██╔╝  ██╔═══╝ ██╔══╝  ╚════██║██╔══██║██║██╔═══╝  │\n";
        echo "    │  ██║  ██║   ██║   ██║     ███████╗███████║██║  ██║██║██║      │\n";
        echo "    │  ╚═╝  ╚═╝   ╚═╝   ╚═╝     ╚══════╝╚══════╝╚═╝  ╚═╝╚═╝╚═╝      │\n";
        echo "    │                                                               │\n";
        echo "    │  Remember to save your credentials somewhere safe!            │\n";
        echo "    ╰───────────────────────────────────────────────────────────────╯\n";
        echo "\n";
    }

    /**
     * Verifies and fixes MySQL permissions
     *
     * @return void
     */
    private function _verifyMySQLPermissions(): void
    {
        $this->_logMessage("🔍 Verifying MySQL permissions...");

        // Try to connect with the new user
        $testCmd = "mysql -u {$this->_serverName} -p'gK9b%qA1O&!0rv-M' -e 'USE {$this->_serverName};' 2>&1";
        exec($testCmd, $output, $returnCode);

        if ($returnCode !== 0) {
            $this->_logMessage("⚠️ MySQL permissions need fixing...");

            // Fix permissions using root
            $fixCmd = "mysql -u root -p'Abc123123123!' -e \"GRANT ALL PRIVILEGES ON {$this->_serverName}.* TO '{$this->_serverName}'@'localhost'; FLUSH PRIVILEGES;\" 2>&1";
            $this->_run($fixCmd);

            // Verify again
            exec($testCmd, $output, $returnCode);
            if ($returnCode !== 0) {
                $this->_yell("Failed to fix MySQL permissions. Please check MySQL configuration.");
                $this->_yell("Error details:");
                foreach ($output as $line) {
                    echo "   $line\n";
                }
                exit(1);
            }
        }

        $this->_logMessage("✅ MySQL permissions verified");
    }

    /**
     * Runs the complete installation process
     *
     * @return void
     */
    public function install(): void
    {
        // Check if newsite.php exists
        $newsitePath = "{$this->_currentDir}/newsite.php";
        if (!file_exists($newsitePath)) {
            $this->_yell("newsite.php not found at: $newsitePath");
            $this->_yell("Please ensure newsite.php is in the same directory as install.php");
            exit(1);
        }

        die("here");

        // Check if newsite.php is executable
        if (!is_executable($newsitePath)) {
            $this->_logMessage("Making newsite.php executable...");
            $this->_run("chmod +x $newsitePath");
        }

        // Step 1: Run newsite.php to create WordPress/Laravel installation
        $this->_logMessage("Creating new site using newsite.php...");
        $this->_logMessage("Full path: $newsitePath");

        // Run newsite.php directly to allow interactive input
        $cmd = "php -f $newsitePath {$this->_serverName}";
        $this->_shout("Running: $cmd");

        // Use passthru to allow interactive input
        passthru($cmd, $returnCode);

        if ($returnCode !== 0) {
            $this->_yell("newsite.php failed with return code: $returnCode");

            // If it failed due to MySQL permissions, try to fix them
            $this->_verifyMySQLPermissions();

            // Try running newsite.php again
            $this->_logMessage("Retrying newsite.php after fixing permissions...");
            passthru($cmd, $returnCode);
            if ($returnCode !== 0) {
                $this->_yell("newsite.php still failed after fixing permissions");
                exit(1);
            }
        }

        // Step 2: Set up repository
        $this->_setupRepository();

        // Step 3: Set up plugin
        $this->_setupPlugin();

        // Step 4: Set up WordPress installation
        $this->_setupWordPress();

        // Step 5: Create sample posts
        $this->createSamplePosts();

        // Display summary
        $this->_displaySummary();
    }
}

// Check command line arguments
if ($argc < 2) {
    die("Usage: php install.php <server_name> [seed]\n");
}

// Run the installer
$installer = new HyperShipXSecondaryInstaller($argv[1]);

// Check if we should only run the seed command
if (isset($argv[2]) && $argv[2] === 'seed') {
    $installer->createSamplePosts();
} else {
    $installer->install();
}

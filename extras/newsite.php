#!/usr/bin/env php
<?php
/**
 * WebApp Bootstraptor 2000
 * A PHP script to bootstrap Laravel and WordPress projects
 *
 * @category  WebApp
 * @package   WebAppBootstraptor
 * @author    Developer <developer@example.com>
 * @license   https://opensource.org/licenses/MIT MIT
 * @link      https://github.com/yourusername/webapp-bootstraptor
 */

/**
 * Logs a message with an info emoji
 *
 * @param  string $msg The message to log
 *
 * @return void
 */
function logMessage($msg)
{
    echo "💬 $msg\n";
}

/**
 * Logs a message with a wrench emoji
 *
 * @param  string $msg The message to log
 *
 * @return void
 */
function shout($msg)
{
    echo "🔧 $msg\n";
}

/**
 * Logs a message with a fire emoji
 *
 * @param  string $msg The message to log
 *
 * @return void
 */
function yell($msg)
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
function run($cmd, $check = true)
{
    shout("Running: $cmd");
    exec("$cmd 2>&1", $output, $returnCode);

    if ($returnCode !== 0) {
        yell("🚨 Command failed with return code: $returnCode");
        yell("Error output:");
        foreach ($output as $line) {
            echo "   $line\n";
        }
        if ($check) {
            exit(1);
        }
    }
    return $output;
}

function writeFile($path, $content) {
    file_put_contents($path, $content);
    logMessage("📄 Wrote file: $path");
}

function createDatabase($dbName, $dbUser, $dbPassword, $mysqlRootPassword)
{
    logMessage("💾 Creating MySQL database...");

    // Check if MySQL is running
    exec("systemctl is-active mysql", $output, $returnCode);
    if ($returnCode !== 0) {
        logMessage("🔄 Starting MySQL service...");
        run("sudo systemctl start mysql");
        sleep(2); // Give MySQL time to start
    }

    // First, try to connect to MySQL to verify root access
    $testConnection = "mysql -u root -p'$mysqlRootPassword' -e 'SELECT 1;'";
    exec($testConnection, $output, $returnCode);
    if ($returnCode !== 0) {
        yell("Failed to connect to MySQL with root user. Please verify your root password.");
        exit(1);
    }

    $sql = <<<SQL
CREATE DATABASE IF NOT EXISTS `$dbName`;
CREATE USER IF NOT EXISTS '$dbUser'@'localhost' IDENTIFIED BY '$dbPassword';
GRANT ALL PRIVILEGES ON `$dbName`.* TO '$dbUser'@'localhost';
FLUSH PRIVILEGES;
SQL;

    logMessage("🔍 SQL Command:");
    echo $sql . "\n";

    // Write SQL to temporary file
    $tmpSql = "/tmp/create_db.sql";
    writeFile($tmpSql, $sql);

    // Execute SQL commands directly
    $commands = [
        "mysql -u root -p'$mysqlRootPassword' -e \"CREATE DATABASE IF NOT EXISTS \`$dbName\`;\"",
        "mysql -u root -p'$mysqlRootPassword' -e \"CREATE USER IF NOT EXISTS '$dbUser'@'localhost' IDENTIFIED BY '$dbPassword';\"",
        "mysql -u root -p'$mysqlRootPassword' -e \"GRANT ALL PRIVILEGES ON \`$dbName\`.* TO '$dbUser'@'localhost';\"",
        "mysql -u root -p'$mysqlRootPassword' -e \"FLUSH PRIVILEGES;\""
    ];

    foreach ($commands as $cmd) {
        exec($cmd, $output, $returnCode);
        if ($returnCode !== 0) {
            yell("Failed to execute MySQL command: $cmd");
            unlink($tmpSql);
            exit(1);
        }
    }

    unlink($tmpSql);

    // Verify database was created and user can connect
    $verifyCmd = "mysql -u $dbUser -p'$dbPassword' -e 'USE `$dbName`;'";
    exec($verifyCmd, $output, $returnCode);
    if ($returnCode !== 0) {
        yell("Database creation verification failed. Please check MySQL logs for details.");
        exit(1);
    }

    logMessage("✅ Database setup completed successfully");
}

/**
 * Generates a secure random password
 *
 * @param int $length Length of the password
 *
 * @return string
 */
function generateSecurePassword($length = 16)
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=[]{}|;:,.<>?';
    $password = '';
    $max = strlen($chars) - 1;

    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, $max)];
    }

    return $password;
}

/**
 * Sets up a new project (Laravel or WordPress)
 *
 * @param string $appName         The application name
 * @param string $appType         The application type (laravel or wordpress)
 * @param string $dbName          The database name
 * @param string $dbUser          The database user
 * @param string $dbPassword      The database password
 * @param string $mysqlRootPassword The MySQL root password
 *
 * @return void
 */
function setupProject($appName, $appType, $dbName, $dbUser, $dbPassword, $mysqlRootPassword)
{
    $baseDir = "/home/user1/dev/hosts/$appName";
    $domain = "$appName.localhost";
    $apacheVhost = "/etc/apache2/sites-available/$domain.conf";
    $publicDir = "$baseDir/public";

    logMessage("🔨 Creating project directory");
    if (!file_exists($baseDir)) {
        mkdir($baseDir, 0755, true);
    }

    logMessage("🔐 Setting up database");
    createDatabase($dbName, $dbUser, $dbPassword, $mysqlRootPassword);

    if ($appType == "laravel") {
        logMessage("🧬 Installing Laravel via Composer");
        run("composer create-project laravel/laravel $baseDir");

        $envPath = "$baseDir/.env";
        run("cp $baseDir/.env.example $envPath");

        // Configure database settings
        logMessage("🔧 Configuring database settings...");
        $envContent = file_get_contents($envPath);
        $envContent = preg_replace('/DB_CONNECTION=.*/', 'DB_CONNECTION=mysql', $envContent);
        $envContent = preg_replace('/DB_HOST=.*/', 'DB_HOST=127.0.0.1', $envContent);
        $envContent = preg_replace('/DB_PORT=.*/', 'DB_PORT=3306', $envContent);
        $envContent = preg_replace('/DB_DATABASE=.*/', "DB_DATABASE=$dbName", $envContent);
        $envContent = preg_replace('/DB_USERNAME=.*/', "DB_USERNAME=$dbUser", $envContent);
        $envContent = preg_replace('/DB_PASSWORD=.*/', "DB_PASSWORD=$dbPassword", $envContent);

        // Set cache driver to file to avoid database dependency
        $envContent = preg_replace('/CACHE_DRIVER=.*/', 'CACHE_DRIVER=file', $envContent);
        $envContent = preg_replace('/SESSION_DRIVER=.*/', 'SESSION_DRIVER=file', $envContent);
        $envContent = preg_replace('/QUEUE_CONNECTION=.*/', 'QUEUE_CONNECTION=sync', $envContent);

        file_put_contents($envPath, $envContent);

        // Verify database connection before proceeding
        logMessage("🔍 Verifying database connection...");
        $testConnection = "mysql -u $dbUser -p'$dbPassword' -e 'USE `$dbName`;'";
        exec($testConnection, $output, $returnCode);
        if ($returnCode !== 0) {
            yell("Failed to connect to database with provided credentials. Please check your database settings.");
            exit(1);
        }

        // Clear any cached configuration
        logMessage("🧹 Clearing configuration cache...");
        if (file_exists("$baseDir/bootstrap/cache/config.php")) {
            unlink("$baseDir/bootstrap/cache/config.php");
        }

        // Generate application key
        run("cd $baseDir && php artisan key:generate");

        echo "⚗️ Run migrations? [y/N]: ";
        if (strtolower(trim(fgets(STDIN))) == 'y') {
            // Wait a moment for MySQL to be ready
            sleep(2);

            // Check Laravel installation
            logMessage("🔍 Checking Laravel installation...");
            run("cd $baseDir && php artisan --version", false);

            // Verify .env file contents
            logMessage("🔍 Verifying .env configuration...");
            run("cd $baseDir && cat .env | grep DB_", false);

            // Clear Laravel's config cache
            logMessage("🧹 Clearing Laravel caches...");
            run("cd $baseDir && php artisan config:clear", false);
            run("cd $baseDir && php artisan cache:clear", false);
            run("cd $baseDir && php artisan view:clear", false);
            run("cd $baseDir && php artisan route:clear", false);

            // Run migrations with verbose output
            logMessage("🔄 Running database migrations...");
            run("cd $baseDir && php artisan migrate --verbose --force", false);

            // Check migration status
            logMessage("🔍 Checking migration status...");
            run("cd $baseDir && php artisan migrate:status", false);
        }

        logMessage("🧙 Fixing permissions for Laravel");
        run("sudo chown -R www-data:www-data $baseDir/storage $baseDir/bootstrap/cache", false);
        run("sudo chmod -R 775 $baseDir/storage $baseDir/bootstrap/cache", false);
    } elseif ($appType == "wordpress") {
        logMessage("🕸️ Downloading WordPress");
        run("wget https://wordpress.org/latest.zip -O /tmp/wp.zip");
        run("unzip /tmp/wp.zip -d /tmp/");
        run("mv /tmp/wordpress/* $baseDir/");
        run("rm -rf /tmp/wordpress /tmp/wp.zip");

        // Verify database connection before proceeding
        logMessage("🔍 Verifying database connection...");
        $testConnection = "mysql -u $dbUser -p'$dbPassword' -e 'USE `$dbName`;'";
        exec($testConnection, $output, $returnCode);
        if ($returnCode !== 0) {
            yell("Failed to connect to database with provided credentials. Please check your database settings.");
            exit(1);
        }

        // Check if wp-cli is installed
        exec('which wp', $output, $returnCode);
        if ($returnCode !== 0) {
            yell("wp-cli is not installed. Please install it first.");
            exit(1);
        }

        // Generate a random password for admin
        $adminPassword = generateSecurePassword();

        // Configure WordPress using wp-cli
        logMessage("🔧 Configuring WordPress...");
        run("cd $baseDir && wp config create --dbname=$dbName --dbuser=$dbUser --dbpass='$dbPassword' --dbhost=127.0.0.1 --skip-check");

        // Set up WordPress installation
        logMessage("🚀 Setting up WordPress installation...");
        run("cd $baseDir && wp core install --url=http://$domain --title='WordPress Site' --admin_user=admin --admin_password='$adminPassword' --admin_email=admin@$domain --skip-email");

        // Store the admin password
        $passwordFile = "$baseDir/wp-admin-password.txt";
        file_put_contents($passwordFile, "WordPress Admin Password: $adminPassword\n");
        run("chmod 600 $passwordFile");

        // Enable debugging
        run("cd $baseDir && wp config set WP_DEBUG true --raw");
        run("cd $baseDir && wp config set WP_DEBUG_LOG true --raw");

        logMessage("🧙 Fixing permissions for WordPress");
        run("sudo chown -R www-data:www-data $baseDir");
        run("sudo chmod -R 755 $baseDir");
    } else {
        yell("❌ Unknown app type");
        return;
    }

    logMessage("🛰️ Writing Apache vhost");
    $docRoot = ($appType == "laravel") ? $publicDir : $baseDir;
    $vhost = <<<VHOST
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    ServerName $domain
    DocumentRoot $docRoot

    <Directory "$docRoot">
        Options FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
VHOST;

    $tmpVhost = "/tmp/$domain.conf";
    writeFile($tmpVhost, $vhost);
    run("sudo mv $tmpVhost $apacheVhost");
    run("sudo a2ensite $domain.conf");
    run("sudo apache2ctl configtest");
    run("sudo systemctl reload apache2");

    $hostsLine = "127.0.0.1       $domain";
    $hosts = file_get_contents("/etc/hosts");
    if (strpos($hosts, $hostsLine) === false) {
        run("echo \"$hostsLine\" | sudo tee -a /etc/hosts");
    }

    logMessage("✅ Setup complete!");
    echo "📡 Visit your site: http://$domain/\n";
    echo "🔐 Database credentials:\n";
    echo "   Database: $dbName\n";
    echo "   Username: $dbUser\n";
    echo "   Password: $dbPassword\n";
    echo "   Root Password: $mysqlRootPassword\n";
}

// Get app name from command line argument
$appName = isset($argv[1]) ? trim($argv[1]) : null;

if (!$appName) {
    echo "❌ Please provide an app name as a command line argument.\n";
    echo "Usage: php newsite.php <appname>\n";
    exit(1);
}

echo "🌍 WebApp Bootstraptor 2000 🤖\n";
echo "✨ 'There's no place like 127.0.0.1' ✨\n\n";

echo "📦 App type:\n";
echo "   1. Laravel\n";
echo "   2. WordPress\n";
echo "   Select [1/2]: ";
$appTypeChoice = trim(fgets(STDIN));
$appType = ($appTypeChoice == "2") ? "wordpress" : "laravel";

echo "🔐 MySQL root password [Abc123123123!]: ";
$mysqlRoot = trim(fgets(STDIN));
if (empty($mysqlRoot)) {
    $mysqlRoot = "Abc123123123!";
}

// Generate secure passwords
$dbPassword = generateSecurePassword();
echo "🔐 Generated secure database password: $dbPassword\n\n";

// Use app name for database name and user
$dbName = $appName;
$dbUser = $appName;

setupProject($appName, $appType, $dbName, $dbUser, $dbPassword, $mysqlRoot);

// Display summary with cool ASCII art
echo "\n";
echo "    ╭───────────────────────────────────────────────╮\n";
echo "    │  🎉  Setup Complete!  🎉                      │\n";
echo "    ╰───────────────────────────────────────────────╯\n\n";

echo "    📡  Site URL: http://$appName.localhost/\n\n";

echo "    🔐  Database Credentials\n";
echo "       ─────────────────────\n";
echo "       Database: $dbName\n";
echo "       Username: $dbUser\n";
echo "       Password: $dbPassword\n";
echo "       Root Password: $mysqlRoot\n\n";

echo "    📁  Project Directory\n";
echo "       ─────────────────\n";
echo "       /home/user1/dev/hosts/$appName\n\n";

echo "    ⚙️   Apache Config\n";
echo "       ──────────────\n";
echo "       /etc/apache2/sites-available/$appName.localhost.conf\n\n";

echo "    ╭─────────────────────────────╮\n";
echo "    │  🚀 Happy Coding! 🚀        │\n";
echo "    │  Remember to save these     │\n";
echo "    │  credentials somewhere safe │\n";
echo "    ╰─────────────────────────────╯\n";
echo "\n";

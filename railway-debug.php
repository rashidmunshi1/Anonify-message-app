<?php
// Railway Database Connection Debug Script

echo "=== Railway Database Connection Debug ===\n";

// Check environment variables
echo "APP_ENV: " . getenv('APP_ENV') . "\n";
echo "DB_HOST: " . getenv('DB_HOST') . "\n";  
echo "DB_PORT: " . getenv('DB_PORT') . "\n";
echo "DB_DATABASE: " . getenv('DB_DATABASE') . "\n";
echo "DB_USERNAME: " . getenv('DB_USERNAME') . "\n";
echo "DB_PASSWORD: " . (getenv('DB_PASSWORD') ? '[SET]' : '[NOT SET]') . "\n";
echo "DATABASE_URL: " . (getenv('DATABASE_URL') ? '[SET]' : '[NOT SET]') . "\n";

// Test basic connection
try {
    $host = getenv('DB_HOST');
    $port = getenv('DB_PORT');
    $database = getenv('DB_DATABASE');
    $username = getenv('DB_USERNAME');
    $password = getenv('DB_PASSWORD');
    
    if (!$host || !$port || !$database || !$username) {
        echo "ERROR: Missing database credentials\n";
        exit(1);
    }
    
    $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_TIMEOUT => 30,
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
    ];
    
    echo "Attempting connection to: $host:$port/$database\n";
    
    $pdo = new PDO($dsn, $username, $password, $options);
    echo "✅ Database connection successful!\n";
    
    $stmt = $pdo->query('SELECT VERSION() as version');
    $result = $stmt->fetch();
    echo "MySQL Version: " . $result['version'] . "\n";
    
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    
    // Try with DATABASE_URL if individual vars fail
    $databaseUrl = getenv('DATABASE_URL');
    if ($databaseUrl) {
        try {
            echo "Trying with DATABASE_URL...\n";
            $pdo = new PDO($databaseUrl, null, null, $options);
            echo "✅ DATABASE_URL connection successful!\n";
        } catch (Exception $e2) {
            echo "❌ DATABASE_URL also failed: " . $e2->getMessage() . "\n";
        }
    }
}
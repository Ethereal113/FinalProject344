<?php
require_once __DIR__ . '/Database.php';

class RealEstateDatabase {
    private $conn;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function addUser(string $userName, string $contactInfo, string $passwordHash, string $userType): bool {
        $sql = "INSERT INTO users (userName, contactInfo, passwordHash, userType)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss",  $userName, $contactInfo, $passwordHash, $userType);
            $stmt->execute();
            $result = $stmt->get_result();
            if(!$result){
            return False;
            }
        return True;
    }

    public function getUserByUsername(string $userName) {
        // Retrieve one user by username.
        $sql = "SELECT * FROM users WHERE userName = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $userName);
        try {
            $stmt->execute();
            $result = $stmt->get_result();
        } catch(mysqli_sql_exception $exception) {
            echo "<h3 style='text-align:center; color:red; font-size:25px'>Error: " . $exception->getMessage(); "</h3>";
            echo "<br>";
            echo "<a href='dashboard.php'>Go back</a>";
        }
        return mysqli_fetch_array($result);
    }

    public function addProperty(string $title, string $propertyType, string $address, string $city, float $price, string $status, int $agentId): bool {
        $sql = "INSERT INTO properties (title, propertyType, address, city, price, status, agentID)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssdsi", $title, $propertyType, $address, $city, $price, $status, $agentId);
            $stmt->execute();
            $result = $stmt->get_result();
            if (!$result) {
                return False;
                }
            return True;
    }

    public function getAllProperties(): array {
        // TODO: Optionally replace this with the PropertyListingView.
        $sql = "SELECT p.*, u.userName AS agentName
                FROM properties p
                JOIN users u ON p.agentID = u.userID
                ORDER BY p.propertyID DESC";
        $result = mysqli_query($this->conn, $sql);
        if(!$result) {
            return [];
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPropertyById(int $propertyId) {
        $sql = "SELECT p.*, u.userName AS agentName
                FROM properties p
                JOIN users u ON p.agentID = u.userID
                WHERE p.propertyID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $propertyId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function addInquiry(int $userId, int $propertyId, string $message): bool {
        $sql = "INSERT INTO inquiries (userID, propertyID, message, inquiryDate)
                VALUES (?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('iis', $userId, $propertyId, $message);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    public function getUserDetails(int $userId) {
        // TODO:
        // Expand this function so it returns the user plus their related
        // inquiries, favorites, or transactions.
        $sql = "SELECT u.*, i.*, f.*, t.* FROM users u INNER JOIN inquiries i ON u.userID = i.userID INNER JOIN favorites f ON i.userID = f.userID INNER JOIN transactions t ON f.userID = t.userID WHERE u.userID = :userID";
        $stmt = $this->conn->prepare($sql);
        $result = mysqli_query($conn, $sql);
        return mysqli_fetch_array($result);
    }

    public function getPropertiesByCity(string $city): array {
        $sql = "SELECT * FROM properties WHERE city = :city";
        $stmt = $this->conn->prepare($sql);
        $result = mysqli_query($conn, $sql);
        return mysqli_fetch_array($result);
    }
}
?>
<?php
include 'database.php';

// Pagination settings
$limit = 5; // Show 5 entrepreneurs per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page or set default to 1
$offset = ($page - 1) * $limit; // Calculate offset

// Get total investment amount
$totalInvestmentQuery = "SELECT SUM(amount_invested) AS total_investment FROM investments";
$totalResult = $conn->query($totalInvestmentQuery);
$totalInvestment = 0;

if ($totalResult->num_rows > 0) {
    $row = $totalResult->fetch_assoc();
    $totalInvestment = $row['total_investment'];
}

// Get total number of entrepreneurs
$totalEntrepreneursQuery = "SELECT COUNT(*) AS total FROM entrepreneurs";
$totalEntrepreneursResult = $conn->query($totalEntrepreneursQuery);
$totalEntrepreneurs = $totalEntrepreneursResult->fetch_assoc()['total'];

// Calculate total pages
$totalPages = ceil($totalEntrepreneurs / $limit);

// Fetch entrepreneurs with pagination
$sql = "SELECT * FROM entrepreneurs LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrepreneurs & Investment</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script>
        function validateInvestment(input, maxAmount) {
            let amount = parseFloat(input.value);
            if (amount > maxAmount) {
                alert("You cannot invest more than ₹" + maxAmount);
                input.value = maxAmount; // Adjust input to max limit
            }
        }
    </script>
</head>
<body>
    <div class="container">
    <div class="total-investment">
        ₹<?php echo number_format($totalInvestment, 2); ?> 
        <div>Total Investment in <strong>Pixels Pixes</strong></div>
    </div>
    </div>
    <!-- ✅ View Total Investment History Button -->
    <div class="investment-history">
        <a href="investment_history.php" class="history-btn">📜 View Investment History</a>
    </div>

    <h2>Entrepreneurs Looking for Investment</h2>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $entrepreneurId = $row['id'];
            $amountNeeded = $row['amount'];
            $crowdfundingType = $row['crowdfunding_type']; // Fetch crowdfunding type

            // Get total investment received for this entrepreneur
            $investmentQuery = "SELECT SUM(amount_invested) AS invested_amount, COUNT(DISTINCT investor_id) AS investor_count FROM investments WHERE entrepreneur_id = $entrepreneurId";
            $investmentResult = $conn->query($investmentQuery);
            $investedAmount = 0;
            $investorCount = 0;

            if ($investmentResult->num_rows > 0) {
                $investmentRow = $investmentResult->fetch_assoc();
                $investedAmount = $investmentRow['invested_amount'] ?? 0;
                $investorCount = $investmentRow['investor_count'] ?? 0;
            }

            // Calculate remaining investment amount
            $remainingAmount = max(0, $amountNeeded - $investedAmount);

            echo "<div class='entrepreneur-card'>";
            echo "<p><strong>Name:</strong> " . htmlspecialchars($row['name']) . "</p>";
            echo "<p><strong>Idea:</strong> " . htmlspecialchars($row['idea']) . "</p>";
            echo "<p><strong>Crowdfunding Type:</strong> <span class='funding-type'>" . htmlspecialchars($crowdfundingType) . "</span></p>"; // Display crowdfunding type
            echo "<p><strong>Amount Needed:</strong> ₹" . number_format($amountNeeded, 2) . "</p>";
            echo "<p><strong>Already Invested:</strong> ₹" . number_format($investedAmount, 2) . "</p>";
            echo "<p><strong>Number of Investors:</strong> " . $investorCount . "</p>";

            // Check if investment goal is reached
            if ($investedAmount >= $amountNeeded) {
                echo "<p class='funded'>✅ Funding Complete</p>";
            } else {
                echo "<form action='invest.php' method='POST'>";
                echo "<input type='hidden' name='entrepreneur_id' value='" . $row['id'] . "'>";
                echo "<input type='number' name='amount' placeholder='Enter investment amount' max='" . $remainingAmount . "' required oninput='validateInvestment(this, $remainingAmount)'>";
                echo "<button type='submit'>Invest</button>";
                echo "</form>";
            }

            echo "</div>";
        }
    } else {
        echo "<p>No entrepreneurs have submitted ideas yet.</p>";
    }

    // Pagination controls
    echo "<div class='pagination'>";
    if ($page > 1) {
        echo "<a href='?page=" . ($page - 1) . "' class='prev'>⬅ Previous</a>";
    }
    if ($page < $totalPages) {
        echo "<a href='?page=" . ($page + 1) . "' class='next'>Next ➡</a>";
    }
    echo "</div>";

    $conn->close();
    ?>

</body>
</html>

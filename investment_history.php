<?php
include 'database.php';
session_start();

if (!isset($_SESSION['investor_id'])) {
    die("<div class='error'>You must be logged in to view your investments.</div>");
}

$investor_id = $_SESSION['investor_id']; 

$sql = "SELECT e.name AS entrepreneur_name, e.idea, i.amount_invested 
        FROM investments i
        JOIN entrepreneurs e ON i.entrepreneur_id = e.id
        WHERE i.investor_id = ?  
        ORDER BY i.id DESC"; 

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $investor_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Investment History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #FAE1DD;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        h2 {
            color: #2F4858;
            text-align: center;
            margin-bottom: 20px;
        }

        .investment-table {
            width: 80%;
            max-width: 600px;
            background-color: #FFFFFF;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #2F4858;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .error {
            color: #2F4858;
            font-size: 18px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h2>Your Investments</h2>

<?php if ($result->num_rows > 0): ?>
    <div class="investment-table">
        <table>
            <tr>
                <th>Entrepreneur</th>
                <th>Idea</th>
                <th>Amount Invested</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['entrepreneur_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['idea']); ?></td>
                    <td>₹<?php echo number_format($row['amount_invested'], 2); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
<?php else: ?>
    <div class="error">You have not made any investments yet.</div>
<?php endif; ?>

<?php
$stmt->close();
$conn->close();
?>

</body>
</html>

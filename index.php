<?php
// --- INCLUDE THE SEPARATED FILES ---
include 'db.php';      // Connects to database
include 'actions.php'; // Handles Search, Add, Edit, Delete logic
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Inventory</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; max-width: 900px; margin: auto; }
        .header { border-bottom: 2px solid black; padding-bottom: 10px; margin-bottom: 20px; font-weight: bold; font-size: 1.1em; }
        .control-panel { display: flex; gap: 30px; margin-bottom: 20px; }
        .form-area { flex: 2; }
        .button-area { flex: 1; display: flex; flex-direction: column; gap: 10px; }
        .input-group { display: flex; margin-bottom: 10px; align-items: center; }
        .input-group label { width: 100px; font-weight: bold; }
        .input-group input { flex: 1; padding: 5px; border: 1px solid #ccc; }
        .btn-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        button { padding: 10px; cursor: pointer; background: #eee; border: 1px solid #999; font-weight: bold; }
        button:hover { background: #ddd; }
        .prompt-box { border: 2px dashed red; background: #fff5f5; color: #cc0000; padding: 10px; text-align: center; font-weight: bold; margin-top: 10px; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; border: 2px solid black; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background-color: #ccc; }
    </style>
</head>
<body>

    <div class="header">
        NAME: Natasha Nina Garin
    </div>

    <form method="POST">
        <div class="control-panel">
            <div class="form-area">
                <div class="input-group"><label>ISBN #:</label><input type="text" name="isbn" value="<?php echo htmlspecialchars($isbn); ?>"></div>
                <div class="input-group"><label>Title:</label><input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>"></div>
                <div class="input-group"><label>Copyright:</label><input type="text" name="copyright" value="<?php echo htmlspecialchars($copyright); ?>"></div>
                <div class="input-group"><label>Edition:</label><input type="text" name="edition" value="<?php echo htmlspecialchars($edition); ?>"></div>
                <div class="input-group"><label>Price:</label><input type="text" name="price" value="<?php echo htmlspecialchars($price); ?>"></div>
                <div class="input-group"><label>Quantity:</label><input type="text" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>"></div>
            </div>

            <div class="button-area">
                <div class="btn-grid">
                    <button type="submit" name="btn_search">SEARCH</button>
                    <button type="submit" name="btn_edit">EDIT</button>
                    <button type="submit" name="btn_delete">DELETE</button>
                    <button type="submit" name="btn_add">ADD</button>
                </div>
                <div class="prompt-box">
                    <?php echo $message; ?>
                </div>
            </div>
        </div>
    </form>

    <table>
        <thead>
            <tr>
                <th>ISBN</th><th>Title</th><th>Copyright</th><th>Edition</th><th>Price</th><th>Quantity</th><th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // We can run a fresh query here to display the table data
            $sql = "SELECT * FROM books";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $total = $row['price'] * $row['quantity'];
                    echo "<tr>
                        <td>{$row['isbn']}</td>
                        <td>{$row['title']}</td>
                        <td>{$row['copyright']}</td>
                        <td>{$row['edition']}</td>
                        <td>" . number_format($row['price'], 2) . "</td>
                        <td>{$row['quantity']}</td>
                        <td>" . number_format($total, 2) . "</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
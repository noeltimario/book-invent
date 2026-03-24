<?php
// Initialize variables to avoid "Undefined Variable" errors
$isbn = $title = $copyright = $edition = $price = $quantity = "";
$message = "PROMPT: WAITING FOR ACTION";

// Only run this code if a form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Collect Input Data
    $isbn = $_POST['isbn'] ?? '';
    $title = $_POST['title'] ?? '';
    $copyright = $_POST['copyright'] ?? '';
    $edition = $_POST['edition'] ?? '';
    $price = $_POST['price'] ?? 0;
    $quantity = $_POST['quantity'] ?? 0;

    // --- LOGIC SEPARATION START ---

    // 2. SEARCH LOGIC
    if (isset($_POST['btn_search'])) {
        $sql = "SELECT * FROM books WHERE isbn='$isbn'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Fill variables to repopulate the HTML form
            $title = $row['title'];
            $copyright = $row['copyright'];
            $edition = $row['edition'];
            $price = $row['price'];
            $quantity = $row['quantity'];
            $message = "PROMPT: RECORD FOUND";
        } else {
            $message = "PROMPT: RECORD NOT FOUND";
        }
    }

    // 3. ADD LOGIC
    elseif (isset($_POST['btn_add'])) {
        if (!empty($isbn)) {
            $sql = "INSERT INTO books (isbn, title, copyright, edition, price, quantity) 
                    VALUES ('$isbn', '$title', '$copyright', '$edition', '$price', '$quantity')";
            
            if ($conn->query($sql) === TRUE) {
                $message = "PROMPT: RECORD ADDED SUCCESSFULLY";
                // Clear form after add
                $isbn = $title = $copyright = $edition = $price = $quantity = ""; 
            } else {
                $message = "PROMPT: DUPLICATE ISBN OR ERROR";
            }
        } else {
            $message = "PROMPT: ISBN IS REQUIRED";
        }
    }

    // 4. EDIT LOGIC
    elseif (isset($_POST['btn_edit'])) {
        $sql = "UPDATE books SET 
                title='$title', copyright='$copyright', edition='$edition', price='$price', quantity='$quantity' 
                WHERE isbn='$isbn'";
        
        if ($conn->query($sql) === TRUE) {
            $message = "PROMPT: RECORD UPDATED";
        } else {
            $message = "PROMPT: ERROR UPDATING RECORD";
        }
    }

    // 5. DELETE LOGIC
    elseif (isset($_POST['btn_delete'])) {
        $sql = "DELETE FROM books WHERE isbn='$isbn'";
        $conn->query($sql);
        
        if ($conn->affected_rows > 0) {
            $message = "PROMPT: RECORD DELETED";
            // Clear form after delete
            $isbn = $title = $copyright = $edition = $price = $quantity = ""; 
        } else {
            $message = "PROMPT: NO RECORD TO DELETE";
        }
    }
}
?>
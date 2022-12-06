<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/book-model2.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/models/user.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/sanitising.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/validation.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/views/card-grid-view.php');
// $emailErr = "";
// $passwordErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $bookModel = new BookModel();

    $location = sanitising\validateInput($_POST["location"]);

    $locationID = $bookModel->getShopIDFromName($location);
    if ($locationID == 0) {
        echo 'location invalid';
        return;
    }

    $LocalStock = $bookModel->getAllStockFromLocation($locationID);
    if (count($LocalStock) > 0) {

        echo '<section class="book-grid">';

        foreach ($LocalStock as $stock) {
            $book = $bookModel->getBookInformationUsingID($stock->book_id);
            echo ' <div class="book">
                        <img src="/images/Book.png" alt="A vector drawing of a book" title="' . $book[0]->description . '">
                        <h3>' . $book[0]->author . '</h3>
                        <h4>' . $book[0]->name . '</h4>
                        <h5>Quantity' . $stock->book_quantity . '</h5>
                        
                        
                        <form>
                            <label for="quantity">Quantity (between 1 and ' . $stock->book_quantity . '):</label>
                            <input required type="number" id="quantity" name="quantity" min="1" max="' . $stock->book_quantity . '">
                            <input type="submit" value="add to basket">
                        </form>
                    </div>';
        }
        //TODO the form functionality still needs implemented for each card.
        //This could be adding items to a basket

        echo '</section>';
    } else {
        echo 'There are no books at this location';
    }
}

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/models/book.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/stock.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/private/connection.php');


class BookModel
{

    public function getAllBooks()
    {

        $conn = connect();

        $sql = "SELECT * FROM books";
        $result = $conn->query($sql);

        $AllBooks = array();

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                $nextBook = new Book(
                    $row["book_name"],
                    $row["book_author"],
                    $row["book_description"],
                );

                array_push($AllBooks, $nextBook);
            }
        }

        $conn->close();
        return $AllBooks;
    }

    public function getShopIDFromName($name)
    {
        $conn = connect();

        $stmt = $conn->prepare("SELECT * FROM shops WHERE shop_name= ? Limit 1");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();

        $shopID = 0;

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $shopID = $row["shop_id"];
        } 

        $conn->close();
        return $shopID;
    }

    public function getAllStockFromLocation($locationID)
    {
        $conn = connect();

        //fixed with prepared
        //check if email in DB
        $stmt = $conn->prepare("SELECT * FROM stock WHERE store_id = ?");
        $stmt->bind_param("s", $locationID);
        $stmt->execute();
        $result = $stmt->get_result();

        $AllStock = array();

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                $nextStock = new Stock(
                    $row["book_id"],
                    $row["book_quantity"]
                );

                array_push($AllStock, $nextStock);
            }
        }

        $conn->close();
        return $AllStock;
    }

    public function getBookInformationUsingID($bookID)
    {
        $conn = connect();

        //fixed with prepared
        //check if email in DB
        $stmt = $conn->prepare("SELECT * FROM books WHERE book_id = ? Limit 1");
        $stmt->bind_param("i", $bookID);
        $stmt->execute();
        $result = $stmt->get_result();

        $Book = array();

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                $nextBook = new Book(
                    $row["book_name"],
                    $row["book_author"],
                    $row["book_description"],
                );

                array_push($Book, $nextBook);
            }
        }

        $conn->close();
        return $Book;
    }
}

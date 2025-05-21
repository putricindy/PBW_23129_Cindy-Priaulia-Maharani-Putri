<?php
class Book {
    private $code_book;
    private $name;
    private $quantity;

    // Konstruktor
    public function __construct($code_book, $name, $quantity) {
        $this->setCodeBook($code_book);
        $this->name = $name;
        $this->setQuantity($quantity);
    }

    // Validasi kode buku (2 huruf besar + 2 angka)
    private function setCodeBook($code_book) {
        if (preg_match('/^[A-Z]{2}\d{2}$/', $code_book)) {
            $this->code_book = $code_book;
        } else {
            throw new InvalidArgumentException("Error: Format code_book harus 'BBoo' (2 huruf besar diikuti 2 angka)");
        }
    }

    // Validasi jumlah buku harus integer positif
    private function setQuantity($quantity) {
        if (is_int($quantity) && $quantity > 0) {
            $this->quantity = $quantity;
        } else {
            throw new InvalidArgumentException("Error: quantity harus berupa integer positif");
        }
    }

    // Getter
    public function getCodeBook() {
        return $this->code_book;
    }

    public function getName() {
        return $this->name;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    // Supaya bisa langsung dicetak dengan echo
    public function __toString() {
        return "Code: {$this->code_book}, Name: {$this->name}, Quantity: {$this->quantity}";
    }
}

// Contoh penggunaan:
try {
    $book1 = new Book("CD34", "Data Science Handbook", 5);
    echo $book1 . "\n";

    // Uncomment salah satu baris di bawah untuk melihat error:
    // $book2 = new Book("cd34", "Invalid Book", 5);     // Format salah
    // $book3 = new Book("CD34", "Invalid Qty", -1);     // Qty negatif
    // $book4 = new Book("CD34", "Invalid Qty", 0);      // Qty nol

} catch (InvalidArgumentException $e) {
    echo $e->getMessage();
}
?>

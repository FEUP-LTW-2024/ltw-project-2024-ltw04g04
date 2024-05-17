<?php
  declare(strict_types = 1);

    class Order {
        public int $orderId;
        public int $itemId;
        public int $quantity;
        public int $buyerId;
        public string $address;
        public string $city;
        public string $country;
        public string $postalCode;
        public string $cardNumber;
        public string $expirationDate;
        public string $cvv;
        public string $orderDate;


        public function __construct(int $orderId, int $itemId, int $quantity, int $buyerId, string $address, string $city, string $country, string $postalCode, string $cardNumber, string $expirationDate, string $cvv, string $orderDate) {
            $this->orderId = $orderId;
            $this->itemId = $itemId;
            $this->quantity = $quantity;
            $this->buyerId = $buyerId;
            $this->address = $address;
            $this->city = $city;
            $this->country = $country;
            $this->postalCode = $postalCode;
            $this->cardNumber = $cardNumber; 
            $this->expirationDate = $expirationDate; 
            $this->cvv = $cvv; 
            $this->orderDate = $orderDate;
        }


        public static function addOrder(PDO $db, int $itemId, int $quantity, int $buyerId, string $address, string $city, string $country, string $postalCode, string $cardNumber, string $expirationDate, string $cvv) {
            $stmt = $db->prepare('
            INSERT INTO OrderItem (ItemId, Quantity, BuyerId, Adress, City, Country, PostalCode, CardNumber, ExpirationDate, CVV) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            
            $stmt->execute([$itemId, $quantity, $buyerId, $address, $city, $country, $postalCode, $cardNumber, $expirationDate, $cvv]);
        }

        public static function getItemOrders(PDO $db, int $itemId): array {

            $orders = [];
            $stmt = $db->prepare('
                SELECT OrderId, ItemId, Quantity, BuyerId, Adress, City, Country, PostalCode, CardNumber, ExpirationDate, CVV, OrderDate
                FROM OrderItem
                WHERE ItemId = ?
            ');
            $stmt->execute([$itemId]);
            
            while ($order = $stmt->fetch()) {
                $orders[] = new Order(
                    $order['OrderId'],
                    $order['ItemId'],
                    $order['Quantity'],
                    $order['BuyerId'],
                    $order['Adress'],
                    $order['City'],
                    $order['Country'],
                    $order['PostalCode'],
                    $order['CardNumber'],
                    $order['ExpirationDate'], 
                    $order['CVV'], 
                    $order['OrderDate']
                );
            }
            return $orders;
        }
        
    }

?>
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 05, 2024 lúc 12:39 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `quanlydt`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cartitems`
--

CREATE TABLE `cartitems` (
  `cart_id` varchar(50) NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cartitems`
--

INSERT INTO `cartitems` (`cart_id`, `product_id`, `quantity`) VALUES
('1', 'Aby', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `cart_id` varchar(50) NOT NULL,
  `customer_id` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`cart_id`, `customer_id`, `created_at`) VALUES
('1', 'customer_2', '2024-06-29 15:23:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customers`
--

CREATE TABLE `customers` (
  `customer_id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `customers`
--

INSERT INTO `customers` (`customer_id`, `name`, `email`, `phone`, `address`, `username`, `password`, `is_active`) VALUES
('customer1', 'John Doe', 'john@example.com', '123-456-7890', '123 Main St', '', 'johnpassword', b'0'),
('customer2', 'Jane Smith', 'jane@example.com', '098-765-4321', '456 Oak St', '', 'janepassword', b'0'),
('customer_1', 'Alice', 'alice@example.com', '1234567890', '123 Main St', 'alice', 'password1', b'1'),
('customer_2', 'Bob', 'bob@example.com', '2345678901', '456 Elm St', 'bob', 'password2', b'1'),
('customer_3', 'Charlie', 'charlie@example.com', '3456789012', '789 Oak St', 'charlie', 'password3', b'1');

--
-- Bẫy `customers`
--
DELIMITER $$
CREATE TRIGGER `before_insert_customers` BEFORE INSERT ON `customers` FOR EACH ROW BEGIN
    DECLARE next_id INT;
    -- Find the maximum current customer_id and increment by 1
    SELECT IFNULL(MAX(CAST(SUBSTRING(customer_id, 9) AS UNSIGNED)), 0) + 1 INTO next_id FROM customers;
    -- Set the new customer_id
    SET NEW.customer_id = CONCAT('customer', next_id);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orderdetails`
--

CREATE TABLE `orderdetails` (
  `order_id` varchar(50) NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orderdetails`
--

INSERT INTO `orderdetails` (`order_id`, `product_id`, `quantity`, `price`) VALUES
('order_1', 'ip15', 1, 15000000.00),
('order_1', 'Opp02', 1, 2900000.00),
('order_2', 'prod01', 1, 31990000.00),
('order_3', 'Opp04', 1, 3.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `order_id` varchar(50) NOT NULL,
  `customer_id` varchar(50) DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT NULL,
  `total` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `order_date`, `status`, `total`) VALUES
('order_1', 'customer_1', '2024-06-24 16:15:55', 'Shipped', 0.00),
('order_2', 'customer_2', '2024-06-24 16:15:55', 'Cancelled', 0.00),
('order_3', 'customer_3', '2024-06-24 16:15:55', 'Shipped', 0.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `productdetails`
--

CREATE TABLE `productdetails` (
  `product_id` varchar(50) NOT NULL,
  `screen` varchar(50) DEFAULT NULL,
  `os` varchar(50) DEFAULT NULL,
  `camera` varchar(50) DEFAULT NULL,
  `camera_front` varchar(50) DEFAULT NULL,
  `cpu` varchar(50) DEFAULT NULL,
  `ram` varchar(20) DEFAULT NULL,
  `rom` varchar(20) DEFAULT NULL,
  `microUSB` varchar(50) DEFAULT NULL,
  `battery` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `productdetails`
--

INSERT INTO `productdetails` (`product_id`, `screen`, `os`, `camera`, `camera_front`, `cpu`, `ram`, `rom`, `microUSB`, `battery`) VALUES
('Aby', '3', '3', '33', '3', '33', '3', '3', '33', '3'),
('Aby2', '3', '4', 'r', 'sdfsd', 'sdf', 'sdfds', 'sdf', 'sdf', 'sdf'),
('App9', '3', 'kkkrwe', 'sdnf', 'kjsdljfsjld', 'klsdfjlsjdlf', 'mlkdlkdsjf', 'kmlsdkjlf', 'sdnfnsdn', 'sdnlfndsnf'),
('Hwa09', '3', 'kkkrwe', 'sdnf', 'kjsdljfsjld', 'klsdfjlsjdlf', 'mlkdlkdsjf', 'kmlsdkjlf', 'sdnfnsdn', 'sdnlfndsnf'),
('ip15', '6.7', 'IOS 17', ' Chính 48 MP & Phụ 12 MP, 12 MP', '12 MP', 'Apple A17 Pro 6 nhân', '8 GB', '256 GB', '256 GB', '4422 mAh'),
('Iphone2024', '3', '4', '33', '3', '33', 'sdfds', 'sdf', '33', 'sdf'),
('Mobi123', 'ksakjds', 'sjjds', 'mán', 'sand', 'nádn', 'kjasjdk', '3', '33', '3'),
('Opp02', '6.2', 'Android 8.', 'Chính 13 MP & Phụ 2 MP', '8 MP', 'không biết', '3', '32', '32', '4230'),
('Opp04', '3', 'kkkrwe', 'sdnf', 'kjsdljfsjld', 'klsdfjlsjdlf', 'mlkdlkdsjf', 'kmlsdkjlf', 'sdnfnsdn', 'sdnlfndsnf'),
('Opp05', '3', '3', '3', '3', '3', '3', '3', '3', '3'),
('Oppo', '3', '4', '33', 'sdfsd', '33', 'sdfds', '3', '33', '3');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `product_id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `company` varchar(50) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `price` decimal(15,2) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `status` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`product_id`, `name`, `company`, `img`, `price`, `quantity`, `status`) VALUES
('Aby', 'My', 'Mobell', 'huawei-nova-3-2-600x600.jpg', 3.00, 200, b'0'),
('Aby2', 'sdds', 'Realme', 'mobiistar-x-3-600x600.jpg', 4.00, 40, b'0'),
('App9', 'Iphone', 'Oppo', 'mobiistar-x-3-600x600.jpg', 3.00, 0, b'0'),
('Hwa09', 'Hwawei', 'Realme', 'xiaomi-redmi-note-5-pro-600x600.jpg', 3.00, 0, b'0'),
('ip15', 'Iphone15 Promax', 'Apple', 'iphone15.jpg', 15000000.00, 0, b'0'),
('Iphone2024', 'My', 'Nokia', 'mobiistar-x-3-600x600.jpg', 4.00, 0, b'0'),
('Mobi123', 'Mobistar', 'Mobiistar', 'mobiistar-e-selfie-300-1copy-600x600.jpg', 1000000.00, 0, b'0'),
('Opp02', 'Oppo A5S', 'Oppo', 'tải xuống.jpg', 2900000.00, 0, b'0'),
('Opp04', 'Oppo', 'Nokia', 'iphone-x-256gb-silver-400x400.jpg', 3.00, 0, b'0'),
('Opp05', 'Oppo', 'Oppo', 'oppo-a3s-32gb-600x600.jpg', 3.00, 0, b'0'),
('Oppo', 'My', 'Oppo', 'oppo-a3s-32gb-600x600.jpg', 1000000.00, 0, b'0'),
('prod01', 'iPhone X 256GB Silver', 'Apple', 'iphone-x-256gb-silver-400x400.jpg', 31990000.00, 0, b'0');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `promotions`
--

CREATE TABLE `promotions` (
  `value` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `promotions`
--

INSERT INTO `promotions` (`value`) VALUES
('0%'),
('500.000');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `suppliers`
--

CREATE TABLE `suppliers` (
  `name` varchar(50) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_phone` varchar(255) NOT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `suppliers`
--

INSERT INTO `suppliers` (`name`, `contact_name`, `contact_email`, `contact_phone`, `address`) VALUES
('Apple', 'John Doe', 'john.doe@apple.com', '1234567890', '1 Infinite Loop, Cupertino, CA'),
('Coolpad', 'Jennifer Harris', 'jennifer.harris@coolpad.com', '1234567802', 'No. 2, Coolpad Avenue, Longhua, Shenzhen, China'),
('HTC', 'Charles Martin', 'charles.martin@htc.com', '1234567803', '23 Xinghua Road, Taoyuan, Taiwan'),
('Huawei', 'Mary Davis', 'mary.davis@huawei.com', '1234567894', 'Huawei Industrial Base, Longgang, Shenzhen, China'),
('Itel', 'Daniel White', 'daniel.white@itel.com', '1234567801', 'No. 1, Itel Road, High-tech Zone, Shenzhen, China'),
('Mine', 'Hello', 'mtea1491@gmail.com', '0375099885', 'Thị trấn Kim Bài,huyện Thanh Oai'),
('Mobell', 'David Thomas', 'david.thomas@mobell.com', '1234567899', 'No. 112, Xincheng Road, Shajing, Baoan, Shenzhen, China'),
('Mobiistar', 'Barbara Jackson', 'barbara.jackson@mobiistar.com', '1234567800', 'No. 156, Zone B, Section 5, Renmin South Road, Shenzhen, China'),
('Motorola', 'Susan Martinez', 'susan.martinez@motorola.com', '1234567804', '222 W. Merchandise Mart Plaza, Suite 1800, Chicago, IL, USA'),
('Nokia', 'Robert Brown', 'robert.brown@nokia.com', '1234567893', 'Karaportti 3, 02610 Espoo, Finland'),
('Oppo', 'Alice Johnson', 'alice.johnson@oppo.com', '1234567892', '18 Haibin Road, Wusha, Chang\'an, Dongguan, China'),
('Philips', 'Linda Anderson', 'linda.anderson@philips.com', '1234567898', 'Amstelplein 2, 1096 BC Amsterdam, Netherlands'),
('Realme', 'Patricia Moore', 'patricia.moore@realme.com', '1234567896', '18 Haibin Road, Wusha, Chang\'an, Dongguan, China'),
('Samsung', 'Jane Smith', 'jane.smith@samsung.com', '1234567891', '129 Samsung-ro, Suwon-si, Gyeonggi-do, South Korea'),
('Vivo', 'Michael Taylor', 'michael.taylor@vivo.com', '1234567897', '283 BBK Road, Wusha, Chang\'an, Dongguan, China'),
('Xiaomi', 'James Wilson', 'james.wilson@xiaomi.com', '1234567895', '68 Qinghe Middle St, Haidian, Beijing, China');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cartitems`
--
ALTER TABLE `cartitems`
  ADD PRIMARY KEY (`cart_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Chỉ mục cho bảng `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`order_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Chỉ mục cho bảng `productdetails`
--
ALTER TABLE `productdetails`
  ADD PRIMARY KEY (`product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_supplier_name` (`company`);

--
-- Chỉ mục cho bảng `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`name`);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cartitems`
--
ALTER TABLE `cartitems`
  ADD CONSTRAINT `cartitems_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`cart_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cartitems_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `productdetails`
--
ALTER TABLE `productdetails`
  ADD CONSTRAINT `productdetails_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_supplier_name` FOREIGN KEY (`company`) REFERENCES `suppliers` (`name`);

--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

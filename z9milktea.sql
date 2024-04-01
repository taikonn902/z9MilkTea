-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th2 13, 2024 lúc 12:44 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `z9milktea`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categorys`
--

CREATE TABLE `categorys` (
  `category_id` varchar(10) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `categorys`
--

INSERT INTO `categorys` (`category_id`, `category_name`) VALUES
('CT001', 'Trà Sữa'),
('CT002', 'Soda'),
('CT003', 'Sinh Tố'),
('CT004', 'Bánh Kem');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `cmt_id` int(11) NOT NULL,
  `product_id` varchar(10) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `content` varchar(3000) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `delivery_status`
--

CREATE TABLE `delivery_status` (
  `delivery_status_id` int(11) NOT NULL,
  `delivery_status_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `delivery_status`
--

INSERT INTO `delivery_status` (`delivery_status_id`, `delivery_status_name`) VALUES
(1, 'Chờ Xác Nhận'),
(2, 'Đã Nhận Đơn'),
(3, 'Đang Giao Hàng'),
(4, 'Giao Thành Công'),
(5, 'Đã Huỷ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `orders_id` varchar(10) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `order_total` varchar(50) NOT NULL,
  `note` varchar(1000) NOT NULL,
  `delivery_status_id` int(11) NOT NULL,
  `order_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`orders_id`, `user_id`, `order_total`, `note`, `delivery_status_id`, `order_time`) VALUES
('OD001', 'US002', '245.000₫', 'Quán cho mình 2 dĩa 2 muỗng nhựa nha.', 4, '2024-02-09 04:39:23'),
('OD002', 'US003', '75.000₫', 'Ít đá nhiều sữa', 4, '2024-02-11 06:40:48'),
('OD003', 'US003', '75.000₫', 'Ít đá nhiều sữa', 4, '2024-02-11 05:38:56'),
('OD004', 'US002', '87.000₫', '', 4, '2024-02-13 11:21:07');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_des`
--

CREATE TABLE `order_des` (
  `order_des_id` int(11) NOT NULL,
  `orders_id` varchar(10) NOT NULL,
  `hoTen` varchar(50) NOT NULL,
  `SDT` int(11) NOT NULL,
  `address` varchar(500) NOT NULL,
  `order_info` varchar(3000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `order_des`
--

INSERT INTO `order_des` (`order_des_id`, `orders_id`, `hoTen`, `SDT`, `address`, `order_info`) VALUES
(96, 'OD001', ' Ngọc Tài', 988000697, ' 1/79 Lê Văn Bì,  An Thới,  Bình Thuỷ,  Cần Thơ', '<strong>Sinh Tố Dâu</strong>, Size: M, SL: 1 ||==|| <strong>Sinh Tố Dâu</strong>, Size: L, SL: 1 ||==|| <strong>Bánh Kem Socola</strong>, Size: L, SL: 1 ||==|| <strong>Soda Blue</strong>, Size: L, SL: 1'),
(97, 'OD002', ' Trân Bé', 916363224, ' 1/79 Lê Văn Bì,  An Thới,  Bình Thuỷ,  Cần Thơ', '<strong>Sinh Tố Dâu</strong>, Size: L, SL: 2'),
(98, 'OD003', ' Trân Bé', 916363224, ' 1/79 Lê Văn Bì,  An Thới,  Bình Thuỷ,  Cần Thơ', '<strong>Sinh Tố Bơ</strong>, Size: L, SL: 2'),
(99, 'OD004', ' Ngọc Tài', 988000697, ' 1/79 Lê Văn Bì,  An Thới,  Bình Thuỷ,  Cần Thơ', '<strong>Sinh Tố Dâu</strong>, Size: M, SL: 2 ||==|| <strong>Trà Sữa Truyền Thống</strong>, Size: L, SL: 1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `product_id` varchar(10) NOT NULL,
  `category_id` varchar(10) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_img` varchar(255) DEFAULT NULL,
  `product_des` text DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `product_img`, `product_des`, `create_time`) VALUES
('SP001', 'CT001', 'Trà Sữa Truyền Thống', '_bc160719-51da-4df7-ae07-26cabed33dcb.jpg', 'Với vị Trà hảo hạng quyện cùng Sữa tạo nên sự kết hợp hài hòa, lôi cuốn. Truyền Thống lúc nào cũng là lựa chọn hàng đầu cho mọi cuộc gặp gỡ.', '2024-02-07 05:52:22'),
('SP002', 'CT002', 'Soda Dâu', '_649901f6-74a3-4459-9e13-4b5863eaff4d.jpg', 'Soda lạnh được kết hợp với hương vị tươi ngon và ngọt ngào của dâu, tạo nên một trải nghiệm giải khát độc đáo. Vị chua nhẹ từ soda kết hợp với hương thơm quyến rũ của dâu tạo nên một ly đồ uống sảng khoái và phù hợp cho nhiều món ăn, loại thời tiết khác nhau.', '2024-02-07 06:00:15'),
('SP003', 'CT003', 'Sinh Tố Bơ', '_75352a20-3ae1-4450-8f31-82eb9b12f0a8.jpg', 'Từ trái bơ chín mềm, sinh tố này mang đến hương vị độc đáo, ngọt ngào và mịn màng. Giàu chất béo lành mạnh, cung cấp nhiều vitamin và khoáng chất, giúp bổ sung năng lượng và tái tạo cơ bắp.', '2024-02-07 05:55:26'),
('SP004', 'CT001', 'Trà Sữa Khoai Môn', '_f6ee8fe4-35b7-494b-b0fd-62b4f22232ab.jpg', 'Trà sữa khoai môn là sự kết hợp tinh tế giữa hương vị thơm ngon của trà sữa truyền thống và sự độc đáo của khoai môn. Được pha chế từ trà chất lượng cao, hòa quyện cùng sữa tươi và đường, ly trà sữa khoai môn mang lại trải nghiệm thưởng thức mới lạ và ngon miệng.', '2024-02-07 05:51:10'),
('SP005', 'CT002', 'Soda Nho', '_c7439ac3-f176-4585-8227-a532d3f4a701.jpg', 'Soda nho, một sự kết hợp tuyệt vời giữa hương vị ngọt ngào của nho và sự sảng khoái của soda. Hòa quyện trong mỗi giọt nước là hương thơm tinh tế và hương vị phức tạp, mang lại trải nghiệm uống lạ miệng và sảng khoái. Soda nho là lựa chọn tuyệt vời cho những người yêu thích đồ uống giải khát độc đáo và ngon miệng.', '2024-02-07 06:01:12'),
('SP006', 'CT002', 'Soda Blue', '_d120f8f2-cdd6-44cc-b132-44cada6ef7c8.jpg', 'Soda Blue - Một đồ uống tươi mát và phấn khích, kết hợp hương vị ngọt ngào của blueberry và sự sảng khoái của soda. Một lựa chọn hoàn hảo để làm mới ngày của bạn với màu xanh lạc quan và hương vị độc đáo.', '2024-02-07 06:02:17'),
('SP007', 'CT001', 'Trà Sữa Thái Xanh', '_4ab067d4-a76e-46a0-b25a-b7c6e76f768b.jpg', 'Thành phần chính của ly trà sữa thái xanh thường bao gồm trân châu hoặc bọt biển làm từ tinh bột khoai môn, tạo nên độ ngon và ngon miệng cho đồ uống. ', '2024-02-07 05:54:24'),
('SP008', 'CT001', 'Trà Sữa Socola', '_0b9d580b-0361-4b87-b109-7c48b7b0c966.jpg', 'Kết hợp hương vị đắng của socola và hương thơm đặc trưng của trà, mang lại trải nghiệm độc đáo và hấp dẫn cho người thưởng thức. ', '2024-02-07 05:50:02'),
('SP009', 'CT004', 'Bánh Kem Socola', '_2e4f1d7e-0ee4-4785-beb2-cdc3a691d8ed.jpg', 'Được làm từ các lớp bánh mềm nhẹ, xen kẽ với các lớp kem mousse thơm ngon và mịn màng. Bề mặt của bánh thường được phủ lớp socola sáng bóng hoặc trang trí theo nhiều kiểu dáng sáng tạo.', '2024-02-07 08:41:24'),
('SP010', 'CT004', 'Bánh Kem Dâu Tây', '_d384c3ae-d103-49d1-ba46-cbebd986d92d.jpg', 'Nổi bật với vẻ ngoại hình tươi tắn và mùi thơm của dâu tây tươi ngon. Thường được làm từ các lớp bánh mềm và mịn màng, kết hợp với các lớp kem nhẹ nhàng.', '2024-02-07 06:05:46'),
('SP011', 'CT003', 'Sinh Tố Dâu', '_944c21b2-1fc3-400b-a235-5178f585dc56.jpg', 'Được pha chế bằng dâu tươi hái trong ngày với các thành phần khác như sữa, đá, đường, hoặc yaourt để tạo ra một loại sinh tố mát lạnh và thơm ngon.', '2024-02-07 08:41:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_sizes`
--

CREATE TABLE `product_sizes` (
  `product_size_id` int(11) NOT NULL,
  `product_id` varchar(10) NOT NULL,
  `size_id` int(11) NOT NULL,
  `product_price` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `product_sizes`
--

INSERT INTO `product_sizes` (`product_size_id`, `product_id`, `size_id`, `product_price`) VALUES
(79, 'SP008', 1, '22.000đ'),
(80, 'SP008', 2, '27.000đ'),
(81, 'SP004', 1, '22.000đ'),
(82, 'SP004', 2, '27.000đ'),
(83, 'SP001', 1, '22.000đ'),
(84, 'SP001', 2, '27.000đ'),
(85, 'SP007', 1, '22.000đ'),
(86, 'SP007', 2, '27.000đ'),
(87, 'SP003', 1, '30.000đ'),
(88, 'SP003', 2, '35.000đ'),
(91, 'SP002', 1, '25.000đ'),
(92, 'SP002', 2, '30.000đ'),
(93, 'SP005', 1, '25.000đ'),
(94, 'SP005', 2, '30.000đ'),
(95, 'SP006', 1, '25.000đ'),
(96, 'SP006', 2, '30.000đ'),
(98, 'SP010', 1, '100.000đ'),
(103, 'SP009', 2, '150.000đ'),
(104, 'SP011', 1, '30.000đ'),
(105, 'SP011', 2, '35.000đ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sizes`
--

CREATE TABLE `sizes` (
  `size_id` int(11) NOT NULL,
  `size_name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `sizes`
--

INSERT INTO `sizes` (`size_id`, `size_name`) VALUES
(1, 'M'),
(2, 'L');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` varchar(10) NOT NULL,
  `user_name` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass_word` varchar(20) NOT NULL,
  `role` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `email`, `pass_word`, `role`) VALUES
('US001', 'Admin', 'admin@gmail.com', '1234', 0),
('US002', 'Ngọc Tài', 'taikonn09@gmail.com', '1234', 1),
('US003', 'Trân Bé', 'tranbe289@gmail.com', '1234', 1),
('US004', 'Lã Nhung', 'nhung2404@gmail.com', '1234', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_des`
--

CREATE TABLE `user_des` (
  `user_des_id` int(11) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `SDT` int(10) NOT NULL,
  `soNhaTenDuong` varchar(100) NOT NULL,
  `phuongXa` varchar(100) NOT NULL,
  `quanHuyen` varchar(100) NOT NULL,
  `tinhTP` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `user_des`
--

INSERT INTO `user_des` (`user_des_id`, `user_id`, `SDT`, `soNhaTenDuong`, `phuongXa`, `quanHuyen`, `tinhTP`) VALUES
(1, 'US002', 988000697, '1/79 Lê Văn Bì', 'An Thới', 'Bình Thuỷ', 'Cần Thơ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_path`
--

CREATE TABLE `user_path` (
  `user_path_id` int(11) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `path` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `user_path`
--

INSERT INTO `user_path` (`user_path_id`, `user_id`, `path`) VALUES
(3, 'US001', 'images.jpg');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `categorys`
--
ALTER TABLE `categorys`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`cmt_id`);

--
-- Chỉ mục cho bảng `delivery_status`
--
ALTER TABLE `delivery_status`
  ADD PRIMARY KEY (`delivery_status_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orders_id`),
  ADD KEY `fk_orders_users` (`user_id`);

--
-- Chỉ mục cho bảng `order_des`
--
ALTER TABLE `order_des`
  ADD PRIMARY KEY (`order_des_id`),
  ADD KEY `fk_order_des_orders` (`orders_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD PRIMARY KEY (`product_size_id`),
  ADD KEY `fk_product_sizes_products` (`product_id`),
  ADD KEY `fk_product_sizes_sizes` (`size_id`);

--
-- Chỉ mục cho bảng `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`size_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Chỉ mục cho bảng `user_des`
--
ALTER TABLE `user_des`
  ADD PRIMARY KEY (`user_des_id`),
  ADD KEY `fk_user_des_users` (`user_id`);

--
-- Chỉ mục cho bảng `user_path`
--
ALTER TABLE `user_path`
  ADD PRIMARY KEY (`user_path_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `cmt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `delivery_status`
--
ALTER TABLE `delivery_status`
  MODIFY `delivery_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `order_des`
--
ALTER TABLE `order_des`
  MODIFY `order_des_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT cho bảng `product_sizes`
--
ALTER TABLE `product_sizes`
  MODIFY `product_size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT cho bảng `sizes`
--
ALTER TABLE `sizes`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `user_des`
--
ALTER TABLE `user_des`
  MODIFY `user_des_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `user_path`
--
ALTER TABLE `user_path`
  MODIFY `user_path_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `order_des`
--
ALTER TABLE `order_des`
  ADD CONSTRAINT `fk_order_des_orders` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`orders_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_categorys` FOREIGN KEY (`category_id`) REFERENCES `categorys` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categorys` (`category_id`);

--
-- Các ràng buộc cho bảng `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD CONSTRAINT `fk_product_sizes_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_sizes_sizes` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`size_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `user_des`
--
ALTER TABLE `user_des`
  ADD CONSTRAINT `fk_user_des_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `user_path`
--
ALTER TABLE `user_path`
  ADD CONSTRAINT `user_path_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

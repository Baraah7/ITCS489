-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2025 at 03:54 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `itcs489`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `rating` decimal(2,1) DEFAULT 0.0,
  `stock` int(11) DEFAULT 0,
  `cover_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category_id` int(11) DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `page_count` int(11) DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `publication_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `description`, `price`, `rating`, `stock`, `cover_image`, `created_at`, `category_id`, `isbn`, `page_count`, `publisher`, `publication_date`) VALUES
(1, 'The Great Gatsby', 'F. Scott Fitzgerald', 'A novel set in the Roaring Twenties.', 10.99, 0.0, 12, 'gatsby.jpg', '2025-05-17 09:54:01', 2, '9780743273565', 180, 'Charles Scribner\'s Sons', '1925-04-10'),
(2, '1984', 'George Orwell', 'Dystopian novel about totalitarian regime.', 9.50, 0.0, 20, '1984.jpg', '2025-05-17 09:54:01', 3, '9780451524935', 328, 'Secker & Warburg', '1949-06-08'),
(3, 'To Kill a Mockingbird', 'Harper Lee', 'Classic novel of racism and justice.', 11.25, 0.0, 15, 'mockingbird.jpg', '2025-05-17 09:54:01', 2, '9780061120084', 281, 'J.B. Lippincott & Co.', '1960-07-11'),
(4, 'The Great Gatsby', 'F. Scott Fitzgerald', 'A novel set in the Roaring Twenties.', 10.99, 0.0, 12, 'gatsby.jpg', '2025-05-17 09:54:35', NULL, NULL, NULL, NULL, NULL),
(5, '1984', 'George Orwell', 'Dystopian novel about totalitarian regime.', 9.50, 0.0, 20, '1984.jpg', '2025-05-17 09:54:35', NULL, NULL, NULL, NULL, NULL),
(6, 'To Kill a Mockingbird', 'Harper Lee', 'Classic novel of racism and justice.', 11.25, 0.0, 15, 'mockingbird.jpg', '2025-05-17 09:54:35', NULL, NULL, NULL, NULL, NULL),
(7, 'The Great Gatsby', 'F. Scott Fitzgerald', 'A novel set in the Roaring Twenties.', 10.99, 0.0, 12, 'gatsby.jpg', '2025-05-17 09:54:45', NULL, NULL, NULL, NULL, NULL),
(8, '1984', 'George Orwell', 'Dystopian novel about totalitarian regime.', 9.50, 0.0, 20, '1984.jpg', '2025-05-17 09:54:45', NULL, NULL, NULL, NULL, NULL),
(9, 'To Kill a Mockingbird', 'Harper Lee', 'Classic novel of racism and justice.', 11.25, 0.0, 15, 'mockingbird.jpg', '2025-05-17 09:54:45', NULL, NULL, NULL, NULL, NULL),
(10, 'Harry Potter and the Cursed Child', 'J.K. Rowling', 'Return to the Wizarding World in this two-part stage play.', 14.99, 0.0, 25, 'books1.png', '2025-05-17 15:42:25', 1, '9781408855652', 343, 'Little, Brown', '2016-07-31'),
(11, 'The Great Gatsby', 'F. Scott Fitzgerald', 'A story of decadence and excess.', 12.99, 0.0, 30, 'book 3.bmp', '2025-05-17 15:42:25', 2, '9780140283334', 224, 'Penguin Books', '2000-01-01'),
(12, '1984', 'George Orwell', 'A dystopian social science fiction novel.', 11.99, 0.0, 20, 'book 4.bmp', '2025-05-17 15:42:25', 3, '9780141036144', 328, 'Penguin Books', '2003-01-01'),
(13, 'Autism Empowerment for Adults', 'Jules Golden', 'Practical strategies for neurodiverse adults.', 19.99, 0.0, 15, 'book 5.bmp', '2025-05-17 15:42:25', NULL, '9780997155702', 300, 'Autism Empowerment Press', '2017-10-01'),
(14, 'The Power of Habit', 'Charles Duhigg', 'Why we do what we do in life and business.', 16.99, 0.0, 25, 'book 6.bmp', '2025-05-17 15:42:25', NULL, '9780812981605', 416, 'Random House', '2012-02-28'),
(15, 'Atomic Habits', 'James Clear', 'An easy and proven way to build good habits.', 15.99, 0.0, 30, 'book 7.bmp', '2025-05-17 15:42:25', NULL, '9780735211292', 320, 'Avery', '2018-10-16'),
(16, 'The Silent Patient', 'Alex Michaelides', 'A psychological thriller about a woman who shoots her husband and then stops speaking.', 12.99, 4.5, 100, 'book1.jpg', '2025-05-17 17:55:50', 65, '9781250301697', 336, NULL, NULL),
(17, 'Educated', 'Tara Westover', 'A memoir about a woman who leaves her survivalist family and goes on to earn a PhD from Cambridge University.', 14.95, 4.7, 85, 'book2.jpg', '2025-05-17 17:55:50', 4, '9780399590504', 400, NULL, NULL),
(18, 'Dune', 'Frank Herbert', 'A science fiction novel about a desert planet and the boy who would become its messiah.', 9.99, 4.8, 120, 'book3.jpg', '2025-05-17 17:55:50', 3, '9780441013593', 688, NULL, NULL),
(19, 'The Midnight Library', 'Matt Haig', 'A novel about a library between life and death where each book represents a different life path.', 13.49, 4.2, 95, 'book4.jpg', '2025-05-17 17:55:50', 1, '9780525559474', 304, NULL, NULL),
(20, 'Atomic Habits', 'James Clear', 'A guide to building good habits and breaking bad ones with tiny changes.', 11.98, 4.6, 150, 'book5.jpg', '2025-05-17 17:55:50', 67, '9780735211292', 320, NULL, NULL),
(21, 'The Hobbit', 'J.R.R. Tolkien', 'A fantasy novel about a hobbit who goes on an adventure with a group of dwarves.', 8.99, 4.9, 200, 'book6.jpg', '2025-05-17 17:55:50', 64, '9780547928227', 310, NULL, NULL),
(22, 'Where the Crawdads Sing', 'Delia Owens', 'A novel about a girl who raises herself in the marshes of North Carolina.', 10.49, 4.8, 110, 'book7.jpg', '2025-05-17 17:55:50', 1, '9780735219106', 384, NULL, NULL),
(23, 'The Song of Achilles', 'Madeline Miller', 'A retelling of the Iliad from the perspective of Patroclus, Achilles\' lover.', 12.99, 4.6, 75, 'book8.jpg', '2025-05-17 17:55:50', 66, '9780062060624', 378, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `book_categories`
--

CREATE TABLE `book_categories` (
  `book_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(75, 'Art'),
(4, 'Biography'),
(5, 'Children'),
(2, 'Classics'),
(74, 'Comedy'),
(73, 'Drama'),
(64, 'Fantasy'),
(1, 'Fiction'),
(68, 'History'),
(70, 'Horror'),
(65, 'Mystery'),
(62, 'Non-Fiction'),
(76, 'Philosophy'),
(72, 'Poetry'),
(77, 'Religion'),
(66, 'Romance'),
(63, 'Science'),
(3, 'Science Fiction'),
(67, 'Self Help'),
(69, 'Thriller'),
(71, 'Young Adult');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `total` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','paid','shipped','cancelled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_date`, `total`, `status`) VALUES
(1, 1, '2025-05-17 15:54:45', 21.98, 'paid'),
(2, 2, '2025-05-17 15:54:45', 10.99, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `book_id`, `quantity`, `price`) VALUES
(1, 1, 1, 1, 10.99),
(2, 1, 2, 1, 10.99),
(3, 2, 1, 1, 10.99);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `is_admin`, `created_at`) VALUES
(1, 'Alice Johnson', 'alice@example.com', 'password123', 0, '2025-05-17 09:53:01'),
(2, 'Bob Smith', 'bob@example.com', 'securepass', 0, '2025-05-17 09:53:01'),
(3, 'Admin User', 'admin@example.com', 'adminpass', 1, '2025-05-17 09:53:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `book_categories`
--
ALTER TABLE `book_categories`
  ADD PRIMARY KEY (`book_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `book_categories`
--
ALTER TABLE `book_categories`
  ADD CONSTRAINT `book_categories_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`),
  ADD CONSTRAINT `book_categories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

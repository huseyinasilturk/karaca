-- --------------------------------------------------------
-- Sunucu:                       127.0.0.1
-- Sunucu sürümü:                10.4.22-MariaDB - mariadb.org binary distribution
-- Sunucu İşletim Sistemi:       Win64
-- HeidiSQL Sürüm:               11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- karaca.expense_statements: ~0 rows (yaklaşık) tablosu için veriler indiriliyor
/*!40000 ALTER TABLE `expense_statements` DISABLE KEYS */;
INSERT INTO `expense_statements` (`id`, `price`, `detail`, `table_name`, `table_id`, `company_id`, `expense_date`, `created_at`, `updated_at`) VALUES
	(1, 550.00, 'Delux Yaş Pasta ürününden 10 adet eklendi.', 'stocks', 1, 1, '2022-04-03', '2022-04-03 11:37:12', '2022-04-03 11:37:12'),
	(2, 600.00, 'Çilek Fıstıklı Yaş Pasta ürününden 10 adet eklendi.', 'stocks', 2, 1, '2022-04-03', '2022-04-03 11:37:18', '2022-04-03 11:37:18'),
	(3, 650.00, 'Kakao Bisküvili Çilekli Yaş Pasta ürününden 10 adet eklendi.', 'stocks', 3, 1, '2022-04-03', '2022-04-03 11:37:24', '2022-04-03 11:37:24'),
	(4, 1500.00, 'Sütlü Nuriye ürününden 10 adet eklendi.', 'stocks', 4, 1, '2022-04-03', '2022-04-03 11:37:38', '2022-04-03 11:37:38'),
	(5, 1600.00, 'Sütlü Fıstıklı Baklava (Laktozsuz) ürününden 10 adet eklendi.', 'stocks', 5, 1, '2022-04-03', '2022-04-03 11:37:46', '2022-04-03 11:37:46'),
	(6, 1700.00, 'Sütlü Cevizli Baklava (Laktozsuz) ürününden 10 adet eklendi.', 'stocks', 6, 1, '2022-04-03', '2022-04-03 11:37:54', '2022-04-03 11:37:54'),
	(7, 1100.00, 'Orman Meyveli Ekler ürününden 10 adet eklendi.', 'stocks', 7, 1, '2022-04-03', '2022-04-03 11:38:06', '2022-04-03 11:38:06'),
	(8, 1150.00, 'Muzlu Ekler ürününden 10 adet eklendi.', 'stocks', 8, 1, '2022-04-03', '2022-04-03 11:38:13', '2022-04-03 11:38:13'),
	(9, 1200.00, 'Krokanlı Ekler ürününden 10 adet eklendi.', 'stocks', 9, 1, '2022-04-03', '2022-04-03 11:38:21', '2022-04-03 11:38:21'),
	(10, 700.00, 'Makaron 24\'lü Kutu ürününden 10 adet eklendi.', 'stocks', 10, 1, '2022-04-03', '2022-04-03 11:38:33', '2022-04-03 11:38:33'),
	(11, 400.00, 'Makaron 14\'lü Kutu ürününden 10 adet eklendi.', 'stocks', 11, 1, '2022-04-03', '2022-04-03 11:38:38', '2022-04-03 11:38:38'),
	(12, 200.00, 'Makaron 7\'li Kutu ürününden 10 adet eklendi.', 'stocks', 12, 1, '2022-04-03', '2022-04-03 11:38:42', '2022-04-03 11:38:42'),
	(13, 350.00, 'San Sebastian Cheesecake ürününden 10 adet eklendi.', 'stocks', 13, 1, '2022-04-03', '2022-04-03 11:39:35', '2022-04-03 11:39:35'),
	(14, 400.00, 'Muz Krokanlı Muhallebi ürününden 10 adet eklendi.', 'stocks', 14, 1, '2022-04-03', '2022-04-03 11:39:38', '2022-04-03 11:39:38'),
	(15, 450.00, 'Meyve Dünyası ürününden 10 adet eklendi.', 'stocks', 15, 1, '2022-04-03', '2022-04-03 11:39:41', '2022-04-03 11:39:41'),
	(16, 1000.00, 'Madlen Çikolata ürününden 10 adet eklendi.', 'stocks', 16, 1, '2022-04-03', '2022-04-03 11:39:53', '2022-04-03 11:39:53'),
	(17, 1000.00, 'Spesiyal Çikolata Pencereli Kutu ürününden 10 adet eklendi.', 'stocks', 17, 1, '2022-04-03', '2022-04-03 11:39:58', '2022-04-03 11:39:58'),
	(18, 450.00, 'Tahinli Çıtır ürününden 10 adet eklendi.', 'stocks', 18, 1, '2022-04-03', '2022-04-03 11:40:05', '2022-04-03 11:40:05'),
	(19, 500.00, 'Acıbadem ürününden 10 adet eklendi.', 'stocks', 19, 1, '2022-04-03', '2022-04-03 11:40:22', '2022-04-03 11:40:22'),
	(20, 450.00, 'Spesyal Tatlı Kuru Pasta ürününden 10 adet eklendi.', 'stocks', 20, 1, '2022-04-03', '2022-04-03 11:40:29', '2022-04-03 11:40:29');
/*!40000 ALTER TABLE `expense_statements` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

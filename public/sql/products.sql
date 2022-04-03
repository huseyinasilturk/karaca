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

-- karaca.products: ~0 rows (yaklaşık) tablosu için veriler indiriliyor
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `type_id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 7, 'Delux Yaş Pasta', '2022-04-03 10:36:32', '2022-04-03 10:36:32'),
	(2, 7, 'Çilek Fıstıklı Yaş Pasta', '2022-04-03 10:37:06', '2022-04-03 10:37:06'),
	(3, 7, 'Kakao Bisküvili Çilekli Yaş Pasta', '2022-04-03 10:40:47', '2022-04-03 10:40:47'),
	(4, 8, 'Sütlü Nuriye', '2022-04-03 10:42:14', '2022-04-03 10:43:43'),
	(5, 8, 'Sütlü Fıstıklı Baklava (Laktozsuz)', '2022-04-03 10:42:42', '2022-04-03 10:43:48'),
	(6, 8, 'Sütlü Cevizli Baklava (Laktozsuz)', '2022-04-03 10:43:03', '2022-04-03 10:43:51'),
	(7, 9, 'Orman Meyveli Ekler', '2022-04-03 10:44:12', '2022-04-03 10:44:12'),
	(8, 9, 'Muzlu Ekler', '2022-04-03 10:44:31', '2022-04-03 10:44:31'),
	(9, 7, 'Krokanlı Ekler', '2022-04-03 10:44:52', '2022-04-03 10:44:52'),
	(10, 10, 'Makaron 24\'lü Kutu', '2022-04-03 10:45:58', '2022-04-03 10:45:58'),
	(11, 10, 'Makaron 14\'lü Kutu', '2022-04-03 10:46:24', '2022-04-03 10:46:24'),
	(12, 10, 'Makaron 7\'li Kutu', '2022-04-03 10:46:45', '2022-04-03 10:46:45'),
	(13, 11, 'San Sebastian Cheesecake', '2022-04-03 10:47:22', '2022-04-03 10:47:22'),
	(14, 11, 'Muz Krokanlı Muhallebi', '2022-04-03 10:47:40', '2022-04-03 10:47:40'),
	(15, 11, 'Meyve Dünyası', '2022-04-03 10:47:56', '2022-04-03 10:47:56'),
	(16, 12, 'Madlen Çikolata', '2022-04-03 10:48:33', '2022-04-03 10:48:33'),
	(17, 12, 'Spesiyal Çikolata Pencereli Kutu', '2022-04-03 10:48:52', '2022-04-03 10:48:52'),
	(18, 13, 'Tahinli Çıtır', '2022-04-03 10:49:19', '2022-04-03 10:49:19'),
	(19, 13, 'Acıbadem', '2022-04-03 10:49:42', '2022-04-03 10:49:42'),
	(20, 13, 'Spesyal Tatlı Kuru Pasta', '2022-04-03 10:50:01', '2022-04-03 10:50:01');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

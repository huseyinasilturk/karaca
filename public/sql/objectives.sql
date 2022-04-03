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

-- karaca.objectives: ~25 rows (yaklaşık) tablosu için veriler indiriliyor
/*!40000 ALTER TABLE `objectives` DISABLE KEYS */;
INSERT INTO `objectives` (`id`, `add_user_id`, `name`, `number1`, `number2`, `number3`, `text1`, `text2`, `text3`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, NULL, 'quality', NULL, NULL, NULL, 'Kaliteli', NULL, NULL, NULL, '2022-04-03 10:24:39', '2022-04-03 10:24:39'),
	(2, NULL, 'quality', NULL, NULL, NULL, 'Orta Kaliteli', NULL, NULL, NULL, '2022-04-03 10:24:43', '2022-04-03 10:24:43'),
	(3, NULL, 'quality', NULL, NULL, NULL, 'Az Kaliteli', NULL, NULL, NULL, '2022-04-03 10:24:47', '2022-04-03 10:24:47'),
	(4, NULL, 'companyType', NULL, NULL, NULL, 'Depo', NULL, NULL, NULL, '2022-04-03 10:24:51', '2022-04-03 10:24:51'),
	(5, NULL, 'companyType', NULL, NULL, NULL, 'Firma', NULL, NULL, NULL, '2022-04-03 10:24:54', '2022-04-03 10:24:54'),
	(6, NULL, 'companyType', NULL, NULL, NULL, 'Ana Firma', NULL, NULL, NULL, '2022-04-03 10:24:58', '2022-04-03 10:24:58'),
	(7, NULL, 'productType', NULL, NULL, NULL, 'Pasta', NULL, NULL, NULL, '2022-04-03 10:25:02', '2022-04-03 10:25:02'),
	(8, NULL, 'productType', NULL, NULL, NULL, 'Baklava', NULL, NULL, NULL, '2022-04-03 10:25:04', '2022-04-03 10:25:04'),
	(9, NULL, 'productType', NULL, NULL, NULL, 'Ekler', NULL, NULL, NULL, '2022-04-03 10:25:07', '2022-04-03 10:25:07'),
	(10, NULL, 'productType', NULL, NULL, NULL, 'Makaron', NULL, NULL, NULL, '2022-04-03 10:25:11', '2022-04-03 10:25:11'),
	(11, NULL, 'productType', NULL, NULL, NULL, 'Sütlü Tatlı', NULL, NULL, NULL, '2022-04-03 10:25:16', '2022-04-03 10:25:16'),
	(12, NULL, 'productType', NULL, NULL, NULL, 'Çikolata', NULL, NULL, NULL, '2022-04-03 10:25:21', '2022-04-03 10:25:21'),
	(13, NULL, 'productType', NULL, NULL, NULL, 'Tuzlu', NULL, NULL, NULL, '2022-04-03 10:25:25', '2022-04-03 10:25:25'),
	(14, NULL, 'unitType', NULL, NULL, NULL, 'adet', NULL, NULL, NULL, '2022-04-03 10:25:32', '2022-04-03 10:25:32'),
	(15, NULL, 'unitType', NULL, NULL, NULL, 'kg', NULL, NULL, NULL, '2022-04-03 10:26:23', '2022-04-03 10:26:23'),
	(16, NULL, 'unitType', NULL, NULL, NULL, 'lt', NULL, NULL, NULL, '2022-04-03 10:26:28', '2022-04-03 10:26:28'),
	(17, NULL, 'unitType', NULL, NULL, NULL, 'gr', NULL, NULL, NULL, '2022-04-03 10:26:32', '2022-04-03 10:26:32'),
	(18, NULL, 'unitType', NULL, NULL, NULL, 'kutu', NULL, NULL, NULL, '2022-04-03 10:26:40', '2022-04-03 10:26:40'),
	(19, NULL, 'unitType', NULL, NULL, NULL, 'tepsi', NULL, NULL, NULL, '2022-04-03 10:26:44', '2022-04-03 10:26:44'),
	(20, NULL, 'unitType', NULL, NULL, NULL, 'çuval', NULL, NULL, NULL, '2022-04-03 10:26:47', '2022-04-03 10:26:47'),
	(21, NULL, 'unitType', NULL, NULL, NULL, '₺', NULL, NULL, NULL, '2022-04-03 10:26:52', '2022-04-03 10:26:52'),
	(22, NULL, 'customerType', NULL, NULL, NULL, 'Sadık Müşteri', NULL, NULL, NULL, '2022-04-03 10:27:01', '2022-04-03 10:27:01'),
	(23, NULL, 'customerType', NULL, NULL, NULL, 'Sürekli Müşteri', NULL, NULL, NULL, '2022-04-03 10:27:12', '2022-04-03 10:27:12'),
	(24, NULL, 'customerType', NULL, NULL, NULL, 'Pazarlıkçı Müşteri', NULL, NULL, NULL, '2022-04-03 10:27:21', '2022-04-03 10:27:21'),
	(25, NULL, 'customerType', NULL, NULL, NULL, 'Özel Müşteri', NULL, NULL, NULL, '2022-04-03 10:27:27', '2022-04-03 10:27:27');
/*!40000 ALTER TABLE `objectives` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

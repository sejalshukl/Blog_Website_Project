-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2024 at 06:19 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog_platform`
--

-- --------------------------------------------------------

--
-- Table structure for table `drafts`
--

CREATE TABLE `drafts` (
  `draft_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drafts`
--

INSERT INTO `drafts` (`draft_id`, `user_id`, `post_id`, `created_at`) VALUES
(7, 9, 12, '2024-10-13 11:49:29');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `tags` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `content`, `tags`, `created_at`) VALUES
(2, 7, 'The Power of Daily Habits', '<p><strong>Incorporate daily habits into your routine can significantly improve your productivity and well-being. From morning rituals like meditation and exercise to</strong> evening reflections, small consistent actions shape the way we live and work. These habits not only help in achieving long-term goals but also bring a sense of control and fulfillment. Whether it\'s writing for ten minutes a day or reading a few pages of a book, the impact of daily habits is profound. Start small, stay consistent, and watch your life transform over time.</p>', ' productivity, daily habits, personal growth, well-being, routines, success', '2024-10-12 19:05:55'),
(4, 9, 'Embracing Minimalism:- A Path to a Simpler Life', '<p>In today&rsquo;s fast-paced world, the concept of minimalism offers a refreshing approach to living. At its core, minimalism is about stripping away the excess to focus on what truly matters. This lifestyle change can lead to reduced stress, improved mental clarity, and greater appreciation for the present moment.</p>\r\n<p><img src=\"https://cdn.pixabay.com/photo/2024/09/25/15/53/japan-9074037_640.jpg\" alt=\"\" width=\"640\" height=\"360\"></p>\r\n<p>Embracing minimalism begins with decluttering your physical space. Start by evaluating your belongings: what do you use regularly, and what brings you joy? Items that don&rsquo;t serve a purpose or hold sentimental value can often be donated or discarded, creating a more serene living environment.</p>\r\n<p>However, minimalism extends beyond just physical possessions. It can also apply to digital clutter, such as emails and files on your devices. Organizing your digital life can lead to increased productivity and less distraction.</p>\r\n<p>Additionally, adopting a minimalist mindset can encourage mindful consumption. This means being intentional about what you purchase and consume, choosing quality over quantity. By simplifying your life, you create space for meaningful experiences, relationships, and personal growth.</p>\r\n<p>Minimalism is not just a trend; it&rsquo;s a lifestyle choice that promotes intentionality and helps cultivate a sense of peace and fulfillment.</p>\r\n<p>&nbsp;</p>', 'minimalism, simplicity, decluttering, mindfulness, intentional living, personal growth', '2024-10-12 20:25:06'),
(5, 9, 'The Importance of Mindfulness in Daily Life', '<p>In today&rsquo;s fast-paced world, the concept of mindfulness has emerged as a powerful tool for enhancing well-being and productivity. Mindfulness is the practice of being fully present and engaged in the moment, which can significantly impact our mental health and overall quality of life.</p>\r\n<p>One of the primary benefits of mindfulness is its ability to reduce stress. When we focus on the present moment, we often find that our worries about the past or future fade away. This shift in perspective allows us to experience a sense of calm, making it easier to navigate life&rsquo;s challenges. Studies have shown that regular mindfulness practice can lead to lower levels of cortisol, the hormone associated with stress, ultimately improving our emotional resilience.</p>\r\n<p>Moreover, mindfulness fosters better emotional regulation. By practicing mindfulness, we become more aware of our thoughts and feelings, which enables us to respond to situations more thoughtfully rather than react impulsively. This awareness can lead to healthier relationships, as we become more empathetic and understanding toward others.</p>\r\n<p>Incorporating mindfulness into our daily routines doesn&rsquo;t have to be complex. Simple practices, such as mindful breathing, can be easily integrated into our day. For instance, taking just a few minutes each morning to focus on our breath can set a positive tone for the day ahead. Additionally, mindfulness can be practiced during everyday activities, like eating or walking. By fully engaging in these moments, we can enhance our appreciation for life and cultivate a greater sense of gratitude.</p>\r\n<p>Another significant aspect of mindfulness is its role in improving focus and concentration. In an age where distractions abound, practicing mindfulness can help us hone our attention skills. By training our minds to focus on one task at a time, we can improve our productivity and efficiency, whether at work or in our personal lives.</p>\r\n<p>In conclusion, mindfulness is more than just a trend; it&rsquo;s a valuable practice that can enrich our lives in numerous ways. By dedicating time to be present, we can enhance our emotional well-being, reduce stress, and improve our overall quality of life. As we embrace mindfulness, we open ourselves up to a more fulfilling and joyful existence.</p>\r\n<hr>\r\n<p>&nbsp;</p>', ' mindfulness, mental health, stress reduction, emotional regulation, daily practice, productivity, focus, well-being, gratitude, self-improvement', '2024-10-12 21:06:34'),
(6, 9, 'The tale of Naruto', '<p>In today&rsquo;s fast-paced world, the concept of mindfulness has emerged as a powerful tool for enhancing well-being and productivity. Mindfulness is the practice of being fully present and engaged in the moment, which can significantly impact our mental health and overall quality of life.</p>\r\n<p>&nbsp;</p>\r\n<p>One of the primary benefits of mindfulness is its ability to reduce stress. When we focus on the present moment, we often find that our worries about the past or future fade away. This shift in perspective allows us to experience a sense of calm, making it easier to navigate life&rsquo;s challenges. Studies have shown that regular mindfulness practice can lead to lower levels of cortisol, the hormone associated with stress, ultimately improving our emotional resilience.</p>\r\n<p>Moreover, mindfulness fosters better emotional regulation. By practicing mindfulness, we become more aware of our thoughts and feelings, which enables us to respond to situations more thoughtfully rather than react impulsively. This awareness can lead to healthier relationships, as we become more empathetic and understanding toward others.</p>\r\n<p>Incorporating mindfulness into our daily routines doesn&rsquo;t have to be complex. Simple practices, such as mindful breathing, can be easily integrated into our day. For instance, taking just a few minutes each morning to focus on our breath can set a positive tone for the day ahead. Additionally, mindfulness can be practiced during everyday activities, like eating or walking. By fully engaging in these moments, we can enhance our appreciation for life and cultivate a greater sense of gratitude.</p>\r\n<p>Another significant aspect of mindfulness is its role in improving focus and concentration. In an age where distractions abound, practicing mindfulness can help us hone our attention skills. By training our minds to focus on one task at a time, we can improve our productivity and efficiency, whether at work or in our personal lives.</p>\r\n<p><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"https://cdn.pixabay.com/photo/2024/09/25/15/53/japan-9074037_640.jpg\" alt=\"\" width=\"640\" height=\"360\"></p>\r\n<p>In conclusion, mindfulness&nbsp;is more than just a trend; it&rsquo;s a valuable practice that can enrich our lives in numerous ways. By dedicating time to be present, we can enhance our emotional well-being, reduce stress, and improve our overall quality of life. As we embrace mindfulness, we open ourselves up to a more fulfilling and joyful existence</p>', ' mindfulness, mental health, stress reduction, emotional regulation, daily practice, productivity, focus, well-being, gratitude, self-improvement', '2024-10-12 21:33:20'),
(10, 10, 'YOurself', '<ul>\r\n<li><strong>\"The Power of Storytelling: How to Craft Engaging Narratives\"</strong><br>A guide for aspiring writers on the importance of storytelling and how to structure a compelling narrative.</li>\r\n<li><strong>\"Writing Prompts to Unlock Your Creativity\"</strong><br>A collection of creative writing prompts to help get ideas flowing</li>\r\n</ul>', 'oo', '2024-10-13 13:52:47'),
(11, 10, 'oo', '<ul>\r\n<li><strong>\"The Power of Storytelling: How to Craft Engaging Narratives\"</strong><br>A guide for aspiring writers on the importance of storytelling and how to structure a compelling narrative.</li>\r\n<li><strong>\"Writing Prompts to Unlock Your Creativity\"</strong><br>A collection of creative writing prompts to help get ideas flowing</li>\r\n</ul>', 'lo', '2024-10-13 13:53:08'),
(12, 9, 'ggggggg', '<p>ddfsdfsdfsdfsdfsd</p>', 'ff,hh,jj', '2024-10-13 17:19:29'),
(13, 10, 'oo my god', '<p>jeeeee myy myy</p>', 'yes', '2024-10-13 18:45:36'),
(14, 10, 'kadam chirag ', '<p>hey</p>\r\n<p>why are u not attended class</p>', 'by kadam chirag', '2024-10-13 21:02:47'),
(15, 10, 'mm', '<p>mm</p>\r\n<p>ii</p>\r\n<p>jj</p>', 'm', '2024-10-13 21:06:47'),
(18, 10, 'hghhhgghgh', '<p>ghghghghh</p>', 'ff,gg,jj', '2024-10-13 21:32:38'),
(20, 10, 'The title of ACE', '<p>the Ace is a legendary that is never wanted to be&nbsp;</p>', 'gf,hg,fd,sa', '2024-10-13 21:38:47'),
(21, 10, 'the tale of ACER', '<p>fdffdffdfddffd ss s sd dfghf d sd sdg sd gg fggffdgdf</p>', 'seja,shu', '2024-10-13 21:44:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'sejalshukla', 'sejalshukla985@gmail.com', '$2y$10$lVHj6kxG5E/tzuFhvo0qV..K1Hzr3G3HbklIX6TIBxfItyE6zAQFq'),
(2, 'yelo', 'yelo@gmail.com', '$2y$10$sYWac700OKhipv/wUWptCuXiQw5Z8s2UgEvMSkPPx0jzx/5jP0O8u'),
(3, 'neha', 'neha@gmail.com', 'neha'),
(4, 'ur', 'ur@gmail.com', 'ur'),
(5, 'Anand', 'an@gmail.com', '123456'),
(6, 'acer', 'ac@gmail.com', '$2y$10$FX7v3Tn7/OSWzj7iYwcawukHMxrbkb7kYQi/pcm.pfYot0A6UsW/u'),
(7, 'l', 'l@gmail.com', '$2y$10$XEBOKyIlc4aSmp5p2/seQO0p9C0m0Reye8Vv16A5s3LjkdIdT8REK'),
(8, 'su', 'su@gmail.com', '$2y$10$0r7wTQhgujMAuSAqS2DRreFhv6fLCgo9JwL5eVEqhgJQGREjriwky'),
(9, 'zer', 'z@gmail.com', '$2y$10$xE6D7H8oUOuYb5xKtuzFKeu3ZwXaa.gb5HtvnmyhKN5OGhGBDfKN6'),
(10, 'lu', 'lu@gmail.com', '$2y$10$Obhos.n1YY3NW6ve1BwMUOC9M9E6BLLr1oxQbNCEEmzigM7KWMaGO'),
(11, 'amit', 'amit@gmail.com', '$2y$10$lOyyYuQZ/UkIQhiQFo3Cre91zFOloIk97Ljri1iOAW6.AU9.Z3gN6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `drafts`
--
ALTER TABLE `drafts`
  ADD PRIMARY KEY (`draft_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `drafts`
--
ALTER TABLE `drafts`
  MODIFY `draft_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `drafts`
--
ALTER TABLE `drafts`
  ADD CONSTRAINT `drafts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `drafts_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

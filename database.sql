-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 22, 2013 at 03:24 PM
-- Server version: 5.5.29
-- PHP Version: 5.4.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `serenedi_p4_serenedipity_biz`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'FK',
  `content` text NOT NULL,
  `url` blob NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `created`, `modified`, `user_id`, `content`, `url`) VALUES
(1, 1387207432, 1387207432, 2, 'Testing!', ''),
(2, 1387222810, 1387222810, 3, 'www.cnn.com<br />\r\n', ''),
(3, 1387259004, 1387259004, 4, 'hello, looks like some is working...', ''),
(4, 1387260738, 1387260738, 4, 'See how this works like magic?', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `last_login` int(11) NOT NULL,
  `timezone` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` text NOT NULL,
  `bio` text NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `created`, `modified`, `token`, `password`, `last_login`, `timezone`, `first_name`, `last_name`, `email`, `avatar`, `bio`) VALUES
(1, 0, 0, '', '', 0, '', 'Joe', 'Smith', '', '', ''),
(2, 1387163921, 1387163921, 'fa7488360e4a3812c9cff8320b85b6b5d2b84d42', '237f57f31595d823ecafd62ba78d4f61e2d2257f', 0, '', 'Dare', 'Makun', 'dremak11@gmail.com', '', ''),
(3, 1387222767, 1387222767, '9cf8918b6aea50e208ac9e9e8c7a80e10da9155b', '68580f76996c87a43dd83fa6067a3e2d93c90ae6', 0, '', 'Morgan', 'Freeman', 'mfreeman@gmail.com', '3.png', 'I''m a great actor\r\n'),
(4, 1387258950, 1387258950, '75c667c98630f68809e61acd7760516f1e9d100e', '9f54eca12e1eca8df2e2ec137ac8734a7d9d0c95', 0, '', 'Dare', 'Makun', 'dmakun@gmail.com', 'sample.jpg', 'Author testing out this...'),
(5, 1387315576, 1387315576, '3d1d8a18bc268ef860273906d59ed445ff314949', 'd8517baf1e42e2ebadd6c6c1a7409a2ab61ef7a8', 0, '', 'Garth', 'Brooks', 'gbrooks@gmail.com', 'sample.jpg', 'I play the guitar great!!');

-- --------------------------------------------------------

--
-- Table structure for table `users_users`
--

CREATE TABLE `users_users` (
  `user_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_id_followed` int(11) NOT NULL,
  PRIMARY KEY (`user_user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `users_users`
--

INSERT INTO `users_users` (`user_user_id`, `created`, `user_id`, `user_id_followed`) VALUES
(2, 1387222840, 3, 2),
(3, 1387222841, 3, 1),
(4, 1387258984, 4, 3),
(5, 1387258987, 4, 2),
(6, 1387258988, 4, 1),
(7, 1387298622, 3, 3),
(8, 1387298626, 3, 4),
(9, 1387315680, 5, 4),
(10, 1387315683, 5, 2),
(11, 1387315684, 5, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

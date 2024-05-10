-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2024 at 10:31 PM
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
-- Database: `servertest`
--

-- --------------------------------------------------------

--
-- Table structure for table `activeemployees`
--

CREATE TABLE `activeemployees` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(20) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `team_number` int(11) DEFAULT NULL,
  `task_number` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activeemployees`
--

INSERT INTO `activeemployees` (`id`, `employee_id`, `firstname`, `lastname`, `team_number`, `task_number`) VALUES
(1, 'emp001', 'Peter', 'Clarke', 1, 1),
(2, 'emp002', 'Jane', 'Smith', 3, 2),
(3, 'emp003', 'Michael', 'Johnson', 3, 9),
(5, 'emp005', 'David', 'Brown', 2, 5),
(6, 'emp006', 'Emily', 'Miller', 3, 6),
(7, 'emp007', 'Christopher', 'Davis', 1, 7),
(10, 'emp009', 'John', 'Doe', 2, 9);

-- --------------------------------------------------------

--
-- Table structure for table `activeexample`
--

CREATE TABLE `activeexample` (
  `ID` int(11) NOT NULL,
  `teamName` text NOT NULL,
  `TaskCompleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activeexample`
--

INSERT INTO `activeexample` (`ID`, `teamName`, `TaskCompleted`) VALUES
(1, 'Sunday', 0),
(2, 'Monday', 200),
(5, 'Tuesday', 400),
(6, 'Wednesday', 300),
(7, 'Thursday', 303),
(8, 'Friday', 405),
(9, 'Saturday', 0);

-- --------------------------------------------------------

--
-- Table structure for table `activeprojects`
--

CREATE TABLE `activeprojects` (
  `ProjectID` int(11) NOT NULL,
  `ProjectName` varchar(255) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `DueDate` date DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `ManagerID` int(11) DEFAULT NULL,
  `Colour` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activeprojects`
--

INSERT INTO `activeprojects` (`ProjectID`, `ProjectName`, `Description`, `DueDate`, `Status`, `ManagerID`, `Colour`) VALUES
(1, 'ProjectA', 'Description for ProjectA', '2024-03-02', 'Ongoing', 1, '#9963d9'),
(2, 'ProjectB', 'Description for ProjectB', '2024-04-15', 'Not Started', 1, '#9963d9'),
(3, 'ProjectC', 'Description for ProjectC', '2024-05-20', 'Complete', 2, 'purple');

-- --------------------------------------------------------

--
-- Table structure for table `activetasks`
--

CREATE TABLE `activetasks` (
  `TaskID` int(11) NOT NULL,
  `TaskName` varchar(255) NOT NULL,
  `TaskDescription` text DEFAULT NULL,
  `TaskStatus` varchar(50) DEFAULT NULL,
  `DueDate` date DEFAULT NULL,
  `IsPrivate` tinyint(1) NOT NULL,
  `TaskDuration` int(10) NOT NULL,
  `Colour` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activetasks`
--

INSERT INTO `activetasks` (`TaskID`, `TaskName`, `TaskDescription`, `TaskStatus`, `DueDate`, `IsPrivate`, `TaskDuration`, `Colour`) VALUES
(1, 'Task1', 'Description for Task1', 'Ongoing', '2024-03-05', 0, 5, 'royalblue'),
(2, 'Task2', 'Description for Task2', 'Ongoing', '2024-04-18', 0, 4, 'purple'),
(3, 'Task3', 'Description for Task3', 'Complete', '2024-05-22', 1, 6, 'royalblue'),
(4, 'PrivateTask2', 'AA', 'Complete', '2024-02-25', 1, 23, '#c03a00'),
(5, 'test1', '4241', 'Overdue', '2024-02-17', 0, 2, 'royalblue'),
(6, 'test1', '4241', 'Ongoing', '2024-02-17', 0, 2, 'royalblue'),
(10, 'PrivateTask1q', 'r23r2', 'Overdue', '2024-02-09', 1, 2, 'royalblue');

-- --------------------------------------------------------

--
-- Table structure for table `activeuserprojects`
--

CREATE TABLE `activeuserprojects` (
  `UserID` int(11) NOT NULL,
  `ProjectID` int(11) NOT NULL,
  `IsTeamLeader` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activeuserprojects`
--

INSERT INTO `activeuserprojects` (`UserID`, `ProjectID`, `IsTeamLeader`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 1, 0),
(3, 2, 0),
(4, 1, 1),
(5, 1, 0),
(6, 1, 0),
(6, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `activeusers`
--

CREATE TABLE `activeusers` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `UserType` varchar(50) NOT NULL,
  `isMod` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activeusers`
--

INSERT INTO `activeusers` (`UserID`, `Username`, `Email`, `Password`, `UserType`, `isMod`) VALUES
(1, 'Manager1', 'manager1@example.com', 'password123', 'Manager', 1),
(2, 'User1', 'user1@example.com', 'password456', 'TL', 1),
(3, 'User2', 'user2@example.com', 'password789', 'User', 0),
(5, 'manager3', 'user7@example.com', '1f30260af92365046a2bf9221c72a267d19e8d1d796acc4da58ffa96e3796358', 'Manager', 0),
(6, 'Employe4', 'employee3@example.com', '1f30260af92365046a2bf9221c72a267d19e8d1d796acc4da58ffa96e3796358', 'User', 0),
(7, 'testUser', 'test@example.com', 'password', 'User', 0),
(10, 'johndoe', 'johndoe@example.com', 'Password1', 'TL', 0);

-- --------------------------------------------------------

--
-- Table structure for table `activeusertasks`
--

CREATE TABLE `activeusertasks` (
  `UserID` int(11) NOT NULL,
  `TaskID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activeusertasks`
--

INSERT INTO `activeusertasks` (`UserID`, `TaskID`) VALUES
(1, 2),
(1, 4),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(3, 2),
(3, 3),
(3, 5),
(4, 4),
(6, 4),
(6, 10),
(7, 4);

-- --------------------------------------------------------

--
-- Table structure for table `activeweeklydata`
--

CREATE TABLE `activeweeklydata` (
  `id` int(11) NOT NULL,
  `day_of_week` varchar(20) DEFAULT NULL,
  `data_value` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activeweeklydata`
--

INSERT INTO `activeweeklydata` (`id`, `day_of_week`, `data_value`) VALUES
(1, 'Sunday', 2),
(2, 'Monday', 12),
(3, 'Tuesday', 9),
(4, 'Wednesday', 12),
(5, 'Thursday', 15),
(6, 'Friday', 19),
(7, 'Saturday', 5);

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `chatID` int(11) NOT NULL,
  `userID1` int(11) NOT NULL,
  `userID2` int(11) NOT NULL,
  `lastSender` int(11) NOT NULL,
  `isOpened` tinyint(1) NOT NULL,
  `lastEvent` datetime NOT NULL,
  `colour` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`chatID`, `userID1`, `userID2`, `lastSender`, `isOpened`, `lastEvent`, `colour`) VALUES
(7, 1, 2, 1, 0, '2024-05-10 17:29:23', 1),
(9, 3, 1, 3, 1, '2024-05-10 11:02:55', 2);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `CommentID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Content` varchar(250) NOT NULL,
  `PostID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`CommentID`, `UserID`, `Date`, `Content`, `PostID`) VALUES
(1, 1, '2024-01-03', 'Hey there2', 1),
(7, 1, '2024-02-05', '++', 2),
(8, 1, '2024-02-05', 'nice', 2),
(9, 4, '2024-02-14', '--', 2),
(14, 4, '2024-02-16', 'dqwd', 6);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(20) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `team_number` int(11) DEFAULT NULL,
  `task_number` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employee_id`, `firstname`, `lastname`, `team_number`, `task_number`) VALUES
(1, 'emp001', 'Peter', 'Clarke', 1, 1),
(2, 'emp002', 'Jane', 'Smith', 102, 2),
(3, 'emp003', 'Michael', 'Johnson', 103, 3),
(4, 'emp004', 'Sarah', 'Williams', 104, 4),
(5, 'emp005', 'David', 'Brown', 105, 5),
(6, 'emp006', 'Emily', 'Miller', 106, 6),
(7, 'emp007', 'Christopher', 'Davis', 107, 7),
(8, 'emp008', 'Amanda', 'Wilson', 108, 8),
(10, 'emp009', 'John', 'Doe', 109, 9);

-- --------------------------------------------------------

--
-- Table structure for table `example`
--

CREATE TABLE `example` (
  `ID` int(11) NOT NULL,
  `teamName` text NOT NULL,
  `TaskCompleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `example`
--

INSERT INTO `example` (`ID`, `teamName`, `TaskCompleted`) VALUES
(1, 'Sunday', 0),
(2, 'Monday', 2002),
(5, 'Tuesday', 2134),
(6, 'Wednesday', 300),
(7, 'Thursday', 1334),
(8, 'Friday', 1590),
(9, 'Saturday', 0);

-- --------------------------------------------------------

--
-- Table structure for table `groupmessages`
--

CREATE TABLE `groupmessages` (
  `MessageID` int(11) NOT NULL,
  `body` varchar(500) NOT NULL,
  `SenderID` int(11) NOT NULL,
  `GroupID` int(11) NOT NULL,
  `SentTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `GroupID` int(11) NOT NULL,
  `GroupName` varchar(50) NOT NULL,
  `lastSender` int(11) NOT NULL,
  `lastEvent` datetime NOT NULL,
  `colour` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`GroupID`, `GroupName`, `lastSender`, `lastEvent`, `colour`) VALUES
(1, 'Group 1', 1, '2024-05-01 14:42:28', 0),
(36, 'Group 2', 3, '2024-05-10 18:42:21', 4),
(37, 'Group 3', 3, '2024-05-10 18:51:03', 3);

-- --------------------------------------------------------

--
-- Table structure for table `lastweekemployees`
--

CREATE TABLE `lastweekemployees` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(20) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `team_number` int(11) DEFAULT NULL,
  `task_number` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lastweekemployees`
--

INSERT INTO `lastweekemployees` (`id`, `employee_id`, `firstname`, `lastname`, `team_number`, `task_number`) VALUES
(1, 'emp001', 'Peter', 'Clarke', 1, 1),
(3, 'emp003', 'Michael', 'Johnson', 2, 10),
(4, 'emp004', 'Sarah', 'Williams', 1, 13),
(6, 'emp006', 'Emily', 'Miller', 3, 6),
(7, 'emp007', 'Christopher', 'Davis', 1, 1),
(10, 'emp009', 'John', 'Doe', 1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `lastweekexample`
--

CREATE TABLE `lastweekexample` (
  `ID` int(11) NOT NULL,
  `teamName` text NOT NULL,
  `TaskCompleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lastweekexample`
--

INSERT INTO `lastweekexample` (`ID`, `teamName`, `TaskCompleted`) VALUES
(1, 'Sunday', 0),
(2, 'Monday', 150),
(5, 'Tuesday', 200),
(6, 'Wednesday', 300),
(7, 'Thursday', 100),
(8, 'Friday', 60),
(9, 'Saturday', 0);

-- --------------------------------------------------------

--
-- Table structure for table `lastweekprojects`
--

CREATE TABLE `lastweekprojects` (
  `ProjectID` int(11) NOT NULL,
  `ProjectName` varchar(255) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `DueDate` date DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `ManagerID` int(11) DEFAULT NULL,
  `Colour` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lastweekprojects`
--

INSERT INTO `lastweekprojects` (`ProjectID`, `ProjectName`, `Description`, `DueDate`, `Status`, `ManagerID`, `Colour`) VALUES
(1, 'ProjectA', 'Description for ProjectA', '2024-03-02', 'Ongoing', 1, '#9963d9'),
(2, 'ProjectB', 'Description for ProjectB', '2024-04-15', 'Not Started', 1, '#9963d9'),
(3, 'ProjectC', 'Description for ProjectC', '2024-05-20', 'Complete', 2, 'purple');

-- --------------------------------------------------------

--
-- Table structure for table `lastweektasks`
--

CREATE TABLE `lastweektasks` (
  `TaskID` int(11) NOT NULL,
  `TaskName` varchar(255) NOT NULL,
  `TaskDescription` text DEFAULT NULL,
  `TaskStatus` varchar(50) DEFAULT NULL,
  `DueDate` date DEFAULT NULL,
  `IsPrivate` tinyint(1) NOT NULL,
  `TaskDuration` int(10) NOT NULL,
  `Colour` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lastweektasks`
--

INSERT INTO `lastweektasks` (`TaskID`, `TaskName`, `TaskDescription`, `TaskStatus`, `DueDate`, `IsPrivate`, `TaskDuration`, `Colour`) VALUES
(1, 'Task1', 'Description for Task1', 'Ongoing', '2024-03-05', 0, 5, 'royalblue'),
(2, 'Task2', 'Description for Task2', 'Ongoing', '2024-04-18', 0, 4, 'purple'),
(3, 'Task3', 'Description for Task3', 'Complete', '2024-05-22', 1, 6, 'royalblue'),
(4, 'PrivateTask2', 'AA', 'Complete', '2024-02-25', 1, 23, '#c03a00'),
(5, 'test1', '4241', 'Overdue', '2024-02-17', 0, 2, 'royalblue'),
(6, 'test1', '4241', 'Overdue', '2024-02-17', 0, 2, 'royalblue'),
(10, 'PrivateTask1q', 'r23r2', 'Overdue', '2024-02-09', 1, 2, 'royalblue');

-- --------------------------------------------------------

--
-- Table structure for table `lastweekuserprojects`
--

CREATE TABLE `lastweekuserprojects` (
  `UserID` int(11) NOT NULL,
  `ProjectID` int(11) NOT NULL,
  `IsTeamLeader` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lastweekuserprojects`
--

INSERT INTO `lastweekuserprojects` (`UserID`, `ProjectID`, `IsTeamLeader`) VALUES
(1, 2, 1),
(2, 1, 1),
(3, 1, 0),
(3, 2, 0),
(4, 1, 1),
(5, 1, 0),
(6, 1, 0),
(6, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lastweekusers`
--

CREATE TABLE `lastweekusers` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `UserType` varchar(50) NOT NULL,
  `isMod` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lastweekusers`
--

INSERT INTO `lastweekusers` (`UserID`, `Username`, `Email`, `Password`, `UserType`, `isMod`) VALUES
(1, 'Manager1', 'manager1@example.com', 'password123', 'Manager', 1),
(2, 'User1', 'user1@example.com', 'password456', 'TL', 1),
(3, 'User2', 'user2@example.com', 'password789', 'User', 0),
(4, 'Employee22', 'test5@example.com', '1f30260af92365046a2bf9221c72a267d19e8d1d796acc4da58ffa96e3796358', 'Manager', 1),
(5, 'manager3', 'user7@example.com', '1f30260af92365046a2bf9221c72a267d19e8d1d796acc4da58ffa96e3796358', 'Manager', 0),
(6, 'Employe4', 'employee3@example.com', '1f30260af92365046a2bf9221c72a267d19e8d1d796acc4da58ffa96e3796358', 'User', 0),
(7, 'testUser', 'test@example.com', '1f30260af92365046a2bf9221c72a267d19e8d1d796acc4da58ffa96e3796358', 'User', 0),
(8, 'TEST', 'TEST', 'TEST', 'User', 0),
(9, 'dqwwdq', 'test@make-it-all.co.uk', '1f30260af92365046a2bf9221c72a267d19e8d1d796acc4da58ffa96e3796358', 'User', 0),
(10, 'johndoe', 'johndoe@example.com', 'Password1', 'TL', 0);

-- --------------------------------------------------------

--
-- Table structure for table `lastweekusertasks`
--

CREATE TABLE `lastweekusertasks` (
  `UserID` int(11) NOT NULL,
  `TaskID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lastweekusertasks`
--

INSERT INTO `lastweekusertasks` (`UserID`, `TaskID`) VALUES
(1, 1),
(1, 2),
(1, 4),
(1, 5),
(2, 1),
(2, 2),
(2, 4),
(2, 5),
(3, 2),
(3, 3),
(3, 4),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(5, 1),
(5, 2),
(6, 10);

-- --------------------------------------------------------

--
-- Table structure for table `lastweekweeklydata`
--

CREATE TABLE `lastweekweeklydata` (
  `id` int(11) NOT NULL,
  `day_of_week` varchar(20) DEFAULT NULL,
  `data_value` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lastweekweeklydata`
--

INSERT INTO `lastweekweeklydata` (`id`, `day_of_week`, `data_value`) VALUES
(1, 'Sunday', 2),
(2, 'Monday', 5),
(3, 'Tuesday', 23),
(4, 'Wednesday', 12),
(5, 'Thursday', 5),
(6, 'Friday', 19),
(7, 'Saturday', 5);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `MessageID` int(11) NOT NULL,
  `body` varchar(500) NOT NULL,
  `SenderID` int(11) NOT NULL,
  `ReceiverID` int(11) NOT NULL,
  `SentTime` datetime NOT NULL,
  `chatID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`MessageID`, `body`, `SenderID`, `ReceiverID`, `SentTime`, `chatID`) VALUES
(13, 'Hello', 1, 2, '2024-05-10 17:29:23', 7);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `PostID` int(11) NOT NULL,
  `Title` varchar(50) NOT NULL,
  `UserID` int(50) NOT NULL,
  `Date` date NOT NULL,
  `Content` varchar(250) NOT NULL,
  `ThreadID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`PostID`, `Title`, `UserID`, `Date`, `Content`, `ThreadID`) VALUES
(1, 'How to build a bomb', 1, '2024-01-03', 'step 1 : [redacted]', 1),
(2, 'tax evasion 101', 1, '2024-02-04', 'we love tax', 1),
(6, 'public defacation', 4, '2024-02-16', 'poo everywhere!!!', 5);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `ProjectID` int(11) NOT NULL,
  `ProjectName` varchar(255) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `DueDate` date DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `ManagerID` int(11) DEFAULT NULL,
  `Colour` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`ProjectID`, `ProjectName`, `Description`, `DueDate`, `Status`, `ManagerID`, `Colour`) VALUES
(1, 'ProjectA', 'Description for ProjectA', '2024-03-02', 'Ongoing', 1, '#9963d9'),
(2, 'ProjectB', 'Description for ProjectB', '2024-04-15', 'Not Started', 1, '#9963d9'),
(3, 'ProjectC', 'Description for ProjectC', '2024-05-20', 'Complete', 2, 'purple');

-- --------------------------------------------------------

--
-- Table structure for table `taskprojects`
--

CREATE TABLE `taskprojects` (
  `TaskID` int(11) NOT NULL,
  `ProjectID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `taskprojects`
--

INSERT INTO `taskprojects` (`TaskID`, `ProjectID`) VALUES
(1, 1),
(2, 2),
(3, 3),
(5, 1),
(6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `TaskID` int(11) NOT NULL,
  `TaskName` varchar(255) NOT NULL,
  `TaskDescription` text DEFAULT NULL,
  `TaskStatus` varchar(50) DEFAULT NULL,
  `DueDate` date DEFAULT NULL,
  `IsPrivate` tinyint(1) NOT NULL,
  `TaskDuration` int(10) NOT NULL,
  `Colour` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`TaskID`, `TaskName`, `TaskDescription`, `TaskStatus`, `DueDate`, `IsPrivate`, `TaskDuration`, `Colour`) VALUES
(1, 'Task1', 'Description for Task1', 'Ongoing', '2024-03-05', 0, 5, 'royalblue'),
(2, 'Task2', 'Description for Task2', 'Not Started', '2024-04-18', 0, 4, 'purple'),
(3, 'Task3', 'Description for Task3', 'Completed', '2024-05-22', 1, 6, 'royalblue'),
(4, 'PrivateTask2', 'AA', 'Complete', '2024-02-25', 1, 23, '#c03a00'),
(5, 'test1', '4241', 'Not Started', '2024-02-17', 0, 2, 'royalblue'),
(6, 'test1', '4241', 'Not Started', '2024-02-17', 0, 2, 'royalblue'),
(10, 'PrivateTask1q', 'r23r2', 'Not Started', '2024-02-09', 1, 2, 'royalblue');

-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

CREATE TABLE `threads` (
  `ThreadID` int(11) NOT NULL,
  `Title` varchar(50) NOT NULL,
  `Date` date NOT NULL,
  `Content` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `threads`
--

INSERT INTO `threads` (`ThreadID`, `Title`, `Date`, `Content`) VALUES
(1, 'Illegal activities', '2024-01-03', 'Topics on illegal activities '),
(2, 'Software Development', '2024-01-17', 'Topics That are about Software Development'),
(4, 'Community', '2024-02-01', 'Posts about community'),
(5, 'Worker Violations', '2024-02-01', 'Topics that need OSHA attention');

-- --------------------------------------------------------

--
-- Table structure for table `userfriends`
--

CREATE TABLE `userfriends` (
  `userid` int(11) NOT NULL,
  `friendsid` int(11) NOT NULL,
  `is_accepted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userfriends`
--

INSERT INTO `userfriends` (`userid`, `friendsid`, `is_accepted`) VALUES
(1, 2, 1),
(1, 4, 1),
(3, 1, 1),
(5, 1, 0),
(6, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `usergroups`
--

CREATE TABLE `usergroups` (
  `GroupID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `is_newChat` tinyint(1) NOT NULL,
  `isOpened` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usergroups`
--

INSERT INTO `usergroups` (`GroupID`, `UserID`, `is_newChat`, `isOpened`) VALUES
(1, 1, 0, 0),
(1, 2, 1, 1),
(1, 4, 1, 1),
(36, 3, 0, 1),
(37, 1, 0, 1),
(37, 3, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `userprojects`
--

CREATE TABLE `userprojects` (
  `UserID` int(11) NOT NULL,
  `ProjectID` int(11) NOT NULL,
  `IsTeamLeader` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userprojects`
--

INSERT INTO `userprojects` (`UserID`, `ProjectID`, `IsTeamLeader`) VALUES
(1, 2, 1),
(2, 3, 1),
(3, 1, 0),
(3, 2, 0),
(4, 3, 1),
(5, 1, 0),
(6, 1, 0),
(6, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `UserType` varchar(50) NOT NULL,
  `isMod` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Email`, `Password`, `UserType`, `isMod`) VALUES
(1, 'Manager1', 'manager1@example.com', 'password123', 'Manager', 1),
(2, 'User1', 'user1@example.com', 'password456', 'User', 1),
(3, 'User2', 'user2@example.com', 'password789', 'User', 0),
(4, 'Employee22', 'test5@example.com', '1f30260af92365046a2bf9221c72a267d19e8d1d796acc4da58ffa96e3796358', 'Manager', 1),
(5, 'manager3', 'user7@example.com', '1f30260af92365046a2bf9221c72a267d19e8d1d796acc4da58ffa96e3796358', 'Manager', 0),
(6, 'Employe4', 'employee3@example.com', '1f30260af92365046a2bf9221c72a267d19e8d1d796acc4da58ffa96e3796358', 'User', 0),
(7, 'testUser', 'test@example.com', 'alex', 'User', 0),
(8, 'TEST', 'TEST', 'TEST', 'User', 0),
(9, 'dqwwdq', 'test@make-it-all.co.uk', '1f30260af92365046a2bf9221c72a267d19e8d1d796acc4da58ffa96e3796358', 'User', 0);

-- --------------------------------------------------------

--
-- Table structure for table `usertasks`
--

CREATE TABLE `usertasks` (
  `UserID` int(11) NOT NULL,
  `TaskID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usertasks`
--

INSERT INTO `usertasks` (`UserID`, `TaskID`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(6, 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`chatID`),
  ADD KEY `userID1` (`userID1`),
  ADD KEY `userID2` (`userID2`),
  ADD KEY `lastSender` (`lastSender`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `PostIDfr` (`PostID`);

--
-- Indexes for table `groupmessages`
--
ALTER TABLE `groupmessages`
  ADD PRIMARY KEY (`MessageID`),
  ADD KEY `SenderID` (`SenderID`),
  ADD KEY `GroupID` (`GroupID`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`GroupID`),
  ADD KEY `lastSender` (`lastSender`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`MessageID`),
  ADD KEY `SenderID` (`SenderID`),
  ADD KEY `ReceiverID` (`ReceiverID`),
  ADD KEY `chatID` (`chatID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`PostID`),
  ADD KEY `ThreadIDfr` (`ThreadID`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`ProjectID`),
  ADD KEY `ManagerID` (`ManagerID`);

--
-- Indexes for table `taskprojects`
--
ALTER TABLE `taskprojects`
  ADD PRIMARY KEY (`TaskID`,`ProjectID`),
  ADD KEY `ProjectID` (`ProjectID`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`TaskID`);

--
-- Indexes for table `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`ThreadID`);

--
-- Indexes for table `userfriends`
--
ALTER TABLE `userfriends`
  ADD PRIMARY KEY (`userid`,`friendsid`),
  ADD KEY `friendsid` (`friendsid`);

--
-- Indexes for table `usergroups`
--
ALTER TABLE `usergroups`
  ADD PRIMARY KEY (`GroupID`,`UserID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `userprojects`
--
ALTER TABLE `userprojects`
  ADD PRIMARY KEY (`UserID`,`ProjectID`),
  ADD KEY `ProjectID` (`ProjectID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `usertasks`
--
ALTER TABLE `usertasks`
  ADD PRIMARY KEY (`UserID`,`TaskID`),
  ADD KEY `TaskID` (`TaskID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `chatID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `groupmessages`
--
ALTER TABLE `groupmessages`
  MODIFY `MessageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `GroupID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `MessageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `PostID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `ProjectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `TaskID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `threads`
--
ALTER TABLE `threads`
  MODIFY `ThreadID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`userID1`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `chats_ibfk_2` FOREIGN KEY (`userID2`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `chats_ibfk_3` FOREIGN KEY (`lastSender`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `PostIDfr` FOREIGN KEY (`PostID`) REFERENCES `posts` (`PostID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `groupmessages`
--
ALTER TABLE `groupmessages`
  ADD CONSTRAINT `groupmessages_ibfk_1` FOREIGN KEY (`SenderID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `groupmessages_ibfk_2` FOREIGN KEY (`GroupID`) REFERENCES `groups` (`GroupID`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`SenderID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`ReceiverID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`chatID`) REFERENCES `chats` (`chatID`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `ThreadIDfr` FOREIGN KEY (`ThreadID`) REFERENCES `threads` (`ThreadID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`ManagerID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `taskprojects`
--
ALTER TABLE `taskprojects`
  ADD CONSTRAINT `taskprojects_ibfk_1` FOREIGN KEY (`TaskID`) REFERENCES `tasks` (`TaskID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `taskprojects_ibfk_2` FOREIGN KEY (`ProjectID`) REFERENCES `projects` (`ProjectID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `userfriends`
--
ALTER TABLE `userfriends`
  ADD CONSTRAINT `userfriends_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `userfriends_ibfk_2` FOREIGN KEY (`friendsid`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `usergroups`
--
ALTER TABLE `usergroups`
  ADD CONSTRAINT `usergroups_ibfk_1` FOREIGN KEY (`GroupID`) REFERENCES `groups` (`GroupID`),
  ADD CONSTRAINT `usergroups_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `userprojects`
--
ALTER TABLE `userprojects`
  ADD CONSTRAINT `userprojects_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `userprojects_ibfk_2` FOREIGN KEY (`ProjectID`) REFERENCES `projects` (`ProjectID`);

--
-- Constraints for table `usertasks`
--
ALTER TABLE `usertasks`
  ADD CONSTRAINT `usertasks_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `usertasks_ibfk_2` FOREIGN KEY (`TaskID`) REFERENCES `tasks` (`TaskID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

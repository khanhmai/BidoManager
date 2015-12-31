/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  v-kamai
 * Created: Dec 15, 2015
 */

CREATE TABLE `user` (
  `Id` int(11) NOT NULL,
  `Username` varchar(700) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `Name` varchar(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Username` (`Username`);
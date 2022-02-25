-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2021 at 03:17 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recipebooks`
--

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int(11) NOT NULL,
  `recipe_id` bigint(11) NOT NULL,
  `ingredient` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`id`, `recipe_id`, `ingredient`) VALUES
(1, 162169079550, '1 1/2 cups (355 ml) warm water (105°F-115°F)'),
(2, 162169079550, '1 package (2 1/4 teaspoons) active dry yeast'),
(3, 162169079550, '3 3/4 cups (490 g) bread flour'),
(4, 162169079550, '2 tablespoons extra virgin olive oil (omit if cooking pizza in a wood-fired pizza oven)'),
(5, 162169079550, '2 teaspoons salt'),
(6, 162169079550, '1 teaspoon sugar'),
(7, 1480355097567, '2 cup all-purpose flour'),
(8, 1480355097567, '2 cups granulated sugar'),
(9, 1480355097567, '3/4 cup Dutch-processed cocoa powder sifted'),
(10, 1480355097567, '2 tsp baking soda'),
(11, 1480355097567, '1 tsp baking powder'),
(12, 1480355097567, '1 tsp salt'),
(13, 1480355097567, '1/2 cup vegetable oil'),
(14, 1480355097567, '1 cup buttermilk room temperature'),
(15, 1480355097567, '1 cup hot water'),
(16, 1480355097567, '2 large eggs'),
(17, 1480355097567, '2 tsp vanilla'),
(18, 95860816899, '12 to 18 pieces boiled quail eggs'),
(19, 95860816899, '1 cup flour'),
(20, 95860816899, '3 tbsp cornstarch'),
(21, 95860816899, '3/4 to 1 cup water'),
(22, 95860816899, '1 tbsp anatto powder pinulbos na atsuete'),
(23, 95860816899, '1/2 tsp salt'),
(24, 95860816899, '1/2 tsp ground black pepper'),
(25, 95860816899, '2 cups cooking oil'),
(26, 1066285507495, '2 cups water'),
(27, 1066285507495, '1/3 cup soy sauce'),
(28, 1066285507495, '1 head garlic, peeled and minced'),
(29, 1066285507495, '3 shallots, peeled and finely chopped'),
(30, 1066285507495, '4 Thai chili peppers, stemmed and finely chopped'),
(31, 1066285507495, '1 cup brown sugar'),
(32, 1066285507495, '1 tablespoon flour'),
(33, 1066285507495, '1 tablespoon cornstarch'),
(34, 1066285507495, '1 teaspoon salt'),
(35, 1066285507495, '1/2 teaspoon pepper ');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipe_id` bigint(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `user_id`, `recipe_id`, `rating`, `comments`) VALUES
(1, 1, 162169079550, 0, ''),
(2, 1, 162169079550, 3, 'Good pizza recipe'),
(3, 2, 162169079550, 5, 'very very good pizza recipe'),
(4, 1, 1480355097567, 0, ''),
(5, 1, 95860816899, 0, ''),
(6, 3, 1066285507495, 0, ''),
(8, 4, 95860816899, 4, 'This recipe is so good!'),
(10, 5, 95860816899, 4, 'testing rating'),
(11, 5, 95860816899, 5, '1231 23131 3123 131 312 ');

-- --------------------------------------------------------

--
-- Table structure for table `recipe`
--

CREATE TABLE `recipe` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipe_id` bigint(11) NOT NULL,
  `recipe_name` varchar(50) NOT NULL,
  `recipe_description` varchar(1000) NOT NULL,
  `servings` varchar(250) NOT NULL,
  `cook_time` varchar(250) NOT NULL,
  `img_name` varchar(1000) NOT NULL,
  `category` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recipe`
--

INSERT INTO `recipe` (`id`, `user_id`, `recipe_id`, `recipe_name`, `recipe_description`, `servings`, `cook_time`, `img_name`, `category`) VALUES
(2, 1, 162169079550, 'Pizza', 'This is a classic homemade pizza recipe, including a pizza dough recipe, topping suggestions, and step-by-step instructions with photos. Make perfect pizza at home!', '6', '120', 'pizza.png', 'dish'),
(3, 1, 1480355097567, 'Black Forest Cake', 'Cake is a form of sweet food made from flour, sugar, and other ingredients, that is usually baked. In their oldest forms, cakes were modifications of bread, but cakes now cover a wide range of preparations ...', '12', '200', 'blackforestcake.png', 'dessert'),
(4, 1, 95860816899, 'Tokneneng', 'Tokneneng or tukneneng is a tempura-like Filipino street food made by deep-frying orange batter covered hard-boiled duck eggs. A popular variation of tukneneng is kwek kwek. The main difference between the two lies in the egg that is used.', '4', '5', 'kwekwek.png', 'street'),
(5, 3, 1066285507495, 'Fish Ball', 'Homemade Fish Balls are as fun to make as they are to eat! Soft and bouncy, they’re popular as street food with spicy fish ball sauce but just as delicious in soups or stir-fries.', '6', '30', 'fishball.png', 'street');

-- --------------------------------------------------------

--
-- Table structure for table `steps`
--

CREATE TABLE `steps` (
  `id` int(11) NOT NULL,
  `recipe_id` bigint(11) NOT NULL,
  `steps` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `steps`
--

INSERT INTO `steps` (`id`, `recipe_id`, `steps`) VALUES
(1, 162169079550, 'Place the warm water in the large bowl of a heavy duty stand mixer. Sprinkle the yeast over the warm water and let it sit for 5 minutes until the yeast is dissolved.'),
(2, 162169079550, 'Add the flour, salt, sugar, and olive oil, and using the mixing paddle attachment, mix on low speed for a minute. Then replace the mixing paddle with the dough hook attachment.'),
(3, 162169079550, 'Spread a thin layer of olive oil over the inside of a large bowl. Place the pizza dough in the bowl and turn it around so that it gets coated with the oil.'),
(4, 162169079550, 'After the pizza dough has risen, you can freeze it to use later. Divide the dough in half (or the portion sizes you will be using to make your pizzas). Place on parchment paper or a lightly floured dish and place, uncovered, in the freezer for 15 to 20 minutes. Then remove from the freezer, and place in individual freezer bags, removing as much air as you can from the bags. Return to the freezer and store for up to 3 months.'),
(5, 1480355097567, 'Preheat oven to 350F, grease two 8\" round baking pans and dust with cocoa powder. Line bottoms with parchment.'),
(6, 1480355097567, 'Place all dry ingredients into the bowl of a stand mixer fitted with a paddle attachment. Stir to combine.'),
(7, 1480355097567, 'In a medium bowl whisk all wet ingredients (pour hot water in slowly as not to cook the eggs).'),
(8, 1480355097567, 'Add wet ingredients to dry and mix on medium for 2-3 mins. Batter will be very thin.'),
(9, 1480355097567, 'Pour evenly into prepared pans. I used a kitchen scale to ensure the batter is evenly distributed.'),
(10, 1480355097567, 'Bake for 45 mins or until a cake tester comes out mostly clean. '),
(11, 1480355097567, 'Cool 10 minutes in the pans then turn out onto a wire rack to cool completely. '),
(12, 95860816899, 'Place the cornstarch in a container and dredge the boiled quail eggs. Set aside.'),
(13, 95860816899, 'In a mixing bowl, combine flour, salt, and pepper then mix thoroughly.'),
(14, 95860816899, 'Dilute the anatto powder in warm water then pour-in the mixing bowl with the other ingredients. Mix well.'),
(15, 95860816899, 'Place all the quail eggs in the mixing bowl and coat with the batter.'),
(16, 95860816899, 'Heat the pan and pour the cooking oil.'),
(17, 95860816899, 'When the oil is hot enough, deep-fry the quail eggs by scooping them from the mixing bowl using a spoon. Make sure that each is coated with batter.'),
(18, 95860816899, 'After a few minutes, remove the fried quail eggs from the pan and place in a serving plate.'),
(19, 95860816899, 'Serve with vinegar or fish ball sauce while still crispy.'),
(20, 95860816899, 'Share and Enjoy!'),
(21, 1066285507495, 'In a food processor, grind the flesh into a thick paste. Alternatively, pound the fish flesh with the back of a knife until it turns to a thick paste.'),
(22, 1066285507495, 'In a bowl, combine the fish paste, salt, sugar, cornstarch, and water.'),
(23, 1066285507495, 'Using hands, stir the mixture until well combined and then shape into a big ball. Lift from the bowl and then slap back into the bowl. Repeat for about 10 to 15 minutes or until the fish paste is smooth and shiny and begins to pull away from the side of the bowl.'),
(24, 1066285507495, 'Alternatively, transfer the fish paste into the bowl of a stand mixer and using the paddle attachment, beat for about 10 to 15 minutes or until it begins to pull away from the side of the bowl.'),
(25, 1066285507495, 'Using a tablespoon, portion the fish paste and shape into balls by rolling between the palm of hands.'),
(26, 1066285507495, 'In a pot over medium heat, bring about 4 quarts of water to a boil. Gently drop fish balls into boiling water and cook for about 1 to 2 minutes or until they begin to float on top.'),
(27, 1066285507495, 'Using a slotted spoon, remove from the fish balls from water and allow to cool.'),
(28, 1066285507495, 'In a wide pan, heat about 2 inches of oil. Add fish balls and cook, stirring occasionally, until golden and puffed. Remove from heat and drain on paper towels.'),
(29, 1066285507495, 'Serve with the sweet and spicy fish ball sauce.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `password`) VALUES
(1, 'Zenovain', 'Kenneth', 'Rada', '123'),
(2, 'Curfy', 'Kenneth', 'Rada', '123'),
(3, 'alvin', 'Alvin', 'Patrico', '123'),
(4, 'kenneth', 'Kenneth', 'Rada', '123'),
(5, 'Merin', 'merin', 'palafox', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipe_id` (`recipe_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Test` (`user_id`);

--
-- Indexes for table `steps`
--
ALTER TABLE `steps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `steps_ibfk_1` (`recipe_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `recipe`
--
ALTER TABLE `recipe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `steps`
--
ALTER TABLE `steps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `recipe`
--
ALTER TABLE `recipe`
  ADD CONSTRAINT `Test` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

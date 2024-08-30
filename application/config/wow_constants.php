<?php

$config['races'] = lang("races", "wow_constants");
$config['classes'] = lang("classes", "wow_constants");
$config['alliance_races'] = [1,3,4,7,11,22,25,29,30,32,34,37,52,85];
$config['horde_races'] = [2,5,6,8,9,10,26,27,28,31,35,36,70,84];
// Do not edit these unless you edit the corrosponding files names in:
// application/images/avatars/
$config['races_en'] = [
    1 => "Human",
    2 => "Orc",
    3 => "Dwarf",
    4 => "Night elf",
    5 => "Undead",
    6 => "Tauren",
    7 => "Gnome",
    8 => "Troll",
    9 => "Goblin",
    10 => "Blood elf",
    11 => "Draenei",
    22 => "Worgen",
    24 => "Pandaren",
    25 => "Pandaren",
    26 => "Pandaren",
    27 => "Nightborne",
    28 => "Highmountain Tauren",
    29 => "Void elf",
    30 => "Lightforged Dranei",
    31 => "Zandalari Troll",
    32 => "Kul Tiran",
    34 => "Dark Iron Dwarf",
    35 => "Vulpera",
    36 => "Mag'har Orc",
    37 => "Mechagnome",
    52 => "Dracthyr",
    70 => "Dracthyr",
    84 => "Earthen",
    85 => "Earthen",
];

$config['classes_en'] = [
    1 => "Warrior",
    2 => "Paladin",
    3 => "Hunter",
    4 => "Rogue",
    5 => "Priest",
    6 => "Death knight",
    7 => "Shaman",
    8 => "Mage",
    9 => "Warlock",
    10 => "Monk",
    11 => "Druid",
    12 => "Demon Hunter",
    13 => "Evoker"
];

$config['expansion_races'] = [
    0 =>  [1, 2, 3, 4, 5, 6, 7, 8],
    1 =>  [1, 2, 3, 4, 5, 6, 7, 8, 10, 11],
    2 =>  [1, 2, 3, 4, 5, 6, 7, 8, 10, 11],
    3 =>  [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 22],
    4 =>  [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 22, 24, 25, 26],
    5 =>  [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 22, 24, 25, 26],
    6 =>  [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 22, 24, 25, 26],
    7 =>  [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 22, 24, 25, 26, 26, 27, 28, 29, 30, 31, 32, 34, 35, 36, 37],
    8 =>  [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 22, 24, 25, 26, 26, 27, 28, 29, 30, 31, 32, 34, 35, 36, 37],
    9 =>  [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 22, 24, 25, 26, 26, 27, 28, 29, 30, 31, 32, 34, 35, 36, 37, 52, 70],
    10 => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 22, 24, 25, 26, 26, 27, 28, 29, 30, 31, 32, 34, 35, 36, 37, 52, 70, 84, 85],
];

$config['expansion_class'] = [
    0  => [1, 2, 3, 4, 5, 7, 8, 9, 11],
    1  => [1, 2, 3, 4, 5, 7, 8, 9, 11],
    2  => [1, 2, 3, 4, 5, 6, 7, 8, 9, 11],
    3  => [1, 2, 3, 4, 5, 6, 7, 8, 9, 11],
    4  => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
    5  => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
    6  => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
    7  => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
    8  => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
    9  => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
    10 => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
];

$config['itemtype_en'] = [
    0 => 'Consumable',
    1 => 'Container',
    2 => 'Weapon',
    3 => 'Gem',
    4 => 'Armor',
    5 => 'Reagent',
    6 => 'Projectile',
    7 => 'Trade Goods',
    8 => 'Item Enhancement',
    9 => 'Recipe',
    10 => 'Money',
    11 => 'Quiver',
    12 => 'Quest',
    13 => 'Key',
    14 => 'Permanent',
    15 => 'Miscellaneous',
    16 => 'Glyph',
    17 => 'Battle Pets',
    18 => 'WoW Token',
    19 => 'Profession'
];

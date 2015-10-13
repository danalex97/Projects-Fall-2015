Overview
========

The project is aimed to demonstrate some functionalities of SFML library applied to building a simple one person game. Note that the most functions have not yet been developed. A list of to be implemented functions can be found in comments in “index.cpp”.

The Game
========

The SFML Game is a first person shooter in development. At the moment the functionality available are based on dodging the enemies. Two types of objects have been already introduced are enemy ships and asteroids. 

The player has 4 keyboard controles. Up and Down are used to move forward and backward, left and right are used to fix the angle on which the ship is sliding. The ship will slide faster at bigger angles.

Libraries and sources
=====================

* constants.h
This library loads the textures and the patterns for the AI movement. Also the textures are configured in sprites. 

* gen.cpp
This file is a generator for the patterns of AI object movement.

* protocoles.h
This library includes the basic geometric methods used in the object movement. Even though is seems a 3D game, the functions are written on 2D basic geometry. The functions in this library include spawning an object, collapsing an object, the left-right and up-down protocols. 

* enemy.h
This library contains the object descriptions and the rules on which they function. At the moment 3 object categories have been introduced. The functions are made to be generalised, therefore new object category can be introduced in a simple way.


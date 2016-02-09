#include <SFML/Graphics.hpp>
#include <SFML/Audio.hpp>
#include "enemy.h"
#include <vector>
#include <ctime>
#include <cstdlib>
#include <cmath>
#include <fstream>
using namespace std;
using namespace sf;

namespace gen {
	
	const int levels = 4;
	//const int levels = 1;
	int tm[100] = { 0 , 3 , 2 , 4 , 10 , 10 , 0 };
	
	vector<object::enemy> make(int lvl)
	{
		vector<object::enemy> e;
		e.push_back( object::make_ship() );
		switch (lvl)
		{
			case 0: 
				break;
			case 1:
				for (int i=1;i<=2;++i) e.push_back( object::make_asteroid() ) , e[i].spawn(1300+400*(i-1));
				for (int i=3;i<=3;++i) e.push_back( object::make_satelite() ) , e[i].spawn(1300+400*(i-1));
				break;
			case 2:
				for (int i=1;i<=4;++i) e.push_back( object::make_satelite() ) , e[i].spawn(1300+400*(i-1));
				break;
			case 3: 
				for (int i=1;i<=3;++i) e.push_back( object::make_asteroid() ) , e[i].spawn(1300+400*(i-1));
				for (int i=4;i<=4;++i) e.push_back( object::make_satelite() ) , e[i].spawn(1300+400*(i-1));
				break;
			case 4:
				e.push_back( object::make_asteroid() ) , e[1].spawn(1300+400);
				e.push_back( object::make_satelite() ) , e[2].spawn(1300+400*2);
				e.push_back( object::make_asteroid() ) , e[3].spawn(1300+400*3);
				e.push_back( object::make_satelite() ) , e[4].spawn(1300+400*4);
				e.push_back( object::make_asteroid() ) , e[5].spawn(1300+400*5);
				e.push_back( object::make_satelite() ) , e[6].spawn(1300+400*6);
				break;
			case 5:
				for (int i=1;i<=5;++i) e.push_back( object::make_asteroid() ) , e[i].spawn(1300+400*(i-1));
				for (int i=6;i<=7;++i) e.push_back( object::make_satelite() ) , e[i].spawn(1300+400*(i-1));
				break;
				
		}
		return e;
	}
	
	struct level {
		vector<object::enemy> objects;
		int lvl;
		int time;
		level() {
		}
		level(int niv) {
			lvl = niv;
			time = tm[niv];
			objects = make(niv);
		}
	};
};

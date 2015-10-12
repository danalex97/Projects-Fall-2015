#include <SFML/Graphics.hpp>
#include <SFML/Audio.hpp>
#include "protocoles.h"
#include <vector>
#include <ctime>
#include <cstdlib>
#include <cmath>
#include <fstream>
using namespace std;
using namespace sf;

namespace object {

	struct enemy {
		Sprite s;
		Sound snd;
		int loaded;
		int step,pattern,type;
		enemy(){
		}
		enemy(Sprite s2,int _type) {
			s = s2;
			step = 0;
			pattern = -1;
			type = _type;
			loaded = 0;
		}
		void load_sound(Sound sd)
		{
			snd = sd;
			loaded = 1;
		}
		void spawn(int place)
		{
			proto::spawn(s,place,type); 
			
			for (int i=1;i<=7;++i) fix::sound[i].stop();
			int wh = rand()%7+1;
			fix::sound[wh].setVolume( 60+rand()%40 );
			fix::sound[wh].play();
					
			/*for (int i=1;i<=7;++i)
				if ( fix::sound[i].getStatus() == sf::Sound::Stopped ) 
				{
					fix::sound[i].setVolume( 50+rand()%50 );
					fix::sound[i].play();
					break;
				}
			*/ 
		}
		void AI_protocole()
		{
			if ( pattern == -1 ) pattern = rand() % int(fix::dir.size());
			int d = fix::dir[pattern][step++];
			if ( step == int(fix::dir[pattern].size()) ) pattern = -1, step = 0;
		
			proto::left_right_protocole(s,0,1-d,d);	
			proto::up_down_protocole(s,0,0,1);
		}
		int move(int by_player)
		{
			int spawned = 0;
			if ( by_player )
			{
				proto::up_down_protocole(s,1,0,0);
				proto::left_right_protocole(s,1,0,0);
			}
			else
			{
				if ( type == 0 )
				{
					proto::up_down_protocole(s,0,0,1);
					Vector2f ps = s.getPosition();
					if ( ps.y > 600 ) spawn(1300), spawned = 1;
				}
				else
				{
					AI_protocole();
					Vector2f ps = s.getPosition();
					if ( ps.y > 600 ) spawn(1600), spawned = 1;
				}
			}
			
			int sound_flag = 1;
			for (int i=1;i<=7;++i) 
				if ( fix::sound[i].getStatus() != sf::Sound::Stopped  )
					sound_flag = 0;
			if ( sound_flag && loaded && ( proto::rotation(s) <= -20 || proto::rotation(s) >= 20 ) )
			{
				if ( snd.getStatus() == sf::Sound::Stopped ) 
				{
					snd.setVolume( (s.getPosition().y/100) ); // 20
					snd.play();
				}
			} 
			return spawned;
		}
	};
	
	enemy make_asteroid()
	{
		Sprite t2(fix::texture[1]); t2.setPosition(fix::window_width/2-t2.getGlobalBounds().width/2,400); 
		enemy ans = enemy(t2,0);
		return ans;
	}
	
	enemy make_satelite()
	{
		Sprite t2(fix::texture[2]); t2.setPosition(fix::window_width/2-t2.getGlobalBounds().width/2,400); 
		enemy ans = enemy(t2,1);
		ans.load_sound(fix::sound[7]);
		return ans;
	}
	
	enemy make_ship()
	{
		Sprite t1(fix::texture[0]); t1.setPosition(fix::window_width/2-t1.getGlobalBounds().width/2,400); 
		enemy ans = enemy(t1,0);
		ans.load_sound(fix::sound[0]);
		return ans;
	}
}

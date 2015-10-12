#include <SFML/Graphics.hpp>
#include <SFML/Audio.hpp>
#include "constants.h"
#include <vector>
#include <ctime>
#include <cstdlib>
#include <cmath>
#include <fstream>
using namespace std;
using namespace sf;

namespace proto {

	double rotation(Sprite s)
	{
		double much = s.getRotation();
		return much > 180 ? much-360 : much; 
	}

	double speed = 1.2;

	void up_down_protocole(Sprite& s,int key,int u,int d)
	{
		u = key ? Keyboard::isKeyPressed( Keyboard::Up ) : u;
		d = key ? Keyboard::isKeyPressed( Keyboard::Down ) : d;
		
		Vector2f scale = s.getScale();
		double ratio = 0.002;
		double up = 0.8;
		if ( u ) 
		{
			s.move(0,-scale.y*speed*up);
			s.setScale(scale.x*(1-ratio*speed*up),scale.y*(1-ratio*speed*up));
		}
		scale = s.getScale();
		double down = d ? 1 : 0.2;
		if ( 1 ) // d 
		{
			s.move(0,scale.y*speed*down);
			s.setScale(scale.x*(1+ratio*speed*down),scale.y*(1+ratio*speed*down));
		}
	}

	void left_right_protocole(Sprite& s,int key,int l,int r)
	{
		l = key ? Keyboard::isKeyPressed( Keyboard::Left ) : l;
		r = key ? Keyboard::isKeyPressed( Keyboard::Right ) : r;
		
		Vector2f scale = s.getScale();
		if ( l ) 
		{
			if ( rotation(s) < 20 ) 
			{
				s.rotate(1);		
				s.move(0,-scale.y*speed);
			}
		}
		if ( r ) 
		{
			if ( rotation(s) > -20 ) 
			{
				s.rotate(-1);
				s.move(0,scale.y*speed);
			}
		}
		if ( rotation(s) ) 
			s.move(0.1 * speed * rotation(s),0);
	}

	void spawn(Sprite& s,double dist,int by_scale)
	{
		if ( by_scale )
		{
			s.setScale(1,1); 
		}
		else
		{
			double scale = (rand()%50) / 100;
			s.setScale(1+scale,1+scale);
		}
		s.setPosition(fix::window_width/2-s.getGlobalBounds().width/2,400);
		if ( by_scale == 0 ) 
			for (int j=1;j<=100;++j)
			{
				int k = rand()%2;
				if ( k ) left_right_protocole(s,0,1,0);
				if ( !k ) left_right_protocole(s,0,0,1);
			}

		for (int j=1;j<=dist;++j)
			up_down_protocole(s,0,1,0);
		if ( by_scale == 0 ) 
			for (int j=1;j<=100;++j)
			{
				int k = rand()%2;
				if ( k ) left_right_protocole(s,0,1,0);
				if ( !k ) left_right_protocole(s,0,0,1);
			}
	}

	double dst(Vector2f a,Vector2f b)
	{
		return sqrt((a.x-b.x)*(a.x-b.x) + (a.y-b.y)*(a.y-b.y));
	}

	Vector2f center(Sprite s)
	{
		double w = s.getGlobalBounds().width;
		double l = s.getGlobalBounds().height;
		Vector2f ans = s.getPosition();
		ans.x += w/2;
		ans.y += l/2;
		return ans;
	} 

	int check(Sprite& s1,Sprite& s2) // checks collision of two sprites , but the sprites are not properly handled
	{
		double sc1 = s1.getScale().x;
		double sc2 = s2.getScale().x;
		double dist = 75;
		//G<< dst(s1.getPosition(),s2.getPosition())<<'\n';
		return dst(center(s1),center(s2)) < dist * min(sc1,sc2);
	}

	void colapse(Sprite& s)
	{
		Vector2f scale = s.getScale();
		double ratio = 0.002;
		double up = 2;
		s.setScale(scale.x*(1-ratio*speed*up),scale.y*(1-ratio*speed*up));
		s.rotate(rand()%2);
		up_down_protocole(s,0,1,0);
	}

	void teleport(Sprite& s)
	{
		Vector2f scale = s.getScale();
		double ratio = 0.002;
		double up = 2;
		s.setScale(scale.x*(1-ratio*speed*up),scale.y*(1-ratio*speed*up));
		//left_right_protocole(s,0,1,0);
		for (int i=1;i<=20;++i) up_down_protocole(s,0,1,0);
	}
}

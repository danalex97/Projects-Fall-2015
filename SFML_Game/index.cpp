#include <SFML/Graphics.hpp>
#include <SFML/Audio.hpp>
#include "levels.h"
#include <vector>
#include <ctime>
#include <cstdlib>
#include <cmath>
#include <fstream>
using namespace sf;
using namespace std;

ofstream error_stack("Utilities/erorrs.err");

// g++ test2.o -o sfml-app -lsfml-graphics -lsfml-window -lsfml-system -lsfml-audio
// ./sfml-app
// cd /home/danalex97/sfml2build/sfml2src

/******COMMENTS******** 
 ********************** 
 * Issues:            *
 * - object collision *
 * - move naturalism  *
 * - models           *
 * + fix 3D sonorising*
 * + ship model size  *
 * - stop sounds beg. *
 **********************
 
 ********************** 
 * To be implemented: *
 * - droid models     *
 * + spaceship models *
 * - asteroid frames  *
 * - asteroid rotation*
 * + leveling         *
 **********************
  
  ***************************
  * Proposals:	         	*             
  * - fireing ship (pulsar) * 
  * - choosing your fighter *
  ***************************/
  
VideoMode videoMode(fix::window_width,fix::window_height);
RenderWindow window(videoMode,"My Game");

object::enemy map = object::enemy();
const int frames = 100;
const int frames2 = 20;

int main()
{	
	bool stop_flag = 1;
	srand(time(0));
	
	if ( !fix::add_all_textures() )
		return EXIT_FAILURE;
	vector<Text> texts = fix::load_texts();
	
	enum states {BEG,PLAY,TRA,TRA2,PRE,WIN,LOSE};
	int gameState = BEG;
	int step = 0, timer = frames;
	gen::level niv = gen::level(step);
	while ( window.isOpen() )
	{
		window.clear(Color::Black);
		Event event;
		
		switch (gameState)
		{
			case BEG:
				window.draw( texts[0] ); 
				window.draw( texts[1] );
				break;
			case PLAY:
				for (int i=0;i<int(niv.objects.size());++i) window.draw( niv.objects[i].s );
				break;
			case TRA:
				for (int i=0;i<int(niv.objects.size());++i) window.draw( niv.objects[i].s );
				break;
			case TRA2:
				for (int i=0;i<int(niv.objects.size());++i) window.draw( niv.objects[i].s );
				break;
			case WIN:
				for (int i=0;i<int(niv.objects.size());++i) window.draw( niv.objects[i].s );
				window.draw( texts[2] );
				break;
			case LOSE:
				for (int i=0;i<int(niv.objects.size());++i) window.draw( niv.objects[i].s );
				window.draw( texts[3] );
				break;
		}
		window.display();
		
		while ( window.pollEvent(event) )
		{
			if ( event.type == Event::Closed || ( event.type == Event::KeyPressed && event.key.code==Keyboard::Escape) )
                window.close();    
            else
				if ( event.type == Event::KeyPressed && gameState == BEG )
					gameState = TRA;
		}
		
		if ( gameState == WIN )
		{
			for (int i=0;i<int(niv.objects.size());++i) niv.objects[i].move(0);
			continue;
		}
		
		if ( gameState == LOSE )
		{
			proto::colapse(niv.objects[0].s);
			for (int i=1;i<int(niv.objects.size());++i) niv.objects[i].move(0);
			for (int i=0;i<fix::number_of_sounds;++i) if ( i != 6 ) fix::sound[i].stop();
			for (int i=0;i<int(niv.objects.size());++i) niv.objects[i].snd.stop();
			if ( stop_flag )
			{
				fix::sound[6].play();
				stop_flag = 0;
			}
			continue;
		} 
		
		if ( gameState == TRA )
		{
			if ( timer-- ) 
			{
				proto::teleport(niv.objects[0].s);
				for (int i=1;i<int(niv.objects.size());++i) niv.objects[i].move(0);
			}
			else
				gameState = PRE;
			continue;
		}
		
		if ( gameState == TRA2 )
		{
			if ( timer-- )
			{
				proto::teleport(niv.objects[0].s);
				for (int i=1;i<int(niv.objects.size());++i) niv.objects[i].move(0);
			}
			else
			{
				if ( step > gen::levels )
					gameState = WIN;
				else
				{
					gameState = PLAY;
					timer = frames;
				}
			}
			continue;
		}
		
		if ( gameState == PRE )
		{
			niv = gen::level(++step);
			gameState = TRA2;
			timer = frames2;
			continue;
		}
		
        if ( gameState == PLAY ) 
			niv.objects[0].move(1);	 
		
		if ( gameState != BEG )
		{
			for (int i=1;i<int(niv.objects.size());++i)
				niv.time -= niv.objects[i].move(0);
			for (int i=1;i<int(niv.objects.size());++i)
				if ( proto::check(niv.objects[0].s,niv.objects[i].s) )
					gameState = LOSE;
		}
		
		if ( niv.time == 0 && gameState != BEG )
			gameState = TRA;
	}
    return EXIT_SUCCESS;
}

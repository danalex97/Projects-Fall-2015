#include <SFML/Graphics.hpp>
#include <SFML/Audio.hpp>
#include <vector>
#include <ctime>
#include <cstdlib>
#include <cmath>
#include <fstream>
using namespace std;
using namespace sf;

namespace fix {
	const int window_width = 640;
	const int window_height = 480;
	
	ofstream error_stack("Utilities/erorrs.err");
	
	vector< vector<int> > load_from_file()
	{
		ifstream F("Utilities/patterns.txt");
		vector< vector<int> > ans;
		string line;
		while ( F>>line )
		{
			if ( line.empty() ) 
				break;
			vector<int> v;
			for (int i=0;i<int(line.size());++i) 
				v.push_back( int(line[i])-int('0') );
			ans.push_back( v );
		}
		F.close();
		return ans;
	}

	vector< vector<int> > dir = load_from_file();
	
	Font font;
	Texture texture[10];
	SoundBuffer buffer[10];
	Sound sound[10];

	const int number_of_sounds = 8;
	const int number_of_textures = 3;

	#define sound_error 3
	#define texture_error 2
	#define font_error 1

	void load_textures()
	{
		if (!font.loadFromFile("Fonts/font.ttf")) throw font_error; 
		if (!texture[0].loadFromFile("Textures/xwing2.png")) throw texture_error;
		if (!texture[1].loadFromFile("Textures/ast4.png")) throw texture_error;
		if (!texture[2].loadFromFile("Textures/imp3.png")) throw texture_error;
	  
		if (!buffer[0].loadFromFile("Sounds/xwing.wav")) throw sound_error; sound[0].setBuffer(buffer[0]);  	
		if (!buffer[1].loadFromFile("Sounds/R2D2a.wav")) throw sound_error; sound[1].setBuffer(buffer[1]);  	
		if (!buffer[2].loadFromFile("Sounds/R2D2b.wav")) throw sound_error; sound[2].setBuffer(buffer[2]);  	
		if (!buffer[3].loadFromFile("Sounds/R2D2c.wav")) throw sound_error; sound[3].setBuffer(buffer[3]);  	
		if (!buffer[4].loadFromFile("Sounds/R2D2d.wav")) throw sound_error; sound[4].setBuffer(buffer[4]);  	
		if (!buffer[5].loadFromFile("Sounds/R2D2e.wav")) throw sound_error; sound[5].setBuffer(buffer[5]);  	
		if (!buffer[6].loadFromFile("Sounds/scream.wav")) throw sound_error; sound[6].setBuffer(buffer[6]);  	
		if (!buffer[7].loadFromFile("Sounds/tie_fighter.wav")) throw sound_error; sound[7].setBuffer(buffer[7]);  	
		//if (!sound[1].loadFromFile()) throw sound_error;
	}
		
	int add_all_textures()
	{
		try { 
			load_textures();
		} 
		catch(int exception) {
			if ( exception == font_error ) error_stack<<"failed loading font";
			if ( exception == texture_error ) error_stack<<"failed loading textures";
			if ( exception == sound_error ) error_stack<<"failed loading sounds";
			return 0;
		} 
		return 1;
	}

	vector<Text> load_texts()
	{
		vector<Text> ans;
		Text t1("SFML Star",font,50); t1.setPosition(window_width/2-t1.getGlobalBounds().width/2,100); t1.setColor(Color::Red); ans.push_back(t1);
		Text t2("Press any key to start",font,30); t2.setPosition(window_width/2-t2.getGlobalBounds().width/2,400); t2.setColor(Color::Red); ans.push_back(t2);
		Text t3("You win",font,50); t3.setPosition(window_width/2-t3.getGlobalBounds().width/2,100); t3.setColor(Color::Red); ans.push_back(t3);
		Text t4("Game over",font,50); t4.setPosition(window_width/2-t3.getGlobalBounds().width/2,100); t4.setColor(Color::Red); ans.push_back(t4);
		return ans;
	}

	vector<Sprite> load_sprites()
	{
		vector<Sprite> ans;
		Sprite t1(texture[0]); t1.setPosition(window_width/2-t1.getGlobalBounds().width/2,400); ans.push_back(t1);
		for (int i=0;i<5;++i)
		{
			Sprite t2(texture[1]); t2.setPosition(window_width/2-t2.getGlobalBounds().width/2,400); ans.push_back(t2);
		}
		for (int i=0;i<2;++i)
		{
			Sprite t2(texture[2]); t2.setPosition(window_width/2-t2.getGlobalBounds().width/2,400); ans.push_back(t2);
		}
		return ans;
	}
}

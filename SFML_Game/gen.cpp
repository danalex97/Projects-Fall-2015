#include <fstream>
using namespace std;

ofstream G("Utilities/patterns.txt");

void print_by_sequence(int a[])
{
	for (int i=0;a[i]<=20;++i)
	{
		for (int j=1;j<=a[i];++j) G<<"0";
		for (int j=1;j<=a[i];++j) G<<"1";
		for (int j=1;j<=a[i];++j) G<<"1";
		for (int j=1;j<=a[i];++j) G<<"0";
	}
	G<<'\n';
}

void turn_left(int k)
{
	while ( k-- )
	{
		for (int i=0;i<=20;++i) G<<"0";
		for (int i=0;i<=20;++i) G<<"10";
		for (int i=1;i<=20;++i) G<<"1";
	}
}

void turn_right(int k)
{
	while ( k-- )
	{
		for (int i=0;i<=20;++i) G<<"1";
		for (int i=0;i<=20;++i) G<<"01";
		for (int i=1;i<=20;++i) G<<"0";
	}
}

int s[10][100] = { 
	{ 10 , 21 } ,
	{ 20 , 10 , 21 } ,
	{ 5 , 21 } ,
	{ 1 , 1 , 2 , 3 , 5 , 8 , 21 } ,
	{ 3 , 3 , 5 , 21 } ,
	{ 10 , 12 , 5 , 21 } ,
	{ 15 , 15 , 3 , 5 , 8 , 5 , 21 } 
};

int main()
{
	//for (int i=0;i<4;++i) print_by_sequence(s[i]);
	//for (int i=0;i<7;++i) print_by_sequence(s[i]);
	for (int i=0;i<3;++i) print_by_sequence(s[i]);
	turn_left(1), G<<'\n';
	turn_left(2), turn_right(1) , G<<'\n';
	turn_right(1), G<<'\n';
	turn_right(2) , turn_left(1) , G<<'\n';
}

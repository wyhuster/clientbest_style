#define __USE_GNU
#define _GNU_SOURCE
#include <stdio.h>
#include <stdlib.h>
#include <math.h>
#include <string.h>


#include <sys/times.h>
#include <unistd.h>
#include <sched.h>
#include "main.h"
#include "config.h"

int cpu_num = 0;    //cpu num

extern void cpu_work(void);
extern void mem_work(void);
void read_config_file(char *filename)
{
	if(parse_config_file(filename) == -1)
	{
        printf("Please check if config filename are right.\n");
        exit(0);
	}

}

static void help()
{
    printf("[usage:] loader [-c|-m] -f config_file -h.\n");
    exit(-1);
}

int main( int argc, char *argv[])
{
    char config[81] = {'\0'};
    int cpu = 0;
    int mem = 0;
    /*parse command args*/
    int opt;
    char *opt_str = "hcmf:";/* -c -m -f config_file -h */
    while((opt = getopt(argc, argv, opt_str)) != -1){
        switch(opt)
        {
        case 'h':
            help();
        case 'f':
            strncpy(config,optarg,80);
            break;
        case 'c':
            cpu = 1;
            break;
        case 'm':
            mem = 1;
            break;
        default:
            printf("invalid arguments.\n");
            help();

        }
    }
    if(!cpu && !mem ){
        printf("You must special c[cpu] or m[mem].\n");
        help();
    }

    /*read config files*/
	read_config_file( config[0]? config : DEFAULT_CONFIG_FILENAME);
	cpu_num = sysconf(_SC_NPROCESSORS_CONF);
	debug_printf("We have %d processer(s).\n",cpu_num);
    if(cpu)
	    cpu_work(); /* main process will return */
    if(mem)
        mem_work();
}

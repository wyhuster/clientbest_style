#define _GNU_SOURCE
#include <stdio.h>
#include <stdlib.h>
#include <math.h>
#include <string.h>
#include <curses.h>


#include <sys/time.h>
#include <unistd.h>
#include <sched.h>
#include "main.h"
#include "config.h"

int thread_num = 0;  //thread numbers
int cpu_time = 0;    //cpu percent time

extern int cpu_num;    //cpu num


/*
 *get system's current time,by ms
 *
 * */
static double get_time()
{
    struct timeval tv;
    gettimeofday(&tv,NULL);
    return (tv.tv_sec * 1000 + tv.tv_usec * 1.0/1000); /*ms*/
}

static void* do_work(void *arg)
{
	sleep(1);// wait 1 second
	
	pid_t pid = getpid();
	cpu_set_t mask;
	CPU_ZERO(&mask);
	if (sched_getaffinity(pid,sizeof(mask),&mask)<0)
		printf("get process:%d affinity failed.\n",pid);

	for (int i = 0 ; i < cpu_num; i ++)
	{
		if (CPU_ISSET(i, &mask))
			printf("process:%d is running on processor %d.\n",pid,i);
	}


    double start,end,busy,idle;
    busy = cpu_time * 10;
    idle = (100 - cpu_time) * 10;
	while (1){
        start = get_time();
        while(get_time() - start <= busy);
        usleep(idle * 1000);
	}

}

static void get_cpu_config(void)
{
    	//print_all_vars();
	char *value = NULL;
	/* thread num**/
	value = get_config_var("thread_num");
	if(value)
		thread_num = atoi(value);
	if(thread_num <= 0) thread_num = 1;
    if(thread_num > cpu_num) thread_num = cpu_num;
	
	/* cpu time */
	value = get_config_var("cpu_time");
	if(value)
		cpu_time = atoi(value);
	if(cpu_time <= 0 || cpu_time > 100) cpu_time = 100;
	printf("Thread_num = %d, cpu_time = %d%\n",thread_num,cpu_time);	
}

void cpu_work()
{
    get_cpu_config();

    pid_t pid;
	for(int i = 0; i < thread_num; i++)
	{
		int err;
		cpu_set_t mask;

        pid = fork();
        if(pid < 0 ){
            printf("create the %d process failed.\n",i);
            continue;
        }
        if(pid == 0){ /* child process, set affinity on its cpu*/

            CPU_ZERO(&mask);
            CPU_SET(i%cpu_num,&mask);
            if(sched_setaffinity(0,sizeof(mask),&mask) == -1){
                printf("could not set process %l cpu affinity on cpu %d.\n",(long)getpid(),i%cpu_num);
                exit(1);/* error, child exit*/
            }else{
                do_work(NULL); /* won't return*/
            }
            break;
        }
	}

    /* main process will get here */
    /*XXX:we can show cpu utilization here*/
    return;
}



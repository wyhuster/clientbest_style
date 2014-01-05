#define _GNU_SOURCE
#include <stdio.h>
#include <stdlib.h>
#include <math.h>
#include <string.h>
#include <sys/time.h>
#include <unistd.h>
#include <sched.h>

//#define __DEBUG
#include "main.h"
#include "config.h"

#include "mem.h"
#define STEP 128 /*MB*/

static int mem_usage;
static int mem_wait = 1;//default is 5 second
static unsigned long page_size;
static void get_mem_config(void)
{

    char *value = NULL;
	/* mem usage */
	value = get_config_var("mem_usage");
	if(value)
		mem_usage = atoi(value);
	if(mem_usage <= 0 )
		mem_usage = 0;
	else if(mem_usage > 100) 
		mem_usage = 100;//we can't use all of the ram
    debug_printf("mem usaged:%d%\n",mem_usage);
    
    /*wait time*/
    value = get_config_var("mem_wait");
    if(value) 
        mem_wait = atoi(value);
    if(mem_wait < 1) mem_wait = 1; 
    debug_printf("mem sleep time :%d seconds.\n",mem_wait);
}

void mem_work()
{
    
    get_mem_config();
    page_size = getpagesize();
    debug_printf("page size is %lu kb.\n",page_size / KB);
//    void *max = NULL;
//   long i;
//    for(i = 2048 ; i >=0; i-- )
//    {
//       if(max = malloc(i *  STEP * MB )){
//           break;
//       }
//    }
//    long max_size = i * STEP * MB;
//    printf("Max memory we can malloc is 0x%lx: %d GB %d MB.\n",max_size, max_size /GB,(max_size % GB)/MB);
//    free(max);

//    char *block = NULL;
//    long count = 0;
//    while(1)
//    {
//    
//        block = malloc(MB);
//        if(!block){
//            printf("currently allocating %d GB %d MB.\n",count/1024, count%1024);
//            break;
//        }
//       memset(block,1,MB);
//       count ++;
//        if(count % 64 == 0)
//            printf("currently allocating %d GB %d MB.\n",count/1024, count%1024);
//    }

    MemInfo info;
    char *last_alloc = NULL;
    long last_size = 0;
    long need_alloc = 0;
    long need_more;

    get_meminfo(&info);
    const long need_used = info.MemTotal * mem_usage/ 100;
    const long delta = 20 >  info.MemTotal / 1000 ? 20 : info.MemTotal/1000;
    debug_printf("Ram TotalMem:%d MB, need used:%d MB.delta is %d Mb.\n",info.MemTotal,need_used,delta);
    while(1){
        get_meminfo(&info);
        need_more = need_used - info.MemUsed;

        if(need_more < delta && need_more > -delta){  /*needn't adjust*/
            debug_printf("we need't adjust.MemUsed is %lu, need_used is %lu, need_more is %ld.\n",info.MemUsed, need_used,need_more);
            sleep(1);   //just wait 1s
            continue;            /*don't need alloc more*/ 
        }

        need_alloc = last_size + need_more; /* totally we need to alloc*/

        if(last_alloc)free(last_alloc); /* free last alloced */

        if(need_alloc < delta) {
            debug_printf("mem is used more than what we expect.we just free mem if we have.\n",info.MemUsed, need_used,need_more);
            sleep(1);   //just wait 1s
           continue;            /*don't need alloc more*/ 
        }
        last_alloc = malloc(need_alloc * MB); /*shouldn't fail*/
        if(!last_alloc){
            debug_printf("malloc size %dMB faild.\n",need_alloc);
            last_size = 0;
            continue ;              /* failed!,maybe some used more, just continue, dont't wait*/
        }
        debug_printf("info.MemUsed:%dMb.malloc size %d MB success.\n",info.MemUsed,need_alloc);
        last_size = need_alloc;

		for(char *begin = (char *)ROUND_UP(last_alloc,page_size), /*aligned to page size, maybe fast*/
                *end = last_alloc + need_alloc * MB - 1; 
                begin < end  ; begin += page_size){ /* use every page */
			*begin = 1;
		}
        //memset(last_alloc,1,need_alloc * MB); /*use it,so we really have the ram*/
        sleep(mem_wait);   /*wait  */
    }
    return;
}




/*
 * mem.h
 * */

#ifndef _MEM_H
#define _MEM_H


#define KB (1024)
#define MB (KB * 1024)
#define GB (MB * 1024)
#define TB (GB * 1024)

#define ROUND_UP(value,size)  (((unsigned long)(value) + (size) - 1) & (~((unsigned long)size - 1)))

typedef struct{
   /* MB */ 
    unsigned long MemTotal,
                  MemFree,
                  MemUsed;
    unsigned long SwapTotal,
                  SwapFree,
                  SwapUsed;
}MemInfo;

int get_meminfo(MemInfo *info);
#endif
